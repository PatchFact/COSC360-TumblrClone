<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Profile";
require_once "head.php";
require_once "user.php";

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
} else {
    header("Location: 404.php");
    exit();
}

if ($is_banned) {
    $_SESSION['error_message'] = "This user has been banned.";
    header("Location: 404.php");
    exit();
}

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
                            <?php if ($user_id == $_SESSION['user_id']) : ?>
                                <form action="uploadProfilePic.php" method="post" id="profilePicForm" enctype="multipart/form-data">
                                    <input class="btn btn-primary mt-3" type="file" name="profilePic" id="profilePic" accept=".jpg,.png, .jpeg">
                                    <input class="btn btn-primary mt-3" type="submit" value="Upload Image" name="profilePic">
                                </form>
                            <?php endif; ?>
                            <div class="profile-info mt-5">
                                <h2 class="mb-5"><?php echo $username ?></h2>

                                <?php if ($user_id == $_SESSION['user_id']) : ?>

                                <?php endif; ?>

                                <h3 class="mt-3">Email</h3>
                                <h4 class="mb-5"><?php echo $email ?></h4>
                                <h3 class="mt-3">About Me</h3>
                                <?php if (!empty($about_me)) : ?>
                                    <h4><?php echo $about_me ?></h4>
                                <?php else : ?>
                                    <h4>No bio available</h4>
                                <?php endif; ?>
                            </div>
                        </div>

                        <div class="col align-self-stretch my-posts">
                            <center>
                                <h3>Posts</h3>
                                <hr>
                            </center>
                        </div>
                    </div>

                </div>
            </div>
        </article>
        </form>
    </div>
</body>

</html>