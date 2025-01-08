<?php
include '../includes/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $video_url = mysqli_real_escape_string($conn, $_POST['video_url']);

    // Upload Thumbnail
    $thumbnail = $_FILES['thumbnail']['name'];
    $thumbnail_tmp = $_FILES['thumbnail']['tmp_name'];
    $thumbnail_target = '../uploads/' . basename($thumbnail);
    
    // Check if the file was uploaded successfully
    if (move_uploaded_file($thumbnail_tmp, $thumbnail_target)) {
        $sql = "INSERT INTO projects (title, description, thumbnail, video_url) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $title, $description, $thumbnail, $video_url);
        if ($stmt->execute()) {
            header('Location: ../index.php');
            exit; // Ensure no further code is executed after redirection
        } else {
            echo "<p class='text-danger'>Error: " . $conn->error . "</p>";
        }
        $stmt->close();
    } else {
        echo "<p class='text-danger'>Error uploading thumbnail.</p>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Add Project</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Roid Works! </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                <li class="nav-item"> <a class="nav-link" href="../index.php">About Me</a></li>
                <li class="nav-item"> <a class="nav-link" href="../index.php">Portfolio</a></li>
                </ul>
            </div>
        </div>
    </nav>
    <main>
        <div class="container">
            <div class="project-detail">
                <h1 class="display-4">Add New Project</h1>
                <form action="add.php" method="POST" enctype="multipart/form-data">
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
                    <a href="../index.php" class="btn btn-secondary">Cancel</a>
                </form>
            </div>
        </div>
    </main>
    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2025 My Portfolio. All rights reserved.</p>
        </div>
    </footer>

</body>
</html>
