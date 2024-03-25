<header>
    <nav>
        <ul>
            <li><img src="images/AraLogo.png" /></li>
            <li><a href="index.php">Home</a></li>
            <?php if (isset($_SESSION['user_id'])) : ?>
                <li><a href="profile.php?userId=<?php echo $_SESSION['user_id'] ?>">Profile</a></li>
                <li><a href="makePost.php">New Post</a></li>
            <?php else : ?>
                <li><a href="loginPage.php">Login</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == TRUE) : ?>
                <li><a href="admin.php">Admin</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>