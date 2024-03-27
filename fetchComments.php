<?php
require_once "post.php";
require_once "comment.php";
require_once "user.php";

$post_id = $_GET['postId'];
$comments = Comment::getByPostId($post_id);

echo json_encode($comments);
