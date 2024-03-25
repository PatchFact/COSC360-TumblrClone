<?php
session_start();
require "db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: loginPage.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'] ?? null;
$comment = $_POST['comment'] ?? '';

if ($post_id && $comment) {
    $stmt = $pdo->prepare("INSERT INTO comments (body, user_id, post_id, visible, created_at) VALUES (:body, :user_id, :post_id, 1, CURRENT_TIMESTAMP)");
    if (!$stmt->execute([':body' => $comment, ':user_id' => $user_id, ':post_id' => $post_id])) {
        // Handle error
        $_SESSION['error_message'] = "Failed to submit comment.";
    }
} else {
    // Handle error
    $_SESSION['error_message'] = "Invalid comment data.";
}

header("Location: index.php"); // Adjust if your home page has a different name
exit;
?>
