<?php
session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['input-email'];
    $password = $_POST['input-password'];

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();


        if (!$user) {
            $_SESSION['warning_message'] = "We can't find a user registered with that email. Try creating an account!";
            header("Location: loginPage.php");
            exit();
        }

        if ($user && password_verify($password, $user['password'])) {
            if (!$user['is_banned']) {
                $_SESSION['user_id'] = $user['user_id'];
                $_SESSION['username'] = $user['username'];
                header("Location: index.php");
                exit();
            } else {
                $_SESSION['error_message'] = "Your account is currently banned. Please contact an administrator.";
                header("Location: loginPage.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "Incorrect email or password. Please try again.";
            header("Location: loginPage.php");
            exit();
        }
    } else {
        echo "Something went wrong! Try logging in again, or contact an administrator.";
    }
}
