<?php
require 'user.php';

if (isset($_POST["profilePic"])) {
    if (isset($_FILES["profilePic"]) && $_FILES["profilePic"]["error"] == 0) {
        $allowed = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'jpeg' => 'image/jpeg'];
        $fileName = $_FILES["profilePic"]["name"];
        $fileType = $_FILES["profilePic"]["type"];
        $fileSize = $_FILES["profilePic"]["size"];

        // Verify file extension
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            $_SESSION['error_message'] = "File type unsupported. Please upload a .jpg, .jpeg, or .png file.";
            header("Location: profile.php");
            exit();
        }

        // 5MB maximum filesize
        $maxsize = 5 * 1024 * 1024;
        if ($fileSize > $maxsize) {
            die("Error: File size is larger than the allowed limit.");
        }

        if (in_array($fileType, $allowed)) {
            session_start();

            $user_id = $_SESSION['user_id'];

            if ($user_id) {
                User::setProfilePicture($user_id, $_FILES["profilePic"]["tmp_name"]);
                $_SESSION['success_message'] = "Profile picture uploaded successfully.";
                header("Location: profile.php");
                exit();
            } else {
                $_SESSION['error_message'] = "User not found.";
                header("Location: profile.php");
                exit();
            }
        } else {
            $_SESSION['error_message'] = "There was a problem uploading your file. Please try again.";
            header("Location: profile.php");
            exit();
        }
    } else {
        $_SESSION['error_message'] = "There was a problem uploading your file. Please try again.";
        header("Location: profile.php");
        exit();
    }
} else {
    $_SESSION['error_message'] = "There was a problem uploading your file. Please try again.";
    header("Location: profile.php");
    exit();
}
