<?php
//start the session
session_start();

//include the database connection
include('db.php');

//check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //Get the task ID and updated task from the form
        $task_id = $_POST['id'];
        $task = $_POST['todo'];
        $completed = isset($_POST['completed']) ? 1 :0; //checkbox for marking task as done

        //prepare the SQL Statement
        $sql = "UPDATE todos SET task = :task, is_done = :completed  WHERE id = :task_id AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);

        //bind parameters and execute the query
        try {
                $stmt->execute([
                        'task' => $task, 'completed' => $completed, 'task_id' => $task_id, 'user_id' => $_SESSION['user_id']
                ]);
        //redirect back to index.php
        header("Location: index.php");
        exit();
        } catch (PDOException $e) {
                echo "Error: " . $e->getMessage();
        }
}

//fetch the existing task to edit
if (isset($_GET['id'])) {
        $task_id = $_GET['id'];

        //Prepare the SQL statement to fetch the task
        $sql = "SELECT * FROM todos WHERE id = :task_id  AND user_id = :user_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['task_id' => $task_id, 'user_id' => $_SESSION['user_id']]);
        $todo = $stmt->fetch();

        if (!$todo) {
                die("Task not found");
        }
} else {
                die("No ID specified");
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <title>Update To-Do</title>
</head>
<body>
        <h1>Update To-Do</h1>
        <form method="POST" action="update.php">
                <input type="hidden" name="id" value="<?php echo $todo['id']; ?>">
                <label for="todo">Task:</label>
                <input type="text" name="todo" value="<?php echo $todo['task']; ?>" required>
                <label for="completed">Completed:</label>
                <input type="checkbox" name="completed" <?php if ($todo['is_done']) echo 'checked'; ?>>
                <button type="submit">Update</button>
        </form>
</body>
</html>
