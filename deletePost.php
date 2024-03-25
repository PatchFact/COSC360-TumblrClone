<?php
require 'db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to perform this action.";
    exit;
}

$postId = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;

if ($postId > 0) {
    $pdo->beginTransaction();
    
    try {
        $stmtImg = $pdo->prepare("DELETE FROM post_img WHERE post_id = :postId");
        $stmtImg->execute([':postId' => $postId]);

        // Next, delete the post itself
        $stmtPost = $pdo->prepare("DELETE FROM posts WHERE post_id = :postId");
        $stmtPost->execute([':postId' => $postId]);

        $pdo->commit();
        echo "Post and associated images deleted successfully.";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "An error occurred while deleting the post and associated images: " . $e->getMessage();
    }

} else {
    echo "Invalid post ID.";
}

header("Location: admin.php");
?>

