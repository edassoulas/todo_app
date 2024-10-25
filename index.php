<?php
//to start session
session_start();

//Include database connection
include('db.php');

//check if the user  is logged in
if (!isset($_SESSION['user_id'])){
        header("Location: login.php"); //redirect to login if not authenticated
        exit();
}

//to fetch to-do items from the database
$sql = "SELECT * FROM todos WHERE user_id = :user_id";
$stmt = $pdo->prepare($sql);
$stmt->execute(['user_id' => $_SESSION['user_id']]);
$todos = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>

        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width", initial-scale=1.0">
        <title> To-Do List</title>
</head>
<body>
        <h1>My To-Do List</h1>
        <form action="create.php" method="POST">
                <input type="text" name="todo" placeholder="New to-do item" required>
                <button type="submit">Add</button>
        </form>

        <h2>Your Tasks:</h2>
        <ul>
                <?php foreach ($todos as $todo): ?>
                        <li>
                                <?=htmlspecialchars($todo['task']) ?>
                                <a href="update.php?id=<?= $todo['id'] ?>">Edit</a>
                                <a href="delete.php?id=<?= $todo['id'] ?>" onclick="return confirm('Are you sure you want to delete this task')">Delete</a>
                        </li>
                <?php endforeach; ?>
        </ul>

        <a href="logout.php">Logout</a> <!-- Add a logout link -->
</body>
</html>
