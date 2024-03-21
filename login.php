<?php
session_start();
require 'user.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['input-email'];
    $password = $_POST['input-password'];

    if (!empty($email) && !empty($password)) {
        $user = User::getByEmail($email);

        if (!$user) {
            $_SESSION['warning_message'] = "We can't find a user registered with that email. Try creating an account!";
            header("Location: loginPage.php");
            exit();
        }

        if ($user && password_verify($password, $user->password)) {
            if ($user->is_banned) {
                $_SESSION['error_message'] = "Your account is currently banned. Please contact an administrator.";
                header("Location: loginPage.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Incorrect email or password. Please try again.";
            header("Location: loginPage.php");
            exit();
        }

        // Set session details
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['username'] = $user->username;
        $_SESSION['email'] = $user->email;
        $_SESSION['is_admin'] = $user->is_admin;
        $_SESSION['is_banned'] = $user->is_banned;
        $_SESSION['about_me'] = $user->about_me;


        $_SESSION['logged_in'] = TRUE;

        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error_message'] = "Something went wrong! Try logging in again, or contact an administrator.";
        header('Location: loginPage.php');
        exit;
    }
}
