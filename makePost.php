<!DOCTYPE html>
<html lang="en">
<?php
session_start();
require "head.php"; // Ensure this includes Bootstrap CSS for styling
require "db.php";

$pageTitle = "Ara Create Post";
$currentUserId = $_SESSION['user_id'] ?? null;

if ($currentUserId === null) {
    header("Location: loginPage.php");
    exit;
}

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Assuming validation and assignment of $title and $text are done here
    $title = isset($_POST['title-post']) ? $_POST['title-post'] : '';
    $text = isset($_POST['text-post']) ? $_POST['text-post'] : '';

    if (empty($title)) {
        $errors['title-post'] = "Please input a title";
    }

    if (empty($text)) {
        $errors['text-post'] = "Please input a text";
    }

    if (empty($errors)) {
        // Insert into database
        $stmt = $pdo->prepare("INSERT INTO posts (title, body, user_id) VALUES (:title, :body, :user_id)");
        if ($stmt->execute([':title' => $title, ':body' => $text, ':user_id' => $currentUserId])) {
            $_SESSION['success_message'] = "Post created successfully!";
            header("Location: makePost.php"); // Redirects back here to show the success message
            exit;
        } else {
            $errors['db'] = "An error occurred while saving the post.";
        }
    }
}
?>

<body>
    <?php require "navbar.php"; ?>
    <div class="container mt-5">
        <!-- Display Success Message -->
        <?php if (isset($_SESSION['success_message'])): ?>
            <div class="alert alert-success" role="alert">
                <?php echo $_SESSION['success_message']; ?>
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
