<?php
// Konfigurasi database
$host = 'db.ivptfdcevuwebxwkxlud.supabase.co';
$port = '5432';
$dbname = 'postgres';
$user = 'postgres';
$password = 'R4GlROXheGBZN7Ef';
$sslmode = 'require';

try {
    // Membuat string DSN (Data Source Name)
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=$sslmode";

    // Membuat koneksi PDO
    $pdo = new PDO($dsn, $user, $password);

    // Set error mode agar mudah debug jika terjadi kesalahan
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Koneksi berhasil!";
} catch (PDOException $e) {
    // Menangkap error dan menampilkan pesan
    echo "Koneksi gagal: " . $e->getMessage();
}
