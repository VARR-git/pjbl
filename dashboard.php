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
    <?php include 'header.php'; ?>

    <h2>Selamat Datang, <?= htmlspecialchars($username); ?>!</h2>
    <p>Anda berada di Dashboard.</p>
</body>
</html>