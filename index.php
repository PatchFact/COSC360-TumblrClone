<!DOCTYPE html>
<html lang="en">
<?php
$pageTitle = "Ara Home";
require_once "head.php";
require_once "user.php";
require_once "post.php";

$searchTerm = isset($_POST['search']) ? $_POST['search'] : null;

$posts = $searchTerm ? Post::searchByKeyword($searchTerm) : Post::fetchAll();
?>

<body>
    <?php require "navbar.php"; ?>
    <div class="container-fluid mt-3">
        <div class="row">
            <div class="col-md-2">
                <?php include "sidebarComponent.php"; ?>
            </div>
            
            <div class="col-md-10">
                <article id="feed">
                    <h2>Feed</h2>
                    <div class="row">
                        <?php foreach ($posts as $post) : ?>
                            <?php
                            $user = User::getById($post->user_id);
                            ?>
                            <div class="col-9 mb-3">
                                <a href="temporary.php?postId=<?php echo $post->post_id; ?>" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-2 border rounded bg-light">
                                        <img src="serveProfilePic.php?userId=<?php echo $user->user_id ?>" alt="User Profile" class="mr-3" style="width: 50px; height: 50px; border-radius: 50%;">
                                        <h3 class="mb-0 text-dark"><?php echo htmlspecialchars($post->title); ?></h3>
                                    </div>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </article>
            </div>
        </div>
    </div>
</body>

</html>
