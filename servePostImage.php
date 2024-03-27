<?php
require_once 'Post.php';

$postId = isset($_GET['postId']) ? (int)$_GET['postId'] : 0;
$imageData = Post::getImageSource($postId);

if ($imageData) {
    header('Content-Type: image/jpg'); // Consider dynamically setting this based on stored image info
    echo $imageData;
} else {
    header("HTTP/1.1 404 Not Found");
}