<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Home";
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
            <h1>This is Temporary</h1>
        </article>

        <article id="search-bar">
            <input text="text" name="search" placeholder="Search posts">
            <input text="text" name="filter" placeholder="Filter tags">
        </article>
        </form>
    </div>
</body>

</html>