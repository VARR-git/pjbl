<?php
include 'koneksi.php';

// Salin data ke tabel backup
$backupQuery = "INSERT INTO backup_absen SELECT * FROM data_absen";
mysqli_query($conn, $backupQuery);

// Hapus data absensi hari ini
$deleteQuery = "DELETE FROM data_absen";
mysqli_query($conn, $deleteQuery);

echo "Backup dan reset data berhasil.";

mysqli_close($conn);
?>
