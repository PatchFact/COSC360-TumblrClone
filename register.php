<?php

session_start();
require 'user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['new-email'];
    $username = $_POST['username'];
    $password = $_POST['new-password'];
    $admin_check = $_POST['admin-check'];

    if (isset($admin_check)) {
        $admin_check = TRUE;
    } else {
        $admin_check = FALSE;
    }

    if (!empty($email) && !empty($password) && !empty($username)) {
        // Check if email already has associated user
        $existingEmail = User::getByEmail($email);
        if ($existingEmail) {
            $_SESSION['error_message'] = "A user is already registered with that email. Did you mean to log in?";
            header('Location: loginPage.php');
            exit;
        }

        // Check if username is available
        $existingUsername = User::getByUsername($username);
        if ($existingUsername) {
            $_SESSION['error_message'] = "A user is already registered with that username. Please try again.";
            header('Location: loginPage.php');
            exit;
        }

        // Insert user into database
        User::insertUser($username, $email, $password, $admin_check);

        // Set default profile picture
        $imagePath = "images\default_pfp.jpg";
        $user = User::getByEmail($email);
        $user->setProfilePicture($user->user_id, $imagePath);

        $_SESSION['success_message'] = "You have been registered successfully. Try logging in!";
        header("Location: loginPage.php");
        exit;
    } else {
        $_SESSION['error_message'] = "Something went wrong! Try logging in again, or contact an administrator.";
        header('Location: loginPage.php');
        exit;
    }
}
