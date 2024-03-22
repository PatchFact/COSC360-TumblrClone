<?php
if (isset($_POST["profilePic"])) {
    if (isset($_FILES["profilePic"]) && $_FILES["profilePic"]["error"] == 0) {
        $allowed = ['jpg' => 'image/jpeg', 'png' => 'image/png', 'jpeg' => 'image/jpeg'];
        $fileName = $_FILES["profilePic"]["name"];
        $fileType = $_FILES["profilePic"]["type"];
        $fileSize = $_FILES["profilePic"]["size"];

        // Verify file extension
        $ext = pathinfo($fileName, PATHINFO_EXTENSION);
        if (!array_key_exists($ext, $allowed)) {
            $_SESSION['error_message'] = "File type unsupported. Please upload a .jpg, .jpeg, or .png file.";
            header("Location: profile.php");
            exit();
        }

        // 5MB maximum filesize
        $maxsize = 5 * 1024 * 1024;
        if ($fileSize > $maxsize) {
            die("Error: File size is larger than the allowed limit.");
        }

        // Verify MIME type
        if (in_array($fileType, $allowed)) {
            // Check whether user is logged in and get their ID
            // This part depends on your session management
            // Example: assuming you have the user ID stored in a session variable
            session_start();
            if (isset($_SESSION['user_id'])) {
                $userId = $_SESSION['user_id'];
                // Get raw data of the file
                $imgContent = file_get_contents($_FILES['profilePic']['tmp_name']);

                // Include database connection
                require_once 'db.php'; // Ensure this path is correct

                // Prepare SQL statement
                $stmt = $pdo->prepare("UPDATE users SET profile_picture = :profilePic WHERE user_id = :userId");

                // Bind parameters and execute
                $stmt->execute(['profilePic' => $imgContent, 'userId' => $userId]);

                if ($stmt->rowCount()) {
                    echo "Profile picture uploaded successfully.";
                } else {
                    echo "Upload failed, please try again.";
                }
            } else {
                echo "Please log in to upload a profile picture.";
            }
        } else {
            echo "Error: There was a problem uploading your file. Please try again.";
        }
    } else {
        echo "Error: " . $_FILES["profilePic"]["error"];
    }
} else {
    echo "Error: Submission method not recognized.";
}
