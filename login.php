<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['input-email'];
    $password = $_POST['input-password'];

    if (!empty($email) && !empty($password)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            // if (!$user['is_banned']) {
            //     session_start();
            //     $_SESSION['user_id'] = $user['user_id'];
            //     $_SESSION['username'] = $user['username'];
            //     header("Location: success.php");
            //     exit();
            // } else {
            //     echo "Your account has been banned.";
            // }

            echo "yey";
        } else {
            echo "Invalid email or password.";
        }
    } else {
        echo "Email and password are required.";
    }
}
