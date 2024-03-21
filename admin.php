<!DOCTYPE html>
<html lang="en">

<?php
session_start(); // Start the session at the beginning

$pageTitle = "Ara Admin";
require 'head.php'; // Make sure this includes Bootstrap CSS

// Include your database connection file here
require 'db.php'; // Adjust the path as necessary

$currentUserId = $_SESSION['user_id'] ?? null; // Use null coalescing operator as a placeholder

if ($currentUserId === null) {
    // Redirect to login page if there is no user_id in the session (i.e., not logged in)
    header("Location: loginPage.php");
    exit;
}

// Check if the current user is an admin
$query = "SELECT is_admin FROM users WHERE user_id = :userId";
$stmt = $pdo->prepare($query);
$stmt->execute([':userId' => $currentUserId]);
$result = $stmt->fetch();

if ($result === false) {
    // Handle user not found or not logged in
    header("Location: loginPage.php");
    exit;
}

if (!$result['is_admin']) {
    // Redirect non-admin users
    header("Location: index.php");
    exit;
}

// Proceed with page content for admins
?>

<body>
    <?php require "navbar.php" ?>

    <div id="main">
        
    </div>
    <div id="search-section">
        <input type="text" id="search-input" placeholder="Search users or posts">
        <button id="search-button">Search</button>
        <div id="search-results"></div>
    </div>

    <!-- Bootstrap Edit Post Modal -->
    <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="editPostModalLabel">Edit Post</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <!-- The edit form will be loaded here by the JavaScript -->
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary">Save Changes</button>
          </div>
        </div>
      </div>
    </div>

    <script>
        function showEditModal() {
    document.getElementById('editPostModal').style.display = 'block';
}

function closeEditModal() {
    document.getElementById('editPostModal').style.display = 'none';
}
    </script>

</body>

</html>

