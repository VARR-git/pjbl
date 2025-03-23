<?php
session_start();
include 'config/db.php'; 

if (!isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}

$query = "SELECT * FROM data_absen";
$result = mysqli_query($conn, $query) or die("Query Error: " . mysqli_error($conn));
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Data Kehadiran</title>
  <link rel="stylesheet" href="css/styleAbsen.css">
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
      padding: 8px;
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
  <h2>Data Kehadiran Siswa</h2>
  <table>
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
      if($result) {
          while($row = mysqli_fetch_assoc($result)): ?>
            <tr>
              <td><?= $no++; ?></td>
              <td><?= htmlspecialchars($row['nama']); ?></td>
              <td><?= htmlspecialchars($row['kelas']); ?></td>
              <td><?= htmlspecialchars($row['tanggal']); ?></td>
              <td><?= htmlspecialchars($row['jam_masuk']); ?></td>
              <td><?= htmlspecialchars($row['jam_keluar']); ?></td>
              <td><?= htmlspecialchars($row['keterangan']); ?></td>
            </tr>
    <?php 
          endwhile;
      }
    ?>
  </table>
</body>
</html>

</html>
