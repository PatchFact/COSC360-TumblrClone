<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Profile";
require_once "head.php";
require_once "user.php";
require_once "post.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: 404.php");
    exit();
}

if (isset($_GET['userId'])) {
    $user = User::getById($_GET['userId']);

    if (!$user) {
        header("Location: 404.php");
        exit();
    }

    $user_id = $user->user_id;
    $username = $user->username;
    $email = $user->email;
    $is_admin = $user->is_admin;
    $is_banned = $user->is_banned;
    $about_me = $user->about_me;
    $posts = Post::getPostsByUserId($user_id);
} else {
    header("Location: 404.php");
    exit();
}

if ($is_banned) {
    $_SESSION['error_message'] = "This user has been banned.";
    header("Location: 404.php");
    exit();
}

$followers = User::getFollowers($user_id);
$following = User::getFollowing($user_id);

?>

<body>
    <form action="search.php" method="post" style="width: fit-content"></form>
    <?php require "navbar.php" ?>

    <?php
    if (isset($_SESSION['error_message'])) {
        $message = $_SESSION['error_message'];
        unset($_SESSION['error_message']);
        serverMessage("danger", $message);
    }

    if (isset($_SESSION['success_message'])) {
        $message = $_SESSION['success_message'];
        unset($_SESSION['success_message']);
        serverMessage("success", $message);
    }

    if (isset($_SESSION['warning_message'])) {
        $message = $_SESSION['warning_message'];
        unset($_SESSION['warning_message']);
        serverMessage("warning", $message);
    }

    ?>

    <div class="main">

        <?php
        include "sidebarComponent.php";
        ?>

        <article class="feed">
            <div id="profile-container">
                <div class="container">
                    <div class="row">
                        <div class="col profile-info">
                            <div class="pfp-container">
                                <img src="serveProfilePic.php?userId=<?php echo $user_id ?>" alt="profilePic" class="main-pfp">

                            </div>

                            <?php if ($user_id != $_SESSION['user_id']) : ?>

                                <?php if (User::isFollowing($_SESSION['user_id'], $user_id)) : ?>
                                    <form action="handleFollow.php" class="mt-3" method="post">
                                        <input type="hidden" name="unfollow" value="<?php echo $user_id ?>">
                                        <input type="submit" class="btn btn-primary mt-3" style="background-color: lightgray !important" value="Unfollow">
                                    </form>

                                <?php else : ?>
                                    <form action="handleFollow.php" class="mt-3" method="post">
                                        <input type="hidden" name="follow" value="<?php echo $user_id ?>">
                                        <input type="submit" class="btn btn-primary mt-3" value="Follow">
                                    </form>

                                <?php endif; ?>
                            <?php endif; ?>
                            <?php if ($user_id == $_SESSION['user_id']) : ?>
                                <form action="uploadProfilePic.php" method="post" id="profilePicForm" enctype="multipart/form-data">
                                    <input class="btn btn-primary mt-3" type="file" name="profilePic" id="profilePic" accept=".jpg,.png, .jpeg">
                                    <input class="btn btn-primary mt-3" type="submit" value="Upload Image" name="profilePic">
                                </form>
                            <?php endif; ?>
                            <div class="profile-info mt-5">
                                <h2 class="mb-5"><?php echo $username ?></h2>

                                <h3 class="mt-3">Email</h3>
                                <h4><?php echo $email ?></h4>
                                <?php if ($user_id == $_SESSION['user_id']) : ?>
                                    <button id="editEmailButton" class="btn btn-primary mt-3">Edit Email</button>
                                    <form id="editEmailForm" class="mt-5" action="editEmail.php" method="post" style="display: none;">
                                        <input type="email" name="newEmail" required>
                                        <input type="submit" value="Update Email">
                                    </form>
                                <?php endif; ?>

                                <?php if ($user_id == $_SESSION['user_id']) : ?>
                                    <h3 class="mt-5">Password</h3>
                                    <form id="editPassword" class="mt-3" action="editPassword.php" method="post">
                                        <input type="password" name="oldPassword" placeholder="Old Password" required>
                                        <input type="password" name="newPassword" placeholder="New Password" required>
                                        <input type="submit" class="btn btn-primary mt-3" value="Update Password">
                                    </form>
                                <?php endif; ?>

                                <h3 class="mt-5">About Me</h3>
                                <?php if (!empty($about_me)) : ?>
                                    <h4><?php echo $about_me ?></h4>
                                <?php else : ?>
                                    <h4 style="color: gray;">...</h4>
                                <?php endif; ?>
                                <?php if ($user_id == $_SESSION['user_id']) : ?>
                                    <button id="editAboutButton" class="btn btn-primary mt-3 mb-5">Edit About</button>
                                    <form id="editAboutForm" action="editAbout.php" method="post" style="display: none;">
                                        <input type="about" name="newAbout" placeholder="Tell us about yourself!" required>
                                        <input type="submit" class="btn btn-primary mx-3" value="Update About">
                                    </form>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col align-self-stretch my-posts">
                            <center>
                                <h3>Posts</h3>
                                <hr>
                            </center>

                            <?php foreach ($posts as $post) : ?>
                                <?php
                                $user = User::getById($post->user_id);
                                ?>
                                <div class="col-9 mb-3">
                                    <a href="userPost.php?postId=<?php echo $post->post_id; ?>" class="text-decoration-none">
                                        <div class="d-flex align-items-center p-2 border rounded bg-light">
                                            <img src="serveProfilePic.php?userId=<?php echo $user->user_id ?>" alt="User Profile" class="mr-3" style="width: 50px; height: 50px; border-radius: 50%;">
                                            <h3 class="mb-0 text-dark"><?php echo htmlspecialchars($post->title); ?></h3>
                                        </div>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                            <hr class="mt-5 mb-5" style="border-color: lightgray; width: 100%">

                            <div class="container">
                                <div class="row">
                                    <center class="col">
                                        <h3>Followers</h3>
                                        <hr>

                                        <?php

                                        foreach ($followers as $follower) {
                                            echo "<a href=\"profile.php?userId=$follower->user_id\" style=\"color: #007B7F\">" . $follower->username . "</a><br>";
                                        }

                                        ?>

                                    </center>

                                    <center class="col">
                                        <h3>Following</h3>
                                        <hr>

                                        <?php
                                        foreach ($following as $follow) {
                                            echo "<a href=\"profile.php?userId=$follow->user_id\" style=\"color: #007B7F\">" . $follow->username . "</a><br>";
                                        }
                                        ?>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </article>
        </form>
    </div>
</body>

</html>