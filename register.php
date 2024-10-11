<?php
//start session
session_start();

//include database connection
include('db.php');

//debug statement
if ($pdo) {
        echo "Database connection successful";
} else {
        echo "Database connection failed";
}

//initilize variables
$username = '';
$password = '';
$confirm_password = '';
$error = '';
$success = '';

//check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //get the username and passwords from the form
        $username = $_POST['username'];
        $password = $_POST['password'];
        $confirm_password = $_POST['confirm_password'];

        //validate form input
  if (empty($username) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required.";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        // Check if username already exists
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['username' => $username]);
        $user = $stmt->fetch();
        if ($user) {
            $error = "Username already taken. Please choose a different one.";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            //debugging output to verify the hashed password
            echo "Hashed password: " . $hashed_password; //which should show hashed password

            // Insert new user into the database
            $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute(['username' => $username, 'password' => $hashed_password]);

            $success = "Registration successful! You can now <a href='login.php'>login</a>.";
        }
    }
}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <?php if ($error): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>
    <?php if ($success): ?>
        <p style="color: green;"><?= $success ?></p>
    <?php else: ?>
    <form method="POST" action="register.php">
        <label for="username">Username:</label>
        <input type="text" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" name="password" required>
        <br>
        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" required>
        <br>
        <button type="submit">Register</button>
    </form>
    <?php endif; ?>
</body>
</html>
?>
