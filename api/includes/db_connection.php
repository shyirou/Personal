<?php
// Konfigurasi database
$host = 'db.ivptfdcevuwebxwkxlud.supabase.co';
$port = '5432';
$dbname = 'postgres';
$user = 'postgres';
$password = 'R4GlROXheGBZN7Ef';

try {
    // Membuat string DSN
    $dsn = "pgsql:host=$host;port=$port;dbname=$dbname;sslmode=require";
    
    // Membuat koneksi PDO
    $conn = new PDO($dsn, $user, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    return $conn;
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
