<?php
session_start();
require 'user.php';

if (isset($_POST["newAbout"])) {
    $about_me = $_POST["newAbout"];
    $user_id = $_SESSION['user_id'];

    if ($user_id) {
        User::setAbout($user_id, $about_me);
        $_SESSION['success_message'] = "Bio updated successfully.";
        header("Location: profile.php?userId=$user_id");
        exit();
    } else {
        $_SESSION['error_message'] = "User not found.";
        header("Location: profile.php?userId=$user_id");
        exit();
    }
} else {
    $_SESSION['error_message'] = "There was a problem updating your email. Please try again.";
    header("Location: profile.php");
    exit();
}
