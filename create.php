<?php
//Start session
session_start();

//check if user is logged in, otherwise redirect to login p age
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

//include database connection
include('db.php');



//check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //sanitize task input
        $task = filter_var($_POST['todo'], FILTER_SANITIZE_STRING);

        //ensure task is not empty
        if(empty($task)){
                echo "Task cannot be empty";
                exit();
        }

        //Prepare the SQL statement
        $sql = "INSERT INTO todos (task, user_id) VALUES (:task, :user_id)";
        $stmt = $pdo->prepare($sql);

        //execute statement with parameters
        if ($stmt->execute(['task' => $task, 'user_id' => $_SESSION['user_id']])){
                //redirect to index.php if task added successfuly
                header("Location: index.php");
                exit();
        } else {
                echo "Error adding task";
        }

}
?>
