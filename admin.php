<!DOCTYPE html>
<html lang="en">

<?php
session_start(); // Start the session at the beginning

$pageTitle = "Ara Admin";
require 'head.php';

// Include your database connection file here
require 'db.php'; // Adjust the path as necessary

$currentUserId = $_SESSION['user_id'] ?? null; // Use null coalescing operator as a placeholder

if ($currentUserId === null) {
    // Redirect to login page if there is no user_id in the session (i.e., not logged in)
    header("Location: loginPage.php");
    exit;
}

// Check if the current user is an admin
$query = "SELECT is_admin FROM users WHERE user_id = :userId";
$stmt = $pdo->prepare($query);
$stmt->execute([':userId' => $currentUserId]);
$result = $stmt->fetch();

if ($result === false) {
    // Handle user not found or not logged in
    header("Location: loginPage.php");
    exit;
}

if (!$result['is_admin']) {
    // Redirect non-admin users
    header("Location: index.php");
    exit;
}

// Proceed with page content for admins
?>

<body>
    <?php require "navbar.php" ?>

    <div id="main">
        
    </div>
    <div id="search-section">
    <input type="text" id="search-input" placeholder="Search users or posts">
    <button id="search-button">Search</button>
    <div id="search-results"></div>
</div>
</body>

</html>
