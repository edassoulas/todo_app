<?php
// include database connection
include('db.php');

// Test Query
$sql = "SELECT * FROM users";
$stmt = $pdo->prepare($sql);
$stmt->execute();

$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
foreach ($users as $user) {
    echo "Username: " . htmlspecialchars($user['username']) . "<br>";
}
?>

