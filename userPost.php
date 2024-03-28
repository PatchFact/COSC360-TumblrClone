<!DOCTYPE html>
<html lang="en">
<?php
require_once "head.php";
require_once "post.php";
require_once "comment.php";
require_once "user.php";

if (isset($_GET['postId'])) {
    $postId = $_GET['postId'];
    $post = Post::getById($postId);

    if (!$post) {
        header("Location: 404.php");
        exit();
    }

    $currentUser = isset($_SESSION['user_id']) ? User::getById($_SESSION['user_id']) : null;
    $poster = User::getById($post->user_id);
} else {
    header("Location: 404.php");
    exit();
}

if (isset($_POST['submitComment'], $_POST['commentBody']) && $currentUser) {
    $commentBody = trim($_POST['commentBody']);
    if (!empty($commentBody)) {
        Comment::insertComment($commentBody, $currentUser->user_id, $postId);
        header("Location: " . $_SERVER['PHP_SELF'] . "?postId=" . $postId);
        exit();
    }
}
?>

<?php
$imageSource = Post::getImageSource($post->post_id);
?>

<body>
    <?php require "navbar.php"; ?>
    <div class="container">
        <div class="post-container">
            <h2 style="margin-bottom: 20px;"><?php echo htmlspecialchars($post->title); ?></h2>

            <?php if ($imageSource) : ?>
                <img src="servePostImage.php?postId=<?php echo $post->post_id; ?>" alt="Post Image" class="post-image">
            <?php else : ?>
                <p></p>
            <?php endif; ?>
            
            <div class="post-details">
                <p><?php echo htmlspecialchars($post->body); ?></p>
                <?php if ($currentUser == $poster) : ?>
                    <div class="edit-post-btn">
                        <a href="editPost.php?postId=<?php echo $post->post_id; ?>" class="btn btn-primary">Edit Post</a>
                    </div>
                <?php endif; ?>
            </div>
            <p>Posted by: <a href="profile.php?userId=<?php echo $poster->user_id; ?>"><?php echo htmlspecialchars($poster->username); ?></a></p>
        </div>

        <hr>
        <h3>Comments</h3>
        <?php if ($currentUser) : ?>
            <div class="add-comment">
                <form action="" method="POST">
                    <textarea name="commentBody" required placeholder="Write your comment here..." style="width: 100%; height: 100px; margin-bottom: 10px;"></textarea>
                    <button type="submit" name="submitComment" class="btn btn-primary">Submit Comment</button>
                </form>
            </div>
            <hr>
        <?php endif; ?>

        <div id="comments-section">
            <!-- AJAX HERE -->
        </div>
    </div>
</body>

<script>
    $(document).ready(function() {
        function fetchComments(post_id) {
            $.ajax({
                url: "fetchComments.php",
                type: "GET",
                data: {
                    postId: post_id,
                },
                success: function(data) {
                    var comments = JSON.parse(data);
                    var commentsHtml = "";

                    comments.forEach(function(comment) {
                        commentsHtml +=
                            '<div class="comment"><p>' +
                            comment.body +
                            "</p><small>Comment by: " +
                            comment.username +
                            "</small></div>";
                    });

                    $("#comments-section").html(commentsHtml);
                },
            });
        }

        fetchComments(<?php echo $postId; ?>);
        setInterval(function() {
            fetchComments(<?php echo $postId; ?>);
        }, 1000);
    });
</script>

</html>