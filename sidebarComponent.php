<?php
require_once 'user.php';

$logged_in = FALSE;
$is_admin = FALSE;
$button = '<a href="loginPage.php" class="button btn btn-primary mt-3">Log In</a>';

if (isset($_SESSION['user_id'])) {
    $user = User::getById($_SESSION['user_id']);
    $is_admin = $user->is_admin;
    $logged_in = TRUE;
    $follower_number = User::getFollowerCount($user->user_id);
    $following_number = User::getFollowingCount($user->user_id);

    $button = '<a href="logout.php" class="button btn btn-primary mt-3">Log Out</a>';
}

?>

<article class="side-profile">
    <?php if ($logged_in) : ?>
        <center class="pfp-container mb-3">
            <img src="serveProfilePic.php?userId=<?php echo $user->user_id ?>" alt="profilePic" class="side-pfp">
        </center>
        <section>Followers (<?php echo $follower_number ?>)</section>
        <section>Following (<?php echo $following_number ?>)</section>
        <section><a href="profile.php?userId=<?php echo $_SESSION['user_id'] ?>">Profile</a></section>
    <?php endif; ?>

    <?php if ($is_admin) : ?>
        <section><a href="admin.php">Admin</a></section>
    <?php endif; ?>

    <?php echo $button; ?>
</article>