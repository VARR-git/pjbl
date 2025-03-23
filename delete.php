<?php
ob_start();

$servername = "localhost";
$dbUsername = "root";  
$password   = "";
$dbname     = "absensi";

$conn = new mysqli($servername, $dbUsername, $password, $dbname);
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

if (isset($_GET['uid'])) {
    $uid = $_GET['uid'];
    $deleteSQL = "DELETE FROM kartu_invalid WHERE uid = ?";
    $stmt = $conn->prepare($deleteSQL);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: kartu_invalid.php");
exit();
?>
