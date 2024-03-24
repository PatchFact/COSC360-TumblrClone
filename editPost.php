<?php
require 'db.php';
require 'head.php';

$postId = isset($_GET['postId']) ? (int)$_GET['postId'] : 0;

if ($postId > 0) {
    $stmt = $pdo->prepare("SELECT title, body FROM posts WHERE post_id = :postId");
    $stmt->execute([':postId' => $postId]);
    $post = $stmt->fetch();

    if ($post) {
        echo "<div class='container mt-5'>
        <h2>Edit Post</h2>
        <form action='editPost.php?postId=" . htmlspecialchars($postId) . "' method='post'>
            <div class='mb-3'>
                <label for='title' class='form-label'>Title</label>
                <input type='text' class='form-control' name='title' id='title' value='" . htmlspecialchars($post['title']) . "' required>
            </div>
            <div class='mb-3'>
                <label for='body' class='form-label'>Body</label>
                <textarea class='form-control' name='body' id='body' rows='3' required>" . htmlspecialchars($post['body']) . "</textarea>
            </div>
            <button type='submit' class='btn btn-primary'>Update Post</button>
            <a href='admin.php' class='btn btn-secondary'>Cancel</a>
        </form>
      </div>";

    } else {
        echo "<div class='container mt-5'><p>Post not found.</p></div>";
    }
} else {
    echo "<div class='container mt-5'><p>Invalid post ID.</p></div>";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $postId > 0) {
    $title = $_POST['title'] ?? '';
    $body = $_POST['body'] ?? '';

    $stmt = $pdo->prepare("UPDATE posts SET title = :title, body = :body WHERE post_id = :postId");
    $result = $stmt->execute([
        ':title' => $title,
        ':body' => $body,
        ':postId' => $postId
    ]);

    if ($result) {
        echo "<script>window.location.href = 'admin.php';</script>";
    } else {
        echo "<div class='container mt-5'><p>An error occurred while updating the post.</p></div>";
    }
}
?>

