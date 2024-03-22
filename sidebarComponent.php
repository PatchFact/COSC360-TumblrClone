<?php
require 'user.php';

$loggedIn = FALSE;
$isAdmin = FALSE;
$button = '<a href="loginPage.php" class="button">Log In</a>';

if (isset($_SESSION['user_id'])) {
    $userId = User::getById($_SESSION['user_id']);
    $isAdmin = $userId->is_admin;
    $loggedIn = TRUE;
    $followerNumber = User::getFollowerCount($userId->user_id);
    $followingNumber = User::getFollowingCount($userId->user_id);

    $button = '<a href="logout.php" class="button">Log Out</a>';
}

?>

<article class="side-profile">
    <?php if ($loggedIn) : ?>
        <div class="pfp-container mb-3">
            <img src="images/default_pfp.jpg" alt="profilePic" class="side-pfp">
        </div>
        <section>Followers (<?php echo $followerNumber ?>)</section>
        <section>Following (<?php echo $followingNumber ?>)</section>
        <section><a href="profile.php">My Posts</a></section>
    <?php endif; ?>

    <?php if ($isAdmin) : ?>
        <section><a href="admin.php">Admin</a></section>
    <?php endif; ?>

    <?php echo $button; ?>
</article>