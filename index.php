<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Home";
require "head.php";
require "db.php";

try {
    $stmt = $pdo->query("SELECT p.post_id, p.title, p.body, u.username FROM posts p JOIN users u ON p.user_id = u.user_id WHERE visible = 1 ORDER BY p.created_at DESC");
    $posts = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    $posts = [];
    error_log("Error fetching posts: " . $e->getMessage());
}
?>


<body>
    <form action="search.php" method="post" style="width: fit-content"></form>
    <?php require "navbar.php" ?>
    <div class="main">
        <?php
        include "sidebarComponent.php";
        ?>

        <article id="feed">
            <h2>Feed</h2>
            <?php foreach ($posts as $post) : ?>
                <div class="post">
                    <h3><?php echo htmlspecialchars($post['title']); ?></h3>
                    <p><?php echo htmlspecialchars($post['body']); ?></p>
                    <small>Posted by: <?php echo htmlspecialchars($post['username']); ?></small>

                    <!-- Comment Form for each post -->
                    <form action="submitComment.php" method="post">
                        <input type="hidden" name="post_id" value="<?php echo $post['post_id']; ?>">
                        <textarea name="comment" placeholder="Write a comment..." required></textarea>
                        <br><button type="submit">Submit Comment</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </article>

        <article id="search-bar">
            <input text="text" name="search" placeholder="Search posts">
            <input text="text" name="filter" placeholder="Filter tags">
        </article>
        </form>
    </div>
</body>

</html>