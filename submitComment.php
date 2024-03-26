<?php
session_start();
require "comment.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: loginPage.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$post_id = $_POST['post_id'] ?? null;
$comment = $_POST['comment'] ?? '';

if ($post_id && $comment) {
    $insertedCommentId = Comment::insertComment($comment, $user_id, $post_id);

    if (!$insertedCommentId) {
        $_SESSION['error_message'] = "Failed to submit comment.";
    }
} else {
    $_SESSION['error_message'] = "Invalid comment data.";
}

header("Location: index.php");
exit;
