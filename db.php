<?php
require 'dbDetails.php';

try {
    $pdo = new PDO("mysql:host=" . DBHOST . ";dbname=" . DBNAME . ";charset=utf8mb4", DBUSER, DBPASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
