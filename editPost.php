<?php
require 'db.php';
require 'head.php';
session_start();

// Security checks here (ensure the user is logged in and has permission to edit the post)

$postId = isset($_GET['postId']) ? (int)$_GET['postId'] : 0;

if ($postId > 0) {
    $stmt = $pdo->prepare("SELECT title, body FROM posts WHERE post_id = :postId");
    $stmt->execute([':postId' => $postId]);
    $post = $stmt->fetch();

    if ($post) {
        echo "<form action='editPost.php?postId=" . htmlspecialchars($postId) . "' method='post'>
                <input type='text' name='title' value='" . htmlspecialchars($post['title']) . "'>
                <textarea name='body'>" . htmlspecialchars($post['body']) . "</textarea>
                <input type='submit' value='Update Post'>
              </form>";
    } else {
        echo "Post not found.";
    }
} else {
    echo "Invalid post ID.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $postId > 0) {
    // Again, include security checks as appropriate

    $title = $_POST['title'] ?? '';
    $body = $_POST['body'] ?? '';

    $stmt = $pdo->prepare("UPDATE posts SET title = :title, body = :body WHERE post_id = :postId");
    $result = $stmt->execute([
        ':title' => $title,
        ':body' => $body,
        ':postId' => $postId
    ]);

    if ($result) {
        echo "Post updated successfully.";
        // Redirect or provide a link back to the admin page
    } else {
        echo "An error occurred while updating the post.";
    }
}

?>
