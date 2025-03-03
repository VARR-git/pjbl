<?php
session_start();
include 'config/db.php';
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
$query = "SELECT * FROM data_absen";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kehadiran</title>
    <link rel="stylesheet" href="css/styleAbsen.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Data Kehadiran Siswa</h2>
    <table border="1">
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Keterangan</th>
        </tr>
        <?php 
        $no = 1;
        while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= $no++; ?></td>
            <td><?= $row['nama']; ?></td>
            <td><?= $row['kelas']; ?></td>
            <td><?= $row['tanggal']; ?></td>
            <td><?= $row['jam_masuk']; ?></td>
            <td><?= $row['jam_keluar']; ?></td>
            <td><?= $row['keterangan']; ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>