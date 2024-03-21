<?php
require 'db.php';

$searchTerm = isset($_POST['search']) ? trim($_POST['search']) : '';

if (empty($searchTerm)) {
    echo '<p>Please enter a search term.</p>';
    exit;
}

$query = "SELECT users.username, users.email, posts.title, posts.body, posts.post_id FROM users 
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
            // Display the user information
            echo '<p>User: ' . htmlspecialchars($row['username']) . ' - Email: ' . htmlspecialchars($row['email']) . '</p>';
            $currentUsername = $row['username'];
        }
        // Display the user's post if available
        if (!empty($row['title'])) {
            echo '<p>Post Title: ' . htmlspecialchars($row['title']) . ' - Post: ' . htmlspecialchars($row['body']) . '</p>';
            echo "<form action='deletePost.php' method='post'>
                <input type='hidden' name='post_id' value='" . htmlspecialchars($row['post_id']) . "'>
                <input type='submit' value='Delete' onclick='return confirm(\"Are you sure you want to delete this post?\");'>
              </form>";
              echo "<a href='editPost.php?postId=" . htmlspecialchars($row['post_id']) . "'>Edit</a>";

        }
    }
} else {
    echo '<p>No results found.</p>';
}
?>