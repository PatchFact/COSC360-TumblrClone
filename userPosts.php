<!DOCTYPE html>
<html lang="en">
<?php
// Include necessary files
require_once "head.php"; // Assumed to set up the page's head, like title, CSS links
require_once "Post.php";
require_once "Comment.php";
require_once "user.php"; // Assuming this contains the User class

// Check if a specific post ID was requested
if (isset($_GET['postId'])) {
    $postId = $_GET['postId'];
    $post = Post::getById($postId); // Assuming there's a method to fetch a single post by ID

    if (!$post) {
        // Redirect or show error if post not found
        header("Location: 404.php");
        exit();
    }

    $comments = Comment::getByPostId($postId);
} else {
    // Redirect or show error if no post ID is provided
    header("Location: 404.php");
    exit();
}
?>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <h2><?php echo htmlspecialchars($post->title); ?></h2>
        <img src="servePostImage.php?postId=<?php echo $post->post_id; ?>" alt="Post Image" style="max-width: 100%; height: auto;">
        <p><?php echo htmlspecialchars($post->body); ?></p>
        <hr>
        <h3>Comments</h3>
        <?php if (!empty($comments)): ?>
            <?php foreach ($comments as $comment): ?>
                <div class="comment">
                    <p><?php echo htmlspecialchars($comment->body); ?></p>
                    <small>Comment by: <?php 
                        $commentUser = User::getById($comment->user_id);
                        echo htmlspecialchars($commentUser->username);
                    ?></small>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No comments yet.</p>
        <?php endif; ?>
    </div>
</body>
</html>