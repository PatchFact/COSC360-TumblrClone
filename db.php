<?php
require "dbDetails.php";

$dbhost = DBHOST;
$dbname = DBNAME;
$dbuser = DBUSER;
$dbpass = DBPASS;

try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

