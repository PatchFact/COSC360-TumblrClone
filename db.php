<?php
require_once "dbDetails.php";

$connectionString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
$dbuser = DBUSER;
$dbpass = DBPASS;

try {
    $pdo = new PDO($connectionString, $dbuser, $dbpass);
    return $pdo;
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
