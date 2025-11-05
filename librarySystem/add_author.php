<?php
include "connection.php";
include "admin_navbar.php";

// Handle form submission
$successMessage = "";
$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['add'])) {
    $authorName = trim($_POST['authorname']);

    if (!empty($authorName)) {
        $stmt = $db->prepare("INSERT INTO authors (author_name) VALUES (?)");
        if ($stmt) {
            $stmt->bind_param("s", $authorName);
            if ($stmt->execute()) {
                $successMessage = "Author added successfully.";
            } else {
                $errorMessage = "Failed to add author. Please try again.";
            }
            $stmt->close();
        } else {
            $errorMessage = "Error in database query.";
        }
    } else {
        $errorMessage = "Author name cannot be empty.";
    }
}
?>
