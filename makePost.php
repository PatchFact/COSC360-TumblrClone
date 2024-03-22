<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Create Post";
require "head.php";
?>


<body>
    <form action="search.php" method="post" style="width: fit-content"></form>
    <?php require "navbar.php" ?>


    <div id="main">
        <?php
        include "sidebarComponent.php";
        ?>

        <article id="feed">
            <div id="post-input">
                <h2>Make Post</h2>

                <!-- Image Post -->
                <label for="image-post">Image:</label>
                <input type="file" id="image-post" name="image-post" accept="image/*" />

                <!-- Text Post -->
                <label for="text-post">Text:</label>
                <input type="text" id="text-post" name="text-post" placeholder="Enter post text here" />

                <!-- Button to Save Changes -->
                <button type="button" onclick="savePost()">Post</button>
            </div>
        </article>
        </form>
    </div>
</body>

</html>