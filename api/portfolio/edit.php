<?php
include '../includes/db_connection.php';

// Check if this is an edit or new project
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM projects WHERE id = :id"; // Use named parameter for PDO
    $stmt = $conn->prepare($sql);
    $stmt->bindValue(':id', $id, PDO::PARAM_INT); // Bind the parameter using bindValue for PDO
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC); // Fetch the row
    if (!$row) {
        echo "<p>Project not found.</p>";
        exit;
    }
} else {
    $id = null; // Handle new project creation when there's no ID   
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $description = $_POST['description'];
    $thumbnail = $_FILES['thumbnail']['name'] ?: ($row['thumbnail'] ?? null);
    $video_url = $_POST['video_url'] ?: ($row['video_url'] ?? null);

    if ($_FILES['thumbnail']['name']) {
        move_uploaded_file($_FILES['thumbnail']['tmp_name'], '../uploads/' . $thumbnail);
    }

    // If $id is null, this is an insert (new project)
    if ($id === null) {
        // Insert new project, do not include id
        $sql = "INSERT INTO projects (title, description, thumbnail, video_url) VALUES (:title, :description, :thumbnail, :video_url)";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':thumbnail', $thumbnail, PDO::PARAM_STR);
        $stmt->bindValue(':video_url', $video_url, PDO::PARAM_STR);
    } else {
        // Update existing project
        $sql = "UPDATE projects SET title = :title, description = :description, thumbnail = :thumbnail, video_url = :video_url WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':title', $title, PDO::PARAM_STR);
        $stmt->bindValue(':description', $description, PDO::PARAM_STR);
        $stmt->bindValue(':thumbnail', $thumbnail, PDO::PARAM_STR);
        $stmt->bindValue(':video_url', $video_url, PDO::PARAM_STR);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
    }

    if ($stmt->execute()) {
        if ($id === null) {
            // Get the ID of the newly inserted project
            $id = $conn->lastInsertId();
        }
        header('Location: view.php?id=' . $id); // Redirect after successful update
        exit; // Ensure no further code is executed
    } else {
        echo "<p>Error: " . implode(", ", $stmt->errorInfo()) . "</p>"; // Use errorInfo() for PDO errors
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
    <title>Edit Project</title>
</head> 
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="../index.php">Roid Works!</a>
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
                <h1 class="display-4">Edit Project</h1>
                <form action="edit.php?id=<?= $row['id'] ?>" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="<?= htmlspecialchars($row['title']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4" required><?= htmlspecialchars($row['description']) ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="thumbnail" class="form-label">Upload Thumbnail</label>
                        <input type="file" class="form-control" id="thumbnail" name="thumbnail" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="video_url" class="form-label">Input Video URL (e.g. YouTube link)</label>
                        <input type="text" class="form-control" id="video_url" name="video_url" value="<?= htmlspecialchars($row['video_url'] ?? '') ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Update Project</button>
                    <a href="view.php?id=<?= $row['id'] ?>" class="btn btn-secondary">Cancel</a>
                    <a href="delete.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
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