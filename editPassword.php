<?php
session_start();
require 'user.php';

if (isset($_POST["newPassword"]) && isset($_POST["oldPassword"])) {
    $password = $_POST["newPassword"];
    $user_id = $_SESSION["user_id"];

    $user = User::getById($user_id);

    if (!password_verify($_POST["oldPassword"], $user->password)) {
        $_SESSION['error_message'] = "Incorrect password. Please try again.";
        header("Location: profile.php?userId=$user_id");
        exit();
    }

    User::setPassword($user_id, $password);
    $_SESSION['success_message'] = "Password updated successfully.";
    header("Location: profile.php?userId=$user_id");
    exit();
} else {
    $_SESSION['error_message'] = "There was a problem updating your password. Please try again.";
    header("Location: profile.php?=userId=$user_id");
    exit();
}
