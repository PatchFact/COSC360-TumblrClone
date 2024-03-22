<?php
$host = 'cosc360.ok.ubc.ca'; 
$dbname = 'db_18288647';
$dbusername = '18288647';
$dbpassword = '18288647';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

