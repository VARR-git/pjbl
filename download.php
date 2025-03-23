<?php
include 'navigation_guard.php';
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

if (!isset($_GET['token']) || !isset($_SESSION['download_token']) || $_GET['token'] !== $_SESSION['download_token']) {
    header('Location: dashboard.php');
    exit();
}

include 'config/db.php';

$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Data_Absensi.xls");
header("Pragma: no-cache");
header("Expires: 0");

echo '<table border="1" style="width: auto; margin: 0 auto; text-align: center;">';

echo '<tr style="text-align: center;">';
echo '<th style="background-color: #4A90E2; color: white; text-align: center;">Nama</th>';
echo '<th style="background-color: #4A90E2; color: white; text-align: center;">Kelas</th>';
echo '<th style="background-color: #4A90E2; color: white; text-align: center;">Tanggal</th>';
echo '<th style="background-color: #4A90E2; color: white; text-align: center;">Jam Masuk</th>';
echo '<th style="background-color: #4A90E2; color: white; text-align: center;">Jam Keluar</th>';
echo '<th style="background-color: #4A90E2; color: white; text-align: center;">Keterangan</th>';
echo '</tr>';

if ($filter_date != '') {
    $query = "SELECT nama, kelas, tanggal, jam_masuk, jam_keluar, keterangan 
              FROM data_absen
              WHERE tanggal = DATE_FORMAT(STR_TO_DATE('$filter_date','%Y-%m-%d'),'%d-%m-%Y')";
} else {
    $query = "SELECT nama, kelas, tanggal, jam_masuk, jam_keluar, keterangan 
              FROM data_absen";
}

$result = mysqli_query($conn, $query);

if (mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        echo '<tr style="text-align: center;">';
        echo '<td style="text-align: center;">' . htmlspecialchars($row['nama']) . '</td>';
        echo '<td style="text-align: center;">' . htmlspecialchars($row['kelas']) . '</td>';
        echo '<td style="text-align: center;">' . htmlspecialchars($row['tanggal']) . '</td>';
        echo '<td style="text-align: center;">' . htmlspecialchars($row['jam_masuk']) . '</td>';
        echo '<td style="text-align: center;">' . htmlspecialchars($row['jam_keluar']) . '</td>';
        echo '<td style="text-align: center;">' . htmlspecialchars($row['keterangan']) . '</td>';
        echo '</tr>';
    }
} else {
    echo '<tr style="text-align: center;"><td colspan="6">Data tidak terdeteksi</td></tr>';
}

echo '</table>';

mysqli_close($conn);
?>
