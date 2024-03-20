<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Profile";
require "head.php";
?>


<body>
    <form action="search.php" method="post" style="width: fit-content"></form>
    <?php require "navbar.php" ?>


    <div id="main">
        <article id="side-profile">
            <a href="#" class="button">Log In</a>
        </article>

        <article id="feed">
            <div id="profile-info">
                <h2>Profile Information</h2>

                <!-- Profile Photo -->
                <label for="profile-photo">Profile Photo:</label>
                <input type="file" id="profile-photo" name="profile-photo" accept="image/*" />

                <!-- Bio -->
                <label for="bio">Bio:</label>
                <textarea id="bio" name="bio" rows="4" cols="50"></textarea>

                <!-- Change Username -->
                <label for="username">Change Username:</label>
                <input type="text" id="username" name="username" placeholder="Enter new username" />

                <!-- Button to Save Changes -->
                <button type="button" onclick="saveProfileChanges()">Save Changes</button>
            </div>
        </article>
        </form>
    </div>
</body>

</html>