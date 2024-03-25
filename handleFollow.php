<?php
session_start();
require 'user.php';

if (isset($_POST['follow'])) {
    $follower_id = $_SESSION['user_id'];
    $followed_id = $_POST['follow'];

    User::followUser($follower_id, $followed_id);
    $_SESSION['success_message'] = "You are now following this user.";
    header("Location: profile.php?userId=$followed_id");
    exit();
} else if (isset($_POST['unfollow'])) {
    $follower_id = $_SESSION['user_id'];
    $followed_id = $_POST['unfollow'];

    User::unfollowUser($follower_id, $followed_id);
    $_SESSION['success_message'] = "You have unfollowed this user.";
    header("Location: profile.php?userId=$followed_id");
    exit();
} else {
    $_SESSION['error_message'] = "There was a problem following this user.";
    header("Location: profile.php?userId=$followed_id");
    exit();
}
