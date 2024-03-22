<header>
    <nav>
        <ul>
            <li><img src="images/AraLogo.png" /></li>
            <li><a href="index.php">Home</a></li>
            <li><a href="profile.php">Profile</a></li>
            <li><a href="makePost.php">New Post</a></li>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == TRUE) : ?>
                <li><a href="admin.php">Admin</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</header>