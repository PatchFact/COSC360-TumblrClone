<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Home";
require "head.php";
?>

<?php include "navbar.php" ?>

<?php
if (isset($_SESSION['error_message'])) {
    $message = $_SESSION['error_message'];
    unset($_SESSION['error_message']);
    serverMessage("danger", $message);
}
?>

<body>
    <div class="main">
        <div class="feed ml-3">
            <h1>404 Not Found</h1>
            <p>Oops! The page you are looking for does not exist. It might have been moved or deleted.</p>
            <p>You can go back home <a href="index.php">here</a>.</p>
        </div>
    </div>
</body>

</html>