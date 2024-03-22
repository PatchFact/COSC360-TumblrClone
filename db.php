<?php
$host = 'cosc360.ok.ubc.ca'; // Removed the trailing slash
$dbname = 'db_18288647';
$username = '18288647';
$password = '18288647';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

