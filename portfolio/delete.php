<?php
include '../includes/db_connection.php';

// Ambil ID proyek dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Periksa apakah ID valid
if ($id > 0) {
    // Siapkan SQL untuk menghapus proyek
    $sql = "DELETE FROM projects WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    // Eksekusi dan periksa hasil
    if ($stmt->execute()) {
        // Hapus file thumbnail jika ada
        $sqlFile = "SELECT thumbnail FROM projects WHERE id = ?";
        $stmtFile = $conn->prepare($sqlFile);
        $stmtFile->bind_param("i", $id);
        $stmtFile->execute();
        $resultFile = $stmtFile->get_result();
        
        if ($resultFile->num_rows > 0) {
            $rowFile = $resultFile->fetch_assoc();
            $thumbnailPath = '../uploads/' . $rowFile['thumbnail'];
            if (file_exists($thumbnailPath)) {
                unlink($thumbnailPath); // Hapus file thumbnail
            }
        }
        $stmtFile->close();
        
        echo "<script>alert('Proyek berhasil dihapus.');</script>";
    } else {
        echo "<script>alert('Terjadi kesalahan saat menghapus proyek.');</script>";
    }
    $stmt->close();
} else {
    echo "<script>alert('ID tidak valid.');</script>";
}

// Redirect kembali ke halaman utama setelah beberapa detik
header("Location: ../index.php");
exit();
?>
