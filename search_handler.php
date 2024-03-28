<?php
require_once 'db.php';
require_once 'head.php';
require_once 'user.php';
require_once 'post.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

if (empty($searchTerm)) {
    $users = User::fetchAll();
} else {
    $users = User::searchByUsername($searchTerm);
}

$results = [];
foreach ($users as $user) {
    $posts = Post::getPostsByUserId($user->user_id);
    $results[$user->user_id] = ['user' => $user, 'posts' => $posts];
}

if (!empty($results)) {
    echo '<div class="list-group">';
    foreach ($results as $userId => $userData) {
        $user = $userData['user'];
        echo '<a href="#" class="list-group-item list-group-item-action active" aria-current="true">';
        echo 'User: ' . htmlspecialchars($user->username) . ' - Email: ' . htmlspecialchars($user->email);
        echo '</a>';
        $banButtonText = $user->is_banned ? 'Unban' : 'Ban';
        echo "<form action='toggleBanUser.php' method='post' class='d-inline-block m-2'>
                <input type='hidden' name='user_id' value='" . htmlspecialchars($user->user_id) . "'>
                <input type='hidden' name='is_banned' value='" . htmlspecialchars($user->is_banned) . "'>
                <button type='submit' class='btn btn-warning' onclick='return confirm(\"Are you sure you want to $banButtonText this user?\"); '>$banButtonText</button>
              </form>";
        foreach ($userData['posts'] as $post) {
                echo '<div class="list-group-item">';
                $imageSource = Post::getImageSource($post->post_id);
                if ($imageSource) {
                        echo '<img src="servePostImage.php?postId=' . htmlspecialchars($post->post_id) . '" alt="Post Image" class="post-image" style="width: 100px; height: 100px; float: left; margin-right: 10px;">';
                }
                echo '<h5 class="mb-1">' . htmlspecialchars($post->title) . '</h5>';
                echo '<p class="mb-1">' . htmlspecialchars($post->body) . '</p>';
                echo "<form action='deletePost.php' method='post' class='d-inline-block'>
                                <input type='hidden' name='post_id' value='" . htmlspecialchars($post->post_id) . "'>
                                <button type='submit' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this post?\");'>Delete</button>
                            </form>";
                echo "<form action='editPost.php' method='get' class='d-inline-block m-2'>
                                <input type='hidden' name='postId' value='" . htmlspecialchars($post->post_id) . "'>
                                <button type='submit' class='btn btn-primary'>Edit</button>
                            </form>";
                echo '</div>';
                echo '<br>';
            }
    }
    echo '</div>';
} else {
    echo '<div class="alert alert-info" role="alert">No results found.</div>';
}