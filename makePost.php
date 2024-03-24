<!DOCTYPE html>
<html lang="en">

<?php
$pageTitle = "Ara Create Post";
require "head.php";

$errors = []; // Array to store validation errors

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate name
    if (empty($_POST["image-post"])) {
        $errors['image-post'] = "Please upload a file";
    }

    // Validate email
    if (empty($_POST["text-post"])) {
        $errors['text-post'] = "Please input a caption";
    }

    // Validate other fields as needed...

    // If no errors, proceed with further processing
    if (empty($errors)) {
        // Process form data, e.g., save to database, send email, etc.
        // Redirect to success page or do further processing
        header("Location: success.php");
        exit();
    }
}

// Function to sanitize and validate input data
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

?>


<body>
    <form action="search.php" method="post" style="width: fit-content"></form>
    <?php require "navbar.php" ?>


    <div id="main">
        <article id="side-profile">
            <a href="#" class="button">Log In</a>
        </article>

        <article id="feed">
            <div id="post-input">
                <h2>Make Post</h2>

                <!-- Image Post -->
                <label for="image-post">Image:</label><br>
                <input type="file" id="image-post" name="image-post" accept="image/*" value="<?php echo isset($_POST['image-post']) ? $_POST['image-post'] : ''; ?>"/>
                <span style="color: red;"><?php echo isset($errors['image-post']) ? $errors['image-post'] : ''; ?></span>
                <br>

                <!-- Text Post -->
                <label for="text-post">Text:</label><br>
                <input type="text" id="text-post" name="text-post" placeholder="Enter post text here" value="<?php echo isset($_POST['text-post']) ? $_POST['text-post'] : ''; ?>"style="width: 500px; height: 25px;"/>
                <span style="color: red;"><?php echo isset($errors['text-post']) ? $errors['text-post'] : ''; ?></span>
                <br>

                <!-- Button to Save Changes -->
                <button type="button" onclick="savePost()">Post</button>
            </div>
        </article>
        </form>
    </div>
</body>

</html>