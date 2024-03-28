<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require_once "db.php";
require_once "head.php";
require_once "user.php";
require_once "post.php";

$postId = isset($_GET['postId']) ? (int)$_GET['postId'] : 0;
$currentUserId = $_SESSION['user_id'] ?? null;

if ($currentUserId === null || $postId <= 0) {
    header("Location: 404.php");
    exit;
}

$post = Post::getById($postId);
$errors = [];

// 2MB maximum filesize
$maxsize = 2 * 1024 * 1024;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title-post']) ? $_POST['title-post'] : '';
    $text = isset($_POST['text-post']) ? $_POST['text-post'] : '';
    $imgData = isset($_FILES['image-post']) ? file_get_contents($_FILES['image-post']['tmp_name']) : null;
    if ($imgData && $_FILES['image-post']['size'] > $maxsize) {
        $errors['image-post'] = "Error: File size is larger than the allowed limit.";
    }
    if (empty($title)) {
        $errors['title-post'] = "Please input a title";
    }

    if (empty($text)) {
        $errors['text-post'] = "Please input a text";
    }

    if (empty($errors)) {
        $stmt = $pdo->prepare("UPDATE posts SET title = :title, body = :body WHERE post_id = :post_id");
        $success = $stmt->execute([':title' => $title, ':body' => $text, ':post_id' => $postId]);

        if ($success && $imgData) {
            $stmtImgDelete = $pdo->prepare("DELETE FROM post_img WHERE post_id = :post_id");
            $stmtImgDelete->execute([':post_id' => $postId]);

            $stmtImg = $pdo->prepare("INSERT INTO post_img (post_id, img_src) VALUES (:post_id, :img_src)");
            $stmtImg->execute([':post_id' => $postId, ':img_src' => $imgData]);
        }

        $_SESSION['success_message'] = "Post updated successfully!";
        header("Location: editPost.php?postId=" . $postId);
        exit;
    }
}
?>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <?php if (isset($_SESSION['success_message'])) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success_message']; ?>
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-4">Edit Post</h2>
                <form id="postForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?postId=" . $postId; ?>" method="post" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title-post" class="form-label">Title:</label>
                        <input type="text" class="form-control" id="title-post" name="title-post" value="<?php echo htmlspecialchars($post->title); ?>" placeholder="Enter post title">
                        <span class="text-danger"><?php echo $errors['title-post'] ?? ''; ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="image-post" class="form-label">Image:</label>
                        <input type="file" class="form-control" id="image-post" name="image-post" accept="image/*">
                        <span class="text-danger"><?php echo $errors['image-post'] ?? ''; ?></span>
                    </div>
                    <div class="mb-3">
                        <label for="text-post" class="form-label">Text:</label>
                        <textarea class="form-control" id="text-post" name="text-post" rows="3" placeholder="Enter text"><?php echo htmlspecialchars($post->body); ?></textarea>
                        <span class="text-danger"><?php echo $errors['text-post'] ?? ''; ?></span>
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Post</button>
                        <a href="<?php 
                            $referer = htmlspecialchars($_SERVER['HTTP_REFERER']);
                            if (strpos($referer, 'admin.php') !== false) {
                                echo 'admin.php';
                            } elseif (strpos($referer, 'userPost.php') !== false) {
                                echo "userPost.php?postId=" . $post->post_id;
                            } else {
                                echo 'index.php';
                            }
                        ?>" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>