<?php
// Mengatur parameter koneksi
$host = 'db.ivptfdcevuwebxwkxlud.supabase.co';
$port = '6543'; // using the specified port
$dbname = 'postgres';
$user = 'postgres';
$password = 'R4GlROXheGBZN7Ef';

// Membuka koneksi ke database menggunakan MySQLi dengan exception handling
try {
    $conn = new mysqli($host, $user, $password, $dbname, $port);
    
    // Memeriksa koneksi
    if ($conn->connect_error) {
        throw new Exception("Koneksi gagal: " . $conn->connect_error);
    } else {
        echo "Koneksi ke database berhasil!";
    }
} catch (mysqli_sql_exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
} catch (Exception $e) {
    die("Koneksi gagal: " . $e->getMessage());
}
?>
