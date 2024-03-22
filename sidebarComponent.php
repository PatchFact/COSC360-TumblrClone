<?php
$_loggedIn = FALSE;
$_button = '<a href="loginPage.php" class="button">Log In</a>';

if (isset($_SESSION['user_id'])) {
    $_button = '<a href="logout.php" class="button">Log Out</a>';
    $_loggedIn = TRUE;
}
?>

<article class="side-profile">

    <?php if ($_loggedIn) : ?>
        <img src="images/default_pfp.jpg" alt="profilePic" class="side-pfp">
    <?php endif; ?>

    <?php echo $_button; ?>
</article>