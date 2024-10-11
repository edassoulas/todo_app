<?php
// include database connection
include('db.php');

$username = 'user1';
$plain_password = 'password1'; // The current password you want to hash
$hashed_password = password_hash($plain_password, PASSWORD_DEFAULT);

//to check hashed password
echo "Hashed password: " . $hashed_password . "<br>";

// Update the password in the database
$sql = "UPDATE users SET password = :password WHERE username = :username";
$stmt = $pdo->prepare($sql);
$success = $stmt->execute(['username' =>, 'password' => $hashed_password]);

//check if update was successful
if ($success) {
        echo "Password updated successfully";
} else {
        echo "Failed to  update password";
}

?>
