<?php

session_start();
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['new-email'];
    $username = $_POST['username'];
    $password = $_POST['new-password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    if (!empty($email) && !empty($password) && !empty($username)) {
        // Check if email already has associated user
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            $_SESSION['error_message'] = "A user is already registered with that email.";
            header('Location: loginPage.php');
            exit;
        }

        // Check if username is available
        $stmt = $pdo->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
        $stmt->execute(['username' => $username]);
        $existingUsername = $stmt->fetch();

        if ($existingUsername) {
            $_SESSION['error_message'] = "A user is already registered with that username. Please try again.";
            header('Location: loginPage.php');
            exit;
        }

        // Insert user into database
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, logged_in, is_admin) VALUES (:username, :email, :password, :logged_in, :is_admin)");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'logged_in' => FALSE,
            'is_admin' => FALSE
        ]);

        $_SESSION['success_message'] = "You have been registered successfully. Try logging in!";
        header("Location: loginPage.php");
        exit;
    } else {
        echo "Invalid registration, try again.";
    }
}
