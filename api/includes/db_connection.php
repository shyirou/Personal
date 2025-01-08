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
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Koneksi berhasil!";

    // Contoh query sederhana
    $query = $conn->query("SELECT version()");
    $result = $query->fetch(PDO::FETCH_ASSOC);
    print_r($result);
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
