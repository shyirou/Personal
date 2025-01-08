<?php
// Mengambil parameter koneksi dari POSTGRES_URL
$postgres_url = "postgres://postgres.ivptfdcevuwebxwkxlud:R4GlROXheGBZN7Ef@aws-0-ap-southeast-1.pooler.supabase.com:6543/postgres?sslmode=require&supa=base-pooler.x";

// Memparse URL untuk mendapatkan informasi koneksi
$parsed_url = parse_url($postgres_url);

// Menyusun informasi koneksi
$host = $parsed_url['host'];
$port = $parsed_url['port'];
$dbname = ltrim($parsed_url['path'], '/');
$user = $parsed_url['user'];
$password = $parsed_url['pass'];

try {
    // Membuat koneksi dengan PDO
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname";
    $pdo = new PDO($dsn, $user, $password);

    // Menyiapkan opsi PDO (untuk menangani error)
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Koneksi ke database berhasil!";
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>



<?php   
    // Define the server name where the database is hosted
    // $servername = "localhost";
    // Define the username for database access
    // $username = "root";
    // Define the password for the database user
    // $password = "";
    // Define the name of the database to connect to
    // $dbname = "motion_graphic";

    // Create a new mysqli object to establish a connection to the database
    // $conn = new mysqli($servername, $username, $password, $dbname);

    // Check if the connection was successful; if not, terminate the script and display an error message
    // if ($conn->connect_error) {
    //     die("Connection failed: " . $conn->connect_error);
    // }
?>
