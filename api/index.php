<?php
include 'includes/db_connection.php';

// Query untuk mengambil semua proyek
$sql = "SELECT * FROM projects";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../style.css">
    <title>Roid Works!</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container">
            <a class="navbar-brand" href="#">Roid Works!</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#about">About Me</a></li>
                    <li class="nav-item"><a class="nav-link" href="#portfolio">Portfolio</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="py-4"> <!-- Decrease padding to bring sections closer -->
        <div class="container">
            <h1 class="display-4">Hello, I'm Roid <br> An Independent Designer</h1>
            <p class="lead" style="opacity: 0.5;">Motion Graphic Designer | Motion Video Animator 🛠️</p>
            <!-- Social Media Icons -->
                <div class="social-icons mt-2"> <!-- Decrease margin to bring sections closer -->
                    <a href="https://www.youtube.com/@shyirou" target="_blank" class="text-light me-3" style="opacity: 0.5;"><i class="fa-brands fa-youtube icon-large"></i></a>
                    <a href="https://x.com/shyirouu" target="_blank" class="text-light me-3" style="opacity: 0.5;"><i class="fa-brands fa-x-twitter icon-large"></i></a>
                    <a href="https://www.instagram.com/shyirou" target="_blank" class="text-light me-3" style="opacity: 0.5;"><i class="fa-brands fa-instagram icon-large"></i></a>
                    <a href="https://github.com/shyirou" target="_blank" class="text-light" style="opacity: 0.5;"><i class="fa-brands fa-github icon-large"></i></a>
                </div>
                <hr>
                <p align="left">
                    <a href="https://discord.com/users/566507480788631552"><img src="https://lanyard.cnrad.dev/api/566507480788631552?borderRadius=20px&bg=transparent" alt="Discord" width="450"/></a>
                </p>
                <hr>
        </div>
    </header>


    <?php
    // About Section
    // <section id="about" class="py-4"> <!-- Decrease padding to bring sections closer -->
    //     <div class="container">
    //         <h2 class="display-4">About Me</h2>
    //         <p class="lead" style="opacity: 0.5;">I'am Roid Hylmi, a motion graphic designer from Kalimantan Timur, Indonesia. I love to create motion graphics with a focus on visual storytelling and dynamic animation.</p>
    //     </div>
    // </section>
    // 
    // Experience Section
    // <section id="experience" class="py-4">
    //     <div class="container">
    //         <h2 class="display-4">Experience</h2>
    //         <ul class="list-unstyled mb-4">
    //             <li>
    //                 <h5 class="lead" style="margin-top: 5;">• Freelance Motion Graphics Designer</h5>
    //                 <p class="lead" style="opacity: 0.5; margin-bottom: 0; font-size: 1rem;">2020 - Present</p>
    //                 <p class="lead" style="opacity: 0.5;">Creating engaging motion graphics with a focus on visual storytelling and dynamic animation.</p>
    //             </li>
    //         </ul>
    //     </div>
    // </section>
    ?>

    <!-- Portfolio Section -->  
    <section id="portfolio" class="py-4"> <!-- Decrease padding to bring sections closer -->
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2 class="display-4">Related Projects</h2>
                <a href="portfolio/add.php" class="btn btn-primary">Add Works</a>
            </div>
            <div class="row row-cols-1 row-cols-md-2 g-4"> <!-- Changed to 4 columns -->
                <?php if ($result->num_rows > 0): ?>
                    <?php 
                    // Fetch all rows into an array
                    $projects = [];
                    while ($row = $result->fetch_assoc()) {
                        $projects[] = $row;
                    }
                    // Display the projects in the original order
                    foreach ($projects as $row): ?>
                        <div class="col">
                            <div class="card h-100 text-light" style="background-color: #222; border: none; position: relative; overflow: hidden;" onclick="window.location='portfolio/view.php?id=<?php echo $row['id']; ?>'">
                                <img src="uploads/<?php echo htmlspecialchars($row['thumbnail']); ?>" class="card-img-top" alt="Thumbnail" style="height: auto; width: 100%; aspect-ratio: 16 / 9; object-fit: cover; transition: filter 0.3s ease; cursor: pointer;">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
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
    <?php
    /*
    <!-- Contact Section -->
    <section id="contact" class="py-4">
        <div class="container">
            <h2 class="display-4">Contact Me</h2>
            <p class="lead">For any questions or inquiries, please don't hesitate to reach out.</p>
            <div class="d-grid gap-2 d-md-flex justify-content-md-start">
                <a href="mailto:info@example.com" class="btn btn-primary me-md-2">Email Me</a>
            </div>
        </div>
    </section>
    */
    ?>

    <!-- Footer -->
    <footer class="footer text-center">
        <div class="container">
            <p>&copy; 2025 My Portfolio. All rights reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
