<?php
include '../includes/db_connection.php';

// Ensure you're using PDO's methods
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $thumbnail = $_FILES['thumbnail']['name'];
    $video_url = $_POST['video_url'];

    // Move the uploaded thumbnail file
    if ($thumbnail) {
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], '../uploads/' . $thumbnail);
    }

    // Prepare the SQL statement with named parameters
    $sql = "INSERT INTO projects (title, description, thumbnail, video_url) VALUES (:title, :description, :thumbnail, :video_url)";
    $stmt = $conn->prepare($sql);

    // Bind the parameters using PDO's bindValue method
    $stmt->bindValue(':title', $title, PDO::PARAM_STR);
    $stmt->bindValue(':description', $description, PDO::PARAM_STR);
    $stmt->bindValue(':thumbnail', $thumbnail, PDO::PARAM_STR);
    $stmt->bindValue(':video_url', $video_url, PDO::PARAM_STR);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "<script>alert('Project added successfully.');</script>";
    } else {
        echo "<p>Error: " . implode(", ", $stmt->errorInfo()) . "</p>";
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
