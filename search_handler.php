<?php
require 'db.php';
require 'head.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

if (empty($searchTerm)) {
    echo '<div class="alert alert-warning" role="alert">Please enter a search term.</div>';
    exit;
}

$query = "SELECT users.user_id, users.username, users.email, users.is_banned, posts.title, posts.body, posts.post_id FROM users 
          LEFT JOIN posts ON users.user_id = posts.user_id 
          WHERE users.username LIKE :searchTerm OR users.email LIKE :searchTerm";

$stmt = $pdo->prepare($query);
$likeTerm = '%' . $searchTerm . '%';
$stmt->execute([':searchTerm' => $likeTerm]);

$results = $stmt->fetchAll();

if (!empty($results)) {
    echo '<div class="list-group">';
    $currentUsername = '';
    foreach ($results as $row) {
        if ($currentUsername !== $row['username']) {
            echo '<a href="#" class="list-group-item list-group-item-action active" aria-current="true">';
            echo 'User: ' . htmlspecialchars($row['username']) . ' - Email: ' . htmlspecialchars($row['email']);
            echo '</a>';
            $currentUsername = $row['username'];
            $banButtonText = $row['is_banned'] ? 'Unban' : 'Ban';
            echo "<form action='toggleBanUser.php' method='post' class='d-inline-block m-2'>
                    <input type='hidden' name='user_id' value='" . htmlspecialchars($row['user_id']) . "'>
                    <input type='hidden' name='is_banned' value='" . htmlspecialchars($row['is_banned']) . "'>
                    <button type='submit' class='btn btn-warning'>$banButtonText</button>
                  </form>";
        }
        if (!empty($row['title'])) {
            echo '<div class="list-group-item">';
            echo '<h5 class="mb-1">' . htmlspecialchars($row['title']) . '</h5>';
            echo '<p class="mb-1">' . htmlspecialchars($row['body']) . '</p>';
            echo "<form action='deletePost.php' method='post' class='d-inline-block'>
                    <input type='hidden' name='post_id' value='" . htmlspecialchars($row['post_id']) . "'>
                    <button type='submit' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this post?\");'>Delete</button>
                  </form>";
            echo "<form action='editPost.php' method='get' class='d-inline-block m-2'>
                    <input type='hidden' name='postId' value='" . htmlspecialchars($row['post_id']) . "'>
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
?>
