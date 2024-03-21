<?php
require 'db_connection.php'; // Adjust this to your actual database connection file

$searchTerm = isset($_POST['search']) ? $_POST['search'] : '';

// Query to search users by name or email. Adjust this according to your needs.
$query = "SELECT username, email FROM users WHERE username LIKE ? OR email LIKE ?";

$stmt = $conn->prepare($query);
$likeTerm = '%' . $searchTerm . '%';
$stmt->bind_param('ss', $likeTerm, $likeTerm);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo '<p>User: ' . htmlspecialchars($row['username']) . ' - Email: ' . htmlspecialchars($row['email']) . '</p>';
    }
} else {
    echo '<p>No results found.</p>';
}
?>
