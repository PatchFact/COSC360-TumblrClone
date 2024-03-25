<?php
require 'user.php';

if (isset($_POST["profilePic"])) {
    if (isset($_FILES["profilePic"]) && $_FILES["profilePic"]["error"] == 0) {
        $allowed = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'jpeg' => 'image/jpeg'];
        $file_name = $_FILES["profilePic"]["name"];
        $file_type = $_FILES["profilePic"]["type"];
        $file_size = $_FILES["profilePic"]["size"];

        $user_id = $_SESSION['user_id'];

        // Verify file extension
        $ext = pathinfo($file_name, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            $_SESSION['error_message'] = "File type unsupported. Please upload a .jpg, .jpeg, or .png file.";
            header("Location: profile.php?userId=$user_id");
            exit();
        }

        // 5MB maximum filesize
        $maxsize = 5 * 1024 * 1024;
        if ($file_size > $maxsize) {
            die("Error: File size is larger than the allowed limit.");
        }

        if (in_array($file_type, $allowed)) {
            session_start();

            $user_id = $_SESSION['user_id'];

            if ($user_id) {
                User::setProfilePicture($user_id, $_FILES["profilePic"]["tmp_name"]);
                $_SESSION['success_message'] = "Profile picture uploaded successfully.";
                header("Location: profile.php?userId=$user_id");
                exit();
            } else {
                $_SESSION['error_message'] = "User not found.";
                header("Location: profile.php?userId=$user_id");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "There was a problem uploading your file. Please try again.";
            header("Location: profile.php?userId=$user_id");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "There was a problem uploading your file. Please try again.";
        header("Location: profile.php?userId=$user_id");
        exit();
    }
} else {
    $_SESSION['error_message'] = "There was a problem uploading your file. Please try again.";
    header("Location: profile.php?userId=$user_id");
    exit();
}
