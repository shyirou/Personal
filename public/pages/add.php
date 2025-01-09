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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <title>Add Project</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="font-size: 12px;">
        <div style="margin: auto;">
            <a class="navbar-brand" href="/home">Roid Works!</a>
        </div>
    </nav>

        <div class="container">
            <div class="project-detail">
                <h1 class="display-4">Add New Project</h1>
                <form action="/pages/add.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Upload Thumbnail</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*" required>
                    </div>
                    <div class="mb-3">
                        <label for="video_url" class="form-label">Input Video URL (e.g. YouTube link)</label>
                        <input type="text" class="form-control" id="video_url" name="video_url">
                    </div>
                    <button type="submit" class="btn btn-primary">Add Project</button>
                    <a href="/home" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>

    <!-- Footer -->
    <footer class="footer">
        <a>&copy; 2025 My Portfolio. All rights reserved.</a>
    </footer>
    <script src="/js/fade.js"></script>
</body>
</html>
