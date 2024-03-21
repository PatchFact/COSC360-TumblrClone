<?php
require "dbDetails.php";

$connectionString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME;
$dbuser = DBUSER;
$dbpass = DBPASS;

try {
    $pdo = new PDO($connectionString, $dbuser, $dbpass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
