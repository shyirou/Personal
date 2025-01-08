<?php
// Mengatur parameter koneksi
$host = 'db.ivptfdcevuwebxwkxlud.supabase.co';
$port = '6543'; // using the specified port
$dbname = 'postgres';
$user = 'postgres';
$password = 'R4GlROXheGBZN7Ef';

// Membuat string koneksi
$conn_string = "host=$host port=$port dbname=$dbname user=$user password=$password";

// Membuka koneksi ke database
$conn = pg_connect($conn_string);

// Memeriksa koneksi
if ($conn) {
    echo "Koneksi ke database berhasil!";
} else {
    echo "Koneksi gagal: " . pg_last_error();
}

// Menutup koneksi
pg_close($conn);
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
