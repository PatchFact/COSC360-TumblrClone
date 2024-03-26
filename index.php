<!DOCTYPE html>
<html lang="en">
<?php
$pageTitle = "Ara Home";
require_once "head.php";
require_once "user.php";
require_once "post.php";

// Check if a search term was submitted
$searchTerm = isset($_POST['search']) ? $_POST['search'] : null;

// Fetch posts based on whether a search term was provided
$posts = $searchTerm ? Post::searchByKeyword($searchTerm) : Post::fetchAll();
?>

<body>
    <?php require "navbar.php"; ?>
    <div class="main">
        <?php
        include "sidebarComponent.php";
        ?>

        <article id="feed">
            <h2>Feed</h2>
            <?php foreach ($posts as $post) : ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($post->title); ?></h3>
                    <p><?php echo htmlspecialchars($post->body); ?></p>
                    <small>Posted by:
                        <?php
                        $user = User::getById($post->user_id);
                        echo htmlspecialchars($user->username);
                        ?>
                    </small>
                    <form action="submitComment.php" method="post">
                        <input type="hidden" name="post_id" value="<?php echo $post->post_id; ?>">
                        <textarea name="comment" placeholder="Write a comment..." required></textarea>
                        <br><button type="submit">Submit Comment</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </article>

        <article id="search-bar">
            <!-- This input fields are now wrapped within the form tags -->
            <input type="text" name="search" placeholder="Search posts">
            <!-- Removed filter input for clarity since it's not used in the PHP code -->
            <button type="submit">Search</button>
        </article>
    </div>
</body>

</html>