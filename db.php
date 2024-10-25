<?php
//echo "db.php is included"; //debugging statement
try {
        //create new PDO instance
        $pdo = new PDO('mysql:host=localhost;dbname=todo_app', 'root', 'password');

        //set error mode to exceptions
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //echo "Connected successfuly"; //debug stmt for successful connection

} catch (PDOException $e) {
        //output error message is connection fails
        echo 'Connection failed: ' . $e->getMessage();
        exit();
}
?>

