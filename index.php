<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Home";
require "head.php";
?>


<body>
    <form action="search.php" method="post" style="width: fit-content"></form>
    <header>
        <nav>
            <ul>
                <li><img src="images/AraLogo.png" /></li>
                <li><a href="#">Home</a></li>
                <li><a href="#">Profile</a></li>
                <li><a href="#">New Post</a></li>
            </ul>
        </nav>
    </header>
    <div id="main">
        <article id="side-profile">
            <a href="#" class="button">Log In</a>
        </article>

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