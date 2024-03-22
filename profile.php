<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Profile";
require "head.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: 404.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$email = $_SESSION['email'];
$is_admin = $_SESSION['is_admin'];
$is_banned = $_SESSION['is_banned'];
$about_me = $_SESSION['about_me'];

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
                                <img src="serveProfilePic.php?userId=1" alt="profilePic" class="main-pfp">

                                <form action="uploadProfilePic.php" method="post" id="profilePicForm" enctype="multipart/form-data">
                                    <input class=" btn btn-primary mt-3" type="file" name="profilePic" id="profilePic" accept=".jpg,.png, .jpeg">
                                    <input class="btn btn-primary mt-3" type="submit" value="Upload Image" name="profilePic">
                                </form>
                            </div>
                            <div class="profile-info mt-5">
                                <h2><?php echo $username ?></h2>
                                <h4><?php echo $email ?></h4>
                                <h4><?php echo $about_me ?></h4>
                            </div>
                        </div>

                        <div class="col align-self-stretch my-posts">
                            <center>
                                <h3>My Posts</h3>
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