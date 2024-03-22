<?php

require 'dbDetails.php';

$host = DBHOST; 
$dbname = DBNAME;
$dbusername = DBUSER;
$dbpassword = DBPASS;

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $dbusername, $dbpassword);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

