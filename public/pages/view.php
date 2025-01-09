<?php
require_once __DIR__ . '/../database/db.php';

// Get project ID from URL parameter
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Check if ID is valid
if ($id > 0) {
    $sql = "SELECT * FROM projects WHERE id = $1"; // Use positional parameters for pgsql
    $result = pg_query_params($conn, $sql, array($id)); // Use pg_query_params to execute the query with parameters

    if ($result) {
        $row = pg_fetch_assoc($result); // Fetch the project data
        if ($row) {
            // Project found, do something with $row
        } else {
            echo "<p>Project not found.</p>";
            exit;
        }
    } else {
        echo "<p>Error executing query.</p>";
        exit;
    }
} else {
    echo "<p>Invalid ID.</p>";
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
    <div class="container">
        <div class="project-detail">
            <h1 class="display-5 font-bold text-left"><?php echo htmlspecialchars($row['title']); ?></h1>
            <p class="lead mb-2 text-left" style="opacity: 0.5;"><?php echo htmlspecialchars($row['description']); ?></p>
            <?php if (!empty($row['video_url'])): ?>
                <div class="mt-2">
                    <a href="<?php echo htmlspecialchars($row['video_url']); ?>" target="_blank">
                        <img src="../uploads/<?php echo htmlspecialchars($row['thumbnail']); ?>" alt="Thumbnail" class="img-thumbnail" style="aspect-ratio: 16 / 9; object-fit: cover;">
                    </a>
                </div>
            <?php else: ?>
                <p class="text-light mt-4">No video URL provided.</p>
            <?php endif; ?> 
            <div class="mt-4">
                <a href="/?page=edit&id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit Work</a>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2025 My Portfolio. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
