<?php
// Mendapatkan nilai dari environment variables
$host = 'ep-tiny-wildflower-a1zcicy3.ap-southeast-1.aws.neon.tech';
$port = '5432';
$dbname = 'porfolio';
$user = 'porfolio_owner';
$password = 'ds5efRBEOQD1';
$sslmode = 'require';

try {
    // Membuat string koneksi PDO
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=$sslmode";
    // Membuat koneksi PDO ke database PostgreSQL
    $pdo = new PDO($dsn, $user, $password);
    // Menetapkan mode error PDO sebagai pengecualian
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo 'Connected to the database successfully!';
} catch (PDOException $e) {
    // Menangani error jika koneksi gagal
    echo 'Connection failed: ' . $e->getMessage();
}
?>
