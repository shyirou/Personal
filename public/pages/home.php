<?php
require_once __DIR__ . '/../database/db.php';
// Check if the connection was successful
if (!$conn) {
    die("Connection failed: Unable to connect to the database.");
}

// Query to fetch all projects
$sql = "SELECT * FROM projects";
$result = pg_query($conn, $sql);

// Check if the query was successful
if (!$result) {
    die("Query failed: " . pg_last_error($conn));
}

// Count the number of rows returned
$projectCount = pg_num_rows($result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/style.css">
    <title>Roid Works!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark" style="font-size: 12px;">
        <div style="margin: auto;">
            <a class="navbar-brand" href="/home">Roid Works!</a>
        </div>
    </nav>

    <!-- Header -->
    <header class="py-4"> <!-- Decrease padding to bring sections closer -->
        <div class="container">
            <h1 class="display-4">Hello, I'm Roid <br> An Independent Designer</h1>
            <p class="lead" style="opacity: 0.5;">Motion Graphic Designer | Motion Video Animator 🛠️</p>
            <!-- Social Media Icons -->
                <div class="social-icons mt-2; margin: 0;"> <!-- Decrease margin to bring sections closer -->
                    <a href="https://www.youtube.com/@shyirou" target="_blank" class="text-light me-3" style="opacity: 0.5;"><i class="fa-brands fa-youtube icon-large"></i></a>
                    <a href="https://x.com/shyirouu" target="_blank" class="text-light me-3" style="opacity: 0.5;"><i class="fa-brands fa-x-twitter icon-large"></i></a>
                    <a href="https://www.instagram.com/shyirou" target="_blank" class="text-light me-3" style="opacity: 0.5;"><i class="fa-brands fa-instagram icon-large"></i></a>
                    <a href="https://github.com/shyirou" target="_blank" class="text-light" style="opacity: 0.5;"><i class="fa-brands fa-github icon-large"></i></a>
                </div>
        </div>
    </header>
    
    <div class="container">
        <hr class="container">
            <div class="container">
                <p align="left">
                    <a href="https://discord.com/users/566507480788631552"><img src="https://lanyard.cnrad.dev/api/566507480788631552?borderRadius=20px&bg=transparent" alt="Discord" width="450"/></a>
                </p>
            </div>
        <hr class="container">
    </div>

    <!-- Portfolio Section -->  
    <section id="portfolio" class="py-4"> <!-- Decrease padding to bring sections closer -->
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="display-4">Related Projects</h2>
                <a href="/add" class  ="btn btn-primary">Add Works</a>
            </div>
            <div class="row row-cols-1 row-cols-md-2 g-4"> <!-- Changed to 4 columns -->
                <?php if ($projectCount > 0): ?>
                    <?php 
                    // Fetch all rows into an array
                    $projects = [];
                    while ($row = pg_fetch_assoc($result)) {
                        $projects[] = $row;
                    }
                    // Display the projects in the original order
                    foreach ($projects as $row): ?>
                        <div class="col">
                            <div class="card h-100 text-light" style="background-color: #222; border: none; position: relative; overflow: hidden;" onclick="window.location='/view/<?php echo $row['id']; ?>'">
                                <img src="/uploads/<?php echo htmlspecialchars($row['thumbnail']); ?>" class="card-img-top" alt="Thumbnail" style="height: auto; aspect-ratio: 16 / 9; object-fit: cover; transition: filter 0.3s ease; cursor: pointer;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars(substr($row['title'], 0, 50)) . '...'; ?></h5>
                                </div>
                            </div>  
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No projects found.</p>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <a>&copy; 2025 My Portfolio. All rights reserved.</a>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
