?php
//start the session
session_start();

//include database connection
include('db.php');

//check if user is logged in
if (!isset($_SESSION['user_id'])) {
        header("Location: login.php"); //redirect to login if not authenticated
        exit();
}

//check if the task ID is provided
if (isset($_GET['id'])) {
        $task_id = $_GET['id'];

        //prepare the SQL statement to delete the task
        $sql = "DELETE FROM todos WHERE id = :task_id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);

        //bind params securely to prent SQL injection
        $stmt->bindParam(':task_id', $task_id);
        $stmt->bindParam(':user_id', $_SESSION['user_id']); //which ensures oly users can delete their own tasks

        //execute the query and handle errors
        try {
           if ($stmt->execute()){
                //redirect back to index.php after succesful deletion
                header("Location: index.php");
                exit();
           } else {
                echo "Error: Task could not be deleted";
           }
        } catch (PDOException $e) {
                echo "Error: " . $e->getMessage(); //to catch any database errors and display them
        }

} else {
        //if no ID is provided show the erroe message:
        die("No ID specified");
}
?>
