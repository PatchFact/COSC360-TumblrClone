<?php
session_start();

require_once 'post.php';

$postId = isset($_GET['postId']) ? (int)$_GET['postId'] : 0;
$imageData = Post::getImageSource($postId);

if ($imageData) {
    $image_info = getimagesizefromstring($imageData);
    $mime_type = $image_info['mime'];

    header("Content-Type: $mime_type");
    echo $imageData;
} else {
    header("HTTP/1.1 404 Not Found");
}