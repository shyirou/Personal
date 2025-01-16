<?php

// Ensure the ID is present and valid
if (isset($id) && is_numeric($id) && $id > 0) {
    // Check if the ID is within a reasonable range for an integer
    if ($id > PHP_INT_MAX || $id < PHP_INT_MIN) { // Adjusted to check for 32-bit integer max
        header('Location: /404');
        exit;
    }

    // Use a prepared statement to prevent out of range errors
    $sql = "SELECT * FROM projects WHERE id = $1";
    $result = pg_query_params($conn, $sql, array($id));

    if ($result) {
        $row = pg_fetch_assoc($result);
        if (!$row) {
            header('Location: /404');
            exit;
        }
    } else {
        header('Location: /404'); // Redirect to 404 on query execution failure
        exit;
    }
} else {
    header('Location: /404');
    exit;
}

// Validate additional request parts beyond the ID
if (count($requestParts) > 2 || !empty($requestParts[2])) {
    header('Location: /404');
    exit;
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
    <nav class="navbar navbar-expand-lg navbar-dark" style="font-size: 12px;">
        <div style="margin: auto;">
            <a class="navbar-brand" href="/home">Roid Works!</a>
        </div>
    </nav>

        <div class="container">
            <div class="project-detail">
                <h1 class="display-4">Edit Project</h1>
                <!-- Formulir Edit Proyek -->
                <form action="/procces/edit.php?id=<?= $row['id'] ?>" method="POST" enctype="multipart/form-data">
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
                        <input type="text" class="form-control" id="video_url" name="video_url" value="<?= htmlspecialchars($row['video_url'] ?? '') ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update Project</button>
                    <a href="/view/<?= $row['id'] ?>" class="btn btn-secondary">Cancel</a>
                    <a href="/procces/delete.php?id=<?= $row['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this project?');">Delete</a>
                </form>
            </div>
        </div>  


    <!-- Footer -->
    <footer class="footer">
        <a>&copy; 2025 My Portfolio. All rights reserved.</a>
    </footer>
</body>
</html>
