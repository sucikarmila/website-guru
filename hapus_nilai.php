<?php
include("koneksi.php");

if (isset($_GET['hapus']) && filter_var($_GET['hapus'], FILTER_VALIDATE_INT)) {
    $murid_id = $_GET['hapus'];
 
    $query = "DELETE FROM nilai WHERE murid_id = ?";
    $stmt = mysqli_prepare($koneksi, $query);
 
    mysqli_stmt_bind_param($stmt, "i", $murid_id);
 
    if (mysqli_stmt_execute($stmt)) {
        
        header("Location: kelola_nilai.php?success=" . urlencode('Data nilai berhasil dihapus'));
        exit;
    } else {
         
        $error_message = "Gagal menghapus data nilai: " . mysqli_error($koneksi);
        header("Location: kelola_nilai.php?error=" . urlencode($error_message));
        exit;
    }
} else {
     
    header("Location: kelola_nilai.php?error=" . urlencode('ID tidak valid'));
    exit;
}
?>
