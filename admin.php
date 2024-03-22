<!DOCTYPE html>
<html lang="en">

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "Ara Admin";
require 'head.php';
require 'db.php';

$currentUserId = $_SESSION['user_id'] ?? null;

if ($currentUserId === null) {
    header("Location: loginPage.php");
    exit;
}

$query = "SELECT is_admin FROM users WHERE user_id = :userId";
$stmt = $pdo->prepare($query);
$stmt->execute([':userId' => $currentUserId]);
$result = $stmt->fetch();

if ($result === false) {
    header("Location: loginPage.php");
    exit;
}

if (!$result['is_admin']) {
    header("Location: index.php");
    exit;
}
?>

<body>
    <?php require "navbar.php"; ?>

    <div class="container mt-5">
        <div id="search-section" class="mb-3">
            <h2 class="mb-3">Admin Dashboard</h2>
            <div class="input-group mb-3">
                <input type="text" id="search-input" class="form-control" placeholder="Search users or posts" aria-label="Search users or posts" aria-describedby="button-addon2">
                <button class="btn btn-outline-secondary" type="button" id="search-button">Search</button>
            </div>
            <div id="search-results"></div>
        </div>
    </div>
</body>
</html>