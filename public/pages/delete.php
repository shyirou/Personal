<?php
include'../database/db.php';

// Ambil ID proyek dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Periksa apakah ID valid
if ($id > 0) {
    try {
        // Siapkan SQL untuk menghapus proyek
        $sql = "DELETE FROM projects WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        
        // Eksekusi dan periksa hasil
        if ($stmt->execute()) {
            // Hapus file thumbnail jika ada
            $sqlFile = "SELECT thumbnail FROM projects WHERE id = :id";
            $stmtFile = $conn->prepare($sqlFile);
            $stmtFile->bindValue(':id', $id, PDO::PARAM_INT);
            $stmtFile->execute();
            $resultFile = $stmtFile->fetch(PDO::FETCH_ASSOC);
            
            if ($resultFile) {
                $thumbnailPath = '../uploads/' . $resultFile['thumbnail'];
                if (file_exists($thumbnailPath)) {
                    unlink($thumbnailPath); // Hapus file thumbnail
                }
            }
            
            echo "<script>alert('Proyek berhasil dihapus.');</script>";
        } else {
            echo "<script>alert('Terjadi kesalahan saat menghapus proyek.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Terjadi kesalahan: " . $e->getMessage() . "');</script>";
    }
} else {
    echo "<script>alert('ID tidak valid.');</script>";
}

// Redirect kembali ke halaman utama
header("Location: ../index.php");
exit();
?>
