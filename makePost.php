<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require "head.php"; // Ensure this includes Bootstrap CSS for styling
require "db.php";

$pageTitle = "Ara Create Post";
$currentUserId = $_SESSION['user_id'] ?? null;

if ($currentUserId === null) {
    header("Location: 404.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = isset($_POST['title-post']) ? $_POST['title-post'] : '';
    $text = isset($_POST['text-post']) ? $_POST['text-post'] : '';
    $imgData = null;

    if (empty($title)) {
        $errors['title-post'] = "Please input a title";
    }

    if (empty($text)) {
        $errors['text-post'] = "Please input a text";
    }

    if (isset($_FILES['image-post']) && $_FILES['image-post']['error'] === 0) {
        $imgData = file_get_contents($_FILES['image-post']['tmp_name']);
        // Add any necessary validation for the file here
    } else {
        $errors['image-post'] = "Error uploading the image";
    }

    if (empty($errors)) {
        // Insert post text into database
        $stmt = $pdo->prepare("INSERT INTO posts (title, body, user_id) VALUES (:title, :body, :user_id)");
        $success = $stmt->execute([':title' => $title, ':body' => $text, ':user_id' => $currentUserId]);

        if ($success && $imgData) {
            $lastPostId = $pdo->lastInsertId();
            // Insert image data into the `post_img` table
            $stmtImg = $pdo->prepare("INSERT INTO post_img (post_id, img_src) VALUES (:post_id, :img_src)");
            $stmtImg->execute([':post_id' => $lastPostId, ':img_src' => $imgData]);
        }

        $_SESSION['success_message'] = "Post created successfully!";
        header("Location: makePost.php");
        exit;
    }
}
?>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <!-- Display Success Message -->
        <?php if (isset($_SESSION['success_message'])) : ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success_message']; ?>
                >>>>>>> cef50b75951aa8ea31ab144593166725af6c6e65
            </div>
            <?php unset($_SESSION['success_message']); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-md-8 offset-md-2">
                <h2 class="mb-4">Create a New Post</h2>
                <form id="postForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
                    <!-- Title -->
                    <div class="mb-3">
                        <label for="title-post" class="form-label">Title:</label>
                        <input type="text" class="form-control" id="title-post" name="title-post" placeholder="Enter post title">
                        <span class="text-danger"><?php echo $errors['title-post'] ?? ''; ?></span>
                    </div>

                    <!-- Image -->
                    <div class="mb-3">
                        <label for="image-post" class="form-label">Image:</label>
                        <input type="file" class="form-control" id="image-post" name="image-post" accept="image/*">
                        <span class="text-danger"><?php echo $errors['image-post'] ?? ''; ?></span>
                    </div>

                    <!-- Text -->
                    <div class="mb-3">
                        <label for="text-post" class="form-label">Text:</label>
                        <textarea class="form-control" id="text-post" name="text-post" rows="3" placeholder="Enter text"></textarea>
                        <span class="text-danger"><?php echo $errors['text-post'] ?? ''; ?></span>
                    </div>

                    <!-- Post Button -->
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
            </div>
        </div>
    </div>
</body>

</html>