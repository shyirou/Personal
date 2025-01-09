<?php
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

        // Generate a random name for the file (ensure it always ends with .jpg)
        $random_name = uniqid('thumbnail_', true) . '.jpg'; // Always save as .jpg
        $custom_name = $_POST['custom_name'] . '.jpg'; // Ambil nama kustom dari input

        // Define the target directory
        $target_dir = '../uploads/';
        $target_file = $target_dir . $custom_name; // Gunakan nama kustom sebagai nama file

        // Debugging: Print the generated random name and target file path
        echo "Generated Random Filename: " . $random_name . "<br>";
        echo "Target Path: " . $target_file . "<br>";

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
                    // Store the filename for database insertion
                    $thumbnail = $random_name;

                    // Debugging: Check if the file was saved
                    echo "Image successfully saved as: " . $random_name . "<br>";
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

    // Debugging: Check if $thumbnail has been set correctly
    echo "Thumbnail to store in database: " . $thumbnail . "<br>";

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
