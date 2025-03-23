<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

$allowedFiles = ['dashboard.php', 'download.php', 'diagram.php', 'header.php'];

$currentFile = basename($_SERVER['PHP_SELF']);

if (!in_array($currentFile, $allowedFiles)) {
    header("Location: dashboard.php");
    exit();
}
?>