<?php
// Include the database connection file
include '../database/db.php'; // Adjust the path if necessary

// Ensure you're using PDO's methods
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $video_url = $_POST['video_url'];

    // Check if a thumbnail is uploaded
    if (isset($_FILES['thumbnail']) && $_FILES['thumbnail']['error'] == 0) {
        $temp_name = $_FILES['thumbnail']['tmp_name'];

        // Get the original file extension
        $file_extension = pathinfo($_FILES['thumbnail']['name'], PATHINFO_EXTENSION);

        // Use the original name for the thumbnail
        $thumbnail = $_FILES['thumbnail']['name']; // Keep the original name

        // Define the target directory
        $target_dir = '../uploads/';
        $target_file = $target_dir . $thumbnail; // Use the original name as the file name

        // Convert the image to JPG if it's not already in JPG format
        if (in_array(strtolower($file_extension), ['jpeg', 'jpg', 'png', 'gif'])) {
            // Create a new image resource from the uploaded file
            switch (strtolower($file_extension)) {
                case 'jpeg':
                case 'jpg':
                    $image = imagecreatefromjpeg($temp_name);
                    break;
                case 'png':
                    $image = imagecreatefrompng($temp_name);
                    break;
                case 'gif':
                    $image = imagecreatefromgif($temp_name);
                    break;
                default:
                    $image = null;
                    break;
            }

            // If image creation was successful, save as JPG
            if ($image) {
                // Save the image as a JPG file
                if (imagejpeg($image, $target_file, 90)) {
                    imagedestroy($image);
                } else {
                    echo "<p>Error: Failed to save image.</p>";
                    exit;
                }
            } else {
                echo "<p>Error: Unable to process image.</p>";
                exit;
            }
        } else {
            echo "<p>Error: Unsupported file type.</p>";    
            exit;
        }
    }

    // Prepare the SQL statement with named parameters using pg_query_params
    $sql = "INSERT INTO projects (title, description, thumbnail, video_url) VALUES ($1, $2, $3, $4)";
    $result = pg_query_params($conn, $sql, array($title, $description, $thumbnail, $video_url));

    // Check if the query was successful
    if ($result) {
        echo "<script>alert('Project added successfully.'); window.location.href='/home';</script>";
    } else {
        echo "<p>Error: " . pg_last_error($conn) . "</p>";
    }
}
?>
