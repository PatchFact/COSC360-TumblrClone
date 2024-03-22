<?php
require "dbDetails.php";

$dbhost = "cosc360.ok.ubc.ca";
$dbname = "db_18288647";
$dbuser = "18288647";
$dbpass = "18288647";

try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname;charset=utf8mb4", $dbuser, $dbpass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}

