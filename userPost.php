<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once "head.php";
require_once "Post.php";
require_once "Comment.php";
require_once "User.php";

if (isset($_GET['postId'])) {
    $postId = $_GET['postId'];
    $post = Post::getById($postId);

    if (!$post) {
        header("Location: 404.php");
        exit();
    }

    $comments = Comment::getByPostId($postId);
    $currentUser = isset($_SESSION['user_id']) ? User::getById($_SESSION['user_id']) : null;
} else {
    header("Location: 404.php");
    exit();
}

if (isset($_POST['submitComment'], $_POST['commentBody']) && $currentUser) {
    $commentBody = trim($_POST['commentBody']);
    if (!empty($commentBody)) {
        Comment::insertComment($commentBody, $currentUser->user_id, $postId);
        // Optional: Redirect to the same post page to see the new comment
        header("Location: ".$_SERVER['PHP_SELF']."?postId=".$postId);
        exit();
    }
}
?>

<head>
    <style>
        body {
            background-color: lightgray; /* Light gray background */
        }
        .container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            margin-top: 20px;
        }
        .post-container {
            text-align: center;
        }
        .post-image {
            width: 100%;
            max-width: 600px;
            height: auto;
            margin-bottom: 20px;
            object-fit: cover;
        }
        .post-details {
            background-color: #fff; /* White background for the text box */
            padding: 15px; /* Adds some space around the text */
            margin: 20px auto; /* Adds margin to the top and bottom, centers horizontally */
            box-shadow: 0 2px 4px rgba(0,0,0,0.1); /* Optional: adds a subtle shadow */
            border-radius: 8px; /* Optional: rounds the corners */
            max-width: 600px;
            text-align: left;
        }
        .comment {
            margin-bottom: 15px;
        }
        .edit-post-btn {
            display: inline-block; /* Allows for centering */
            text-align: center;
            margin-bottom: 20px; /* Spacing after the button */
        }
    </style>
</head>

<body>
    <?php require "navbar.php"; ?>
    <div class="container">
        <!-- Post and Caption Layout -->
        <div class="post-container">
            <h2 style="margin-bottom: 20px;"><?php echo htmlspecialchars($post->title); ?></h2>
            <img src="servePostImage.php?postId=<?php echo $post->post_id; ?>" alt="Post Image" class="post-image">
            <div class="post-details">
                <p><?php echo htmlspecialchars($post->body); ?></p>
                <?php if ($currentUser): ?>
                    <div class="edit-post-btn">
                        <a href="editPost.php?postId=<?php echo $post->post_id; ?>" class="btn btn-primary">Edit Post</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Comments Layout -->
        <hr>
        <h3>Comments</h3>
        <?php if ($currentUser): ?>
            <div class="add-comment">
                <form action="" method="POST">
                    <textarea name="commentBody" required placeholder="Write your comment here..." style="width: 100%; height: 100px; margin-bottom: 10px;"></textarea>
                    <button type="submit" name="submitComment" class="btn btn-primary">Submit Comment</button>
                </form>
            </div>
        <hr>
        <?php endif; ?>
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
