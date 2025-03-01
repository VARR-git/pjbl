<?php
session_start();
include 'config/db.php';

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// READ - Tampil Data Siswa
$query = "SELECT * FROM data_murid";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Data Siswa</title>
    <link rel="stylesheet" href="css/styleMurid.css">
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Data Murid</h2>

    <!-- Tabel Data Siswa -->
    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>UID</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>No. Telp</th>
        </tr>

        <?php 
        $no = 1;
        while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['uid']); ?></td>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td><?= htmlspecialchars($row['kelas']); ?></td>
            <td><?= htmlspecialchars($row['no_telp']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>

    <br>
</body>
</html>