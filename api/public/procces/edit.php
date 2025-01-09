<?php
require_once __DIR__ . '/../database/db.php';

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    echo "<p>Invalid ID.</p>";
    exit;
}

// Fetch existing project data
$sql = "SELECT * FROM projects WHERE id = $1";
$result = pg_query_params($conn, $sql, [$id]);

if ($result) {
    $row = pg_fetch_assoc($result);
    if (!$row) {
        echo "<p>Project with ID $id not found.</p>";
        exit;
    }
} else {
    echo "<p>Error executing query: " . htmlspecialchars(pg_last_error($conn)) . "</p>";
    exit;
}

// Initialize variables for form
$title = $row['title'];
$description = $row['description'];
$thumbnail = $row['thumbnail'];
$video_url = $row['video_url'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $video_url = $_POST['video_url'] ?: $row['video_url'];

    // Handle file upload
    if (!empty($_FILES['thumbnail']['name'])) {
        // Unlink the old thumbnail if it exists
        if ($thumbnail) {
            $oldThumbnailPath = '../uploads/' . $thumbnail;
            if (file_exists($oldThumbnailPath)) {
                unlink($oldThumbnailPath); // Delete the old thumbnail
            }
        }

        $uploadDir = '../uploads/';
        $targetFile = $uploadDir . basename($_FILES['thumbnail']['name']);
        
        // Validate file type
        $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
        if (!in_array($_FILES['thumbnail']['type'], $allowedTypes)) {
            echo "<p>Error: Only JPEG, PNG, and GIF files are allowed.</p>";
            exit;
        }

        // Check for file existence and handle duplicates
        if (file_exists($targetFile)) {
            echo "<p>Error: File already exists. Please rename your file and try again.</p>";
            exit;
        }
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], $targetFile);
        $thumbnail = $_FILES['thumbnail']['name']; // Update thumbnail if uploaded
    }

    // Update project
    $sql = "UPDATE projects SET title = $1, description = $2, thumbnail = $3, video_url = $4 WHERE id = $5";
    $result = pg_query_params($conn, $sql, [$title, $description, $thumbnail, $video_url, $id]);

    if ($result) {
        echo "<p>Project updated successfully.</p>";
        header("Location: /view?id=$id");
        exit;
    } else {
        echo "<p>Error: " . pg_last_error($conn) . "</p>";
        exit;
    }
}

?>