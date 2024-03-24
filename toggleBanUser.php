<?php
require 'db.php';
require 'head.php';

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userId = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$isBanned = isset($_POST['is_banned']) ? (int)$_POST['is_banned'] : 0;
$newStatus = $isBanned ? 0 : 1;

if ($userId > 0) {
    $stmt = $pdo->prepare("UPDATE users SET is_banned = :newStatus WHERE user_id = :userId");
    $result = $stmt->execute([':newStatus' => $newStatus, ':userId' => $userId]);

    if ($result) {
        $action = $newStatus ? 'User banned successfully.' : 'User unbanned successfully.';
        echo json_encode(['status' => 'success', 'message' => $action]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'An error occurred while updating the user status.']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid user ID.']);
}

header("Location: admin.php");
exit;
?>
