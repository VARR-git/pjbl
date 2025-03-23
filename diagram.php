<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

// Validasi token diagram
if (!isset($_GET['token']) || !isset($_SESSION['diagram_token']) || $_GET['token'] !== $_SESSION['diagram_token']) {
    header('Location: dashboard.php');
    exit();
}

unset($_SESSION['diagram_token']);

include 'config/db.php';

$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';

if ($filter_date != '') {
    $queryHadir = "SELECT COUNT(*) AS count FROM data_absen 
                   WHERE STR_TO_DATE(tanggal, '%d-%m-%Y') = STR_TO_DATE('$filter_date', '%Y-%m-%d')
                     AND keterangan IN ('Hadir', 'Tepat Waktu')";
    $queryTerlambat = "SELECT COUNT(*) AS count FROM data_absen 
                   WHERE STR_TO_DATE(tanggal, '%d-%m-%Y') = STR_TO_DATE('$filter_date', '%Y-%m-%d')
                     AND keterangan = 'Terlambat'";
} else {
    $queryHadir = "SELECT COUNT(*) AS count FROM data_absen 
                   WHERE keterangan IN ('Hadir', 'Tepat Waktu')";
    $queryTerlambat = "SELECT COUNT(*) AS count FROM data_absen 
                   WHERE keterangan = 'Terlambat'";
}

$resultHadir = mysqli_query($conn, $queryHadir);
$resultTerlambat = mysqli_query($conn, $queryTerlambat);

$hadirCount = 0;
$terlambatCount = 0;

if ($resultHadir && $rowHadir = mysqli_fetch_assoc($resultHadir)) {
    $hadirCount = (int)$rowHadir['count'];
}
if ($resultTerlambat && $rowTerlambat = mysqli_fetch_assoc($resultTerlambat)) {
    $terlambatCount = (int)$rowTerlambat['count'];
}

echo json_encode(["hadir" => $hadirCount, "terlambat" => $terlambatCount]);

mysqli_close($conn);
?>
