<!DOCTYPE html>
<html lang="en">
<?php
$pageTitle = "Ara Home";
require_once "head.php";
require_once "user.php";
require_once "post.php";

$searchUserTerm = isset($_POST['searchUser']) ? $_POST['searchUser'] : "";
$searchPostTerm = isset($_POST['searchPost']) ? $_POST['searchPost'] : null;

$users = $searchUserTerm ? User::searchByUsername($searchUserTerm) : User::fetchAll();
$posts = $searchPostTerm ? Post::searchByKeyword($searchPostTerm) : Post::fetchAll();
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
                        <div class="col-12 mb-3">
                            <form method="POST" action="">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="searchPost" placeholder="Search posts" value="<?php echo htmlspecialchars($searchPostTerm); ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 mb-3" style="max-height: 300px; overflow-y: scroll;">
                            <?php $postCount = 0; ?>
                            <?php foreach ($posts as $post) : ?>
                                <?php
                                $user = User::getById($post->user_id);
                                ?>
                                <a href="userPost.php?postId=<?php echo $post->post_id; ?>" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-2 border rounded bg-light">
                                        <img src="serveProfilePic.php?userId=<?php echo $user->user_id ?>" alt="User Profile" class="mr-3" style="width: 50px; height: 50px; border-radius: 50%;">
                                        <h3 class="mb-0 text-dark"><?php echo htmlspecialchars($post->title); ?></h3>
                                    </div>
                                </a>
                                <?php $postCount++; ?>
                                <?php if ($postCount >= 5) break; ?>
                            <?php endforeach; ?>
                        </div>
                        <div class="col-12 mb-3">
                            <form method="POST" action="">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="searchUser" placeholder="Search users" value="<?php echo htmlspecialchars($searchUserTerm); ?>">
                                    <div class="input-group-append">
                                        <button class="btn btn-outline-secondary" type="submit">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 mb-3" style="max-height: 300px; overflow-y: scroll;">
                            <?php $userCount = 0; ?>
                            <?php foreach ($users as $user) : ?>
                                <a href="profile.php?userId=<?php echo $user->user_id; ?>" class="text-decoration-none">
                                    <div class="d-flex align-items-center p-2 border rounded bg-light">
                                        <img src="serveProfilePic.php?userId=<?php echo $user->user_id ?>" alt="User Profile" class="mr-3" style="width: 50px; height: 50px; border-radius: 50%;">
                                        <h3 class="mb-0 text-dark"><?php echo htmlspecialchars($user->username); ?></h3>
                                    </div>
                                </a>
                                <?php $userCount++; ?>
                                <?php if ($userCount >= 5) break; ?>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </article>
            </div>
        </div>
    </div>
</body>

</html>
