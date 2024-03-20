<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['new-email'];
    $username = $_POST['username'];
    $password = $_POST['new-password'];
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);


    if (!empty($email) && !empty($password) && !empty($username)) {
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, logged_in, is_admin) VALUES (:username, :email, :password, :logged_in, :is_admin)");
        $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'logged_in' => FALSE,
            'is_admin' => FALSE
        ]);

        echo "yey";
    } else {
        echo "Invalid registration, try again.";
    }
}
