<?php
try {
    // Menyusun URL koneksi
    $dsn = "pgsql:host=ep-tiny-wildflower-a1zcicy3.ap-southeast-1.aws.neon.tech;port=5432;dbname=porfolio";
    $username = "porfolio_owner";
    $password = "ds5efRBEOQD1";

    // Menyambungkan ke database
    $pdo = new PDO($dsn, $username, $password, array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ));

    // Mengaktifkan SSL (Jika diperlukan)
    $pdo->exec("SET sslmode = 'require'");

    echo "Koneksi berhasil!";
} catch (PDOException $e) {
    echo "Koneksi gagal: " . $e->getMessage();
}
?>
