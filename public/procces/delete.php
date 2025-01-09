<?php
require_once __DIR__ . '/../database/db.php';

// Ambil ID proyek dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Periksa apakah ID valid
if ($id > 0) {
    try {
        // Siapkan SQL untuk menghapus proyek
        $sqlFile = "SELECT thumbnail FROM projects WHERE id = $1"; // Use positional parameter for pgsql
        $resultFile = pg_query_params($conn, $sqlFile, array($id)); // Use pg_query_params for SELECT statement
        $thumbnailData = pg_fetch_assoc($resultFile); // Fetch the thumbnail data

        // Hapus file thumbnail jika ada
        if ($thumbnailData) {
            $thumbnailPath = '../uploads/' . $thumbnailData['thumbnail'];
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath); // Hapus file thumbnail
            }
        }

        // Hapus proyek dari database
        $sql = "DELETE FROM projects WHERE id = $1"; // Use positional parameter for pgsql
        $result = pg_query_params($conn, $sql, array($id)); // Use pg_query_params for DELETE statement
        
        // Periksa hasil eksekusi
        if ($result) {
            echo "<script>alert('Proyek berhasil dihapus.');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menghapus proyek.');</script>";
        }
    } catch (Exception $e) {
        echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('ID tidak valid.');</script>";
}

// Redirect back to the home page
header("Location: /home");
exit();
?>
