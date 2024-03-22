<?php
require 'db.php';
session_start();

// Check if the current user is an admin
/*$query = "SELECT is_admin FROM users WHERE user_id = :userId";
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
*/
if (!isset($_SESSION['user_id'])) {
    echo "You must be logged in to perform this action.";
    exit;
}

$postId = isset($_POST['post_id']) ? (int)$_POST['post_id'] : 0;

if ($postId > 0) {
    // Prepare the delete statement to avoid SQL injection
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
