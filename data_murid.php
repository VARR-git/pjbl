<?php
session_start();
include 'config/db.php';

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$query = "SELECT * FROM data_murid";
$result = mysqli_query($conn, $query) or die("Query Error: " . mysqli_error($conn));
?>
<!DOCTYPE html>
<html>
<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Murid</title>
    <link rel="stylesheet" href="css/styleMurid.css">
    <style>
      table {
        width: 100%;
        border-collapse: collapse;
        text-align: center;
      }
      table, th, td {
        border: 1px solid #ddd;
      }
      th, td {
        padding: 10px;
      }
      th {
        background-color: rgb(92, 155, 255);
        color: white;
        white-space: nowrap;
      }

      @media (max-width: 600px) {
        table {
          font-size: 12px;
        }
        th, td {
          padding: 4px;
        }
      }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>
    <h2>Data Murid</h2>
    <table>
        <tr>
            <th>UID</th>
            <th>Nama</th>
            <th>Kelas</th>
            <th>No. Telp</th>
        </tr>
        <?php while($row = mysqli_fetch_assoc($result)): ?>
        <tr>
            <td><?= htmlspecialchars($row['uid']); ?></td>
            <td><?= htmlspecialchars($row['nama']); ?></td>
            <td><?= htmlspecialchars($row['kelas']); ?></td>
            <td><?= htmlspecialchars($row['no_telp']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
