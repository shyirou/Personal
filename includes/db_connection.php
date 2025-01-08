<?php
$host = 'db.ivptfdcevuwebxwkxlud.supabase.co';
$db = 'postgres';
$user = 'postgres';
$password = 'R4GlROXheGBZN7Ef';
$port = '6543';

try {
    // Membuat koneksi dengan PDO
    $dsn = "pgsql:host=$host;dbname=$dbname";
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
