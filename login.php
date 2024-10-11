?php
//start session
session_start();

//include database connection
include('db.php');

//initialize variables
$username = '';
$password = '';
$error = '';

//check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST"){
        //get username and password from form
        $username = $_POST['username'];
        $password = $_POST['password'];

        //prepare SQL statment to check for the user
        $sql = "SELECT * FROM users WHERE username = :username";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':username', $username); //usebindParam to bind parameters duh
        $stmt->execute();
        $user = $stmt->fetch();

        //verify the password
        if ($user && password_verify($password, $user['password'])) {
                //set session variables
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];

                //redirect to the index page
                header("Location: index.php");
                exit();
        } else {
                //set error message for invalid creds
                $error = "Invalid username or  password";
        }

}
?>

<!DOCTYPE html>
<html lang="en">
<head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>
</head>
<body>
        <h1>Login</h1>
        <?php if ($error): ?>
                <p style="color: red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
        <form method="POST" action="login.php">
                <label for="username">Username:</label>
                <input type="text" name="username" required>
                <br>
                <label for="password">Password:</label>
                <input type="password" name="password" required>
                <br>
                <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
