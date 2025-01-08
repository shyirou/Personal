<?php
// Mendapatkan nilai dari environment variables
$host = getenv('DB_HOST');
$port = getenv('DB_PORT');
$dbname = getenv('DB_NAME');
$user = getenv('DB_USER');
$password = getenv('DB_PASSWORD');
$sslmode = getenv('DB_SSLMODE');

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
