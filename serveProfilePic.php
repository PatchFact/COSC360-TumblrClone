<?php
session_start();

require_once 'user.php';

if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    $profile_picture = User::getProfilePicture($userId);

    if ($userId && !empty($profile_picture)) {
        $image_info = getimagesizefromstring($profile_picture);
        $mime_type = $image_info['mime'];

        header("Content-Type: $mime_type");
        echo $profile_picture;
    } else {
        header("Content-Type: image/jpg");
        readfile("images/default_pfp.jpg");
    }
} else {
    header("Location: 404.php");
    exit();
}
