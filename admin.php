<!DOCTYPE html>
<html lang="en">

<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$pageTitle = "Ara Admin";
require 'head.php';
require 'db.php'; // Adjust the path as necessary

$currentUserId = $_SESSION['user_id'] ?? null; // Use null coalescing operator as a placeholder

if ($currentUserId === null) {
    // Redirect to login page if there is no user_id in the session (i.e., not logged in)
    header("Location: 404.php");
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