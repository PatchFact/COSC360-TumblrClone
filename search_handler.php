<?php
require 'db.php';
require 'head.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

if (empty($searchTerm)) {
    echo '<p>Please enter a search term.</p>';
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
    $currentUsername = '';
    foreach ($results as $row) {
        // Check if the username has changed (meaning a new user in the list)
        if ($currentUsername !== $row['username']) {
            // Display user info
            echo '<p>User: ' . htmlspecialchars($row['username']) . ' - Email: ' . htmlspecialchars($row['email']) . '</p>';
            $currentUsername = $row['username'];
             // Button text based on ban status
            $banButtonText = $row['is_banned'] ? 'Unban' : 'Ban';
            // Add a Ban/Unban form
            echo "<form action='toggleBanUser.php' method='post' class='ban-form' style='display:inline;'>
                    <input type='hidden' name='user_id' value='" . htmlspecialchars($row['user_id']) . "'>
                    <input type='hidden' name='is_banned' value='" . htmlspecialchars($row['is_banned']) . "'>
                    <input type='submit' value='$banButtonText' onclick='return confirm(\"Are you sure?\");'>
                  </form>";

            
        }
        // Display the user's post if available
        if (!empty($row['title'])) {
            echo '<p>Post Title: ' . htmlspecialchars($row['title']) . ' - Post: ' . htmlspecialchars($row['body']) . '</p>';
            echo "<form action='deletePost.php' method='post' style='display:inline;'>
                    <input type='hidden' name='post_id' value='" . htmlspecialchars($row['post_id']) . "'>
                    <input type='submit' value='Delete' onclick='return confirm(\"Are you sure you want to delete this post?\");'>
                  </form>";
            echo "<form action='editPost.php' method='get' style='display:inline;'>
                    <input type='hidden' name='postId' value='" . htmlspecialchars($row['post_id']) . "'>
                    <input type='submit' value='Edit'>
                  </form>";
        }
        
    }
} else {
    echo '<p>No results found.</p>';
}
?>