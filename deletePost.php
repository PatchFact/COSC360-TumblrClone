<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to perform this action.";
    exit;
}

$postId = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;

if ($postId > 0) {
    $stmt = $pdo->prepare("DELETE FROM posts WHERE post_id = :postId");
    $result = $stmt->execute([':postId' => $postId]);

    if ($result) {
        echo "Post deleted successfully.";
    } else {
        echo "An error occurred while deleting the post.";
    }
} else {
    echo "Invalid post ID.";
}

header("Location: admin.php");
?>
