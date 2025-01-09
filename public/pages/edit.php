<?php
include __DIR__ . '/../database/db.php';

// Check if this is an edit or new project
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM projects WHERE id = $1"; // Use positional parameter for pgsql
    $result = pg_query_params($conn, $sql, array($id)); // Use pg_query_params to execute the query with parameters
    $row = pg_fetch_assoc($result); // Fetch the row
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
        $sql = "INSERT INTO projects (title, description, thumbnail, video_url) VALUES ($1, $2, $3, $4)";
        $result = pg_query_params($conn, $sql, array($title, $description, $thumbnail, $video_url));
        $id = pg_last_oid($result); // Get the ID of the newly inserted project
    } else {
        // Update existing project
        $sql = "UPDATE projects SET title = $1, description = $2, thumbnail = $3, video_url = $4 WHERE id = $5";
        $result = pg_query_params($conn, $sql, array($title, $description, $thumbnail, $video_url, $id));
    }

    if ($result) {
        header('Location: view.php?id=' . $id); // Redirect after successful update
        exit; // Ensure no further code is executed
    } else {
        echo "<p>Error: " . pg_last_error($conn) . "</p>"; // Use pg_last_error() for pgsql errors
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
                <li class="nav-item"> <a class="nav-link" href="/?page=home">Portfolio</a></li>
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
                    <a href="/?page=view?id=<?= $row['id'] ?>" class="btn btn-secondary">Cancel</a>
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