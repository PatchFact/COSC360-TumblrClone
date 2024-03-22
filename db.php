<?php
define("DBHOST", "cosc360.ok.ubc.ca");
define("DBNAME", "db_18288647");
define("DBUSER", "18288647");
define("DBPASS", "18288647");

$connectionString = "mysql:host=" . DBHOST . ";dbname=" . DBNAME ";charset=utf8mb4";
$dbuser = DBUSER;
$dbpass = DBPASS;

try {
    $pdo = new PDO($connectionString, $dbuser, $dbpass);
} catch (\PDOException $e) {
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}
