<?php
require_once __DIR__ . '/../database/db.php';

// Pastikan ID ada dan valid
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
    <title>View Project</title>
</head> 
<body>

    <nav class="navbar navbar-expand-lg navbar-dark" style="font-size: 12px;">
        <div style="margin: auto;">
            <a class="navbar-brand" href="/home">Roid Works!</a>
        </div>
    </nav>
    
    <div class="container">
        <div class="project-detail">
            <h1 class="display-5 font-bold text-left"><?php echo htmlspecialchars($row['title']); ?></h1>
                <p class="lead text-left" style="opacity: 0.5;"><?php echo htmlspecialchars($row['description']); ?></p>
                <?php if (!empty($row['video_url'])): ?>
                    <div style="padding: 12px 0 12px;">
                        <a href="<?php echo htmlspecialchars($row['video_url']); ?>" target="_blank">
                            <img src="../uploads/<?php echo htmlspecialchars($row['thumbnail']); ?>" alt="Thumbnail" class="img-thumbnail" style="width: 100%; aspect-ratio: 16 / 9; object-fit: cover;">
                        </a>
                    </div>
                <?php else: ?>
                    <p class="text-light mt-4">No video URL provided.</p>
                <?php endif; ?> 
                <div style="padding: 12px 0 12px;">
                    <a href="/edit/<?php echo $row['id']; ?>" class="btn btn-primary">Edit Work</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer">
        <a>&copy; 2025 My Portfolio. All rights reserved.</a>
    </footer>
</body>
</html>
