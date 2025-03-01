<?php
session_start();

// Cek apakah user sudah login
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Mendapatkan username yang sedang login
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="css/styleDash.css">
</head>
<body>
    <header>
        <h1>Absensi ID Card</h1>
    </header>

    <h2>Selamat Datang, <?= htmlspecialchars($username); ?>!</h2>
    <p>Anda berada di Dashboard.</p>

    <!-- Navigasi -->
    <ul class="options-list">
        <li><a href="kehadiran.php">Data Kehadiran</a></li>
        <li><a href="data_murid.php">Data Murid</a></li>
        <li><a href="kartu_invalid.php">Daftar Kartu</a></li>
        <li><a href="logout.php" onclick="return confirm('Yakin ingin logout?');">Logout</a></li>
    </ul>
</body>
</html>