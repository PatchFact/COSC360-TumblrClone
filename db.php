<?php
$dbhost = 'cosc360.ok.ubc.ca'; // Removed the trailing slash
$dbname = 'db_18288647';
$dbusername = '18288647';
$dbpassword = '18288647';

try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4", $dbusername, $dbpassword);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
