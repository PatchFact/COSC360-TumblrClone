<?php
session_start();
require 'user.php';

if (isset($_POST["newEmail"])) {
    $email = $_POST["newEmail"];
    $user_id = $_SESSION['user_id'];

    // Check if email already has associated user
    $existingEmail = User::getByEmail($email);
    if ($existingEmail) {
        $_SESSION['error_message'] = "A user is already registered with that email. Please try another email.";
        header("Location: profile.php?userId=$user_id");
        exit;
    }

    $validEmail = filter_var($email, FILTER_VALIDATE_EMAIL);
    if (!$validEmail) {
        $_SESSION['error_message'] = "Invalid email address. Please try again.";
        header("Location: profile.php?userId=$user_id");
        exit();
    }

    if ($user_id) {
        User::setEmail($user_id, $email);
        $_SESSION['success_message'] = "Email updated successfully.";
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
