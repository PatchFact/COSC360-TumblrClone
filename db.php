<?php
$host = 'cosc360.ok.ubc.ca/'; // Often this is 'localhost' or a specific server address or IP
$dbname = 'db_18288647';
$username = '18288647';
$password = '18288647';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
