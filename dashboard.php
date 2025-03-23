<?php
session_start();

if (!isset($_SESSION['username'])) {
  header('Location: index.php');
  exit();
}

$_SESSION['allowed_page'] = true;
$username = $_SESSION['username'];

$_SESSION['diagram_token'] = bin2hex(random_bytes(32));
$_SESSION['download_token'] = bin2hex(random_bytes(32));

$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="css/styleDash.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
    .filter-container {
      text-align: center;
      margin: 20px;
    }
    .filter-container form {
      display: inline-flex;
      align-items: center;
      justify-content: center;
    }
    .filter-container input[type="date"] {
      padding: 5px;
      font-size: 14px;
      width: auto;
    }
    .filter-container button {
      padding: 5px 8px;
      font-size: 14px;
      background-color: rgb(92, 155, 255);
      color: #fff;
      border: none;
      cursor: pointer;
      margin-left: 10px;
    }
    .filter-container button:hover {
      background-color: rgb(82, 135, 219);
    }
    @media (max-width: 600px) {
      .filter-container form {
        flex-direction: column;
      }
      .filter-container button {
        margin-left: 0;
        margin-top: 8px;
      }
    }
    .download-container {
      text-align: center;
      margin-bottom: 20px;
    }
    .download-button {
      display: inline-block;
      padding: 10px 20px;
      background-color: rgb(92, 155, 255);
      color: white;
      text-decoration: none;
      font-size: 16px;
    }
    .download-button:hover {
      background-color: rgb(82, 135, 219);
    }
    .charts-wrapper {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 20px;
      margin: 20px;
    }
    .chart-container {
      flex: 1 1 30%;
      max-width: 600px;
      height: 300px;
      min-width: 280px;
    }
    @media (max-width: 600px) {
      .chart-container {
        flex: 1 1 100%;
      }
    }
    .table-container {
      width: 100%;
      overflow-x: auto;
      margin: 20px;
    }
    table {
      width: 100%;
      min-width: 600px; /* Menjamin lebar minimal tabel sehingga scroll horizontal muncul bila diperlukan */
      border-collapse: collapse;
      margin: 0 auto;
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
      font-size: 14px;
      white-space: nowrap;
    }
    .content-container {
      background: rgba(255, 255, 255, 0.8);
      padding: 20px;
      border-radius: 10px;
      margin: 20px;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>

  <div class="content-container">
    <div class="filter-container">
      <form method="get" action="dashboard.php">
        <label for="filter_date">Filter Tanggal: </label>
        <input type="date" id="filter_date" name="filter_date" value="<?php echo htmlspecialchars($filter_date); ?>">
        <button type="submit">Terapkan</button>
      </form>
    </div>

    <?php 
      $downloadUrl = ($filter_date != '')
          ? "download.php?filter_date=" . urlencode($filter_date) . "&token=" . $_SESSION['download_token']
          : "download.php?token=" . $_SESSION['download_token'];
    ?>
    <div class="download-container">
      <a href="<?php echo $downloadUrl; ?>" class="download-button">Download Data Excel</a>
    </div>

    <?php 
      $diagramUrl = ($filter_date != '')
          ? "diagram.php?filter_date=" . urlencode($filter_date) . "&token=" . $_SESSION['diagram_token']
          : "diagram.php?token=" . $_SESSION['diagram_token'];
    ?>
    <div class="charts-wrapper" id="chartsWrapper">
      <div class="chart-container">
        <canvas id="hadirChart"></canvas>
      </div>
      <div class="chart-container">
        <canvas id="terlambatChart"></canvas>
      </div>
      <div class="chart-container">
        <canvas id="combinedChart"></canvas>
      </div>
    </div>

    <div class="table-container">
      <h2>Data Absensi</h2>
      <table>
        <thead>
          <tr>
            <th>Nama</th>
            <th>Kelas</th>
            <th>Tanggal</th>
            <th>Jam Masuk</th>
            <th>Jam Keluar</th>
            <th>Keterangan</th>
          </tr>
        </thead>
        <tbody>
          <?php
            include 'config/db.php';
            if ($filter_date != '') {
                $query = "SELECT nama, kelas, tanggal, jam_masuk, jam_keluar, keterangan FROM data_absen 
                          WHERE tanggal = DATE_FORMAT(STR_TO_DATE('$filter_date','%Y-%m-%d'),'%d-%m-%Y')";
            } else {
                $query = "SELECT nama, kelas, tanggal, jam_masuk, jam_keluar, keterangan FROM data_absen";
            }
            $result = mysqli_query($conn, $query);
            if(mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['nama']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['kelas']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['tanggal']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jam_masuk']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['jam_keluar']) . "</td>";
                    echo "<td>" . htmlspecialchars($row['keterangan']) . "</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='6'>Data tidak terdeteksi</td></tr>";
            }
            mysqli_close($conn);
          ?>
        </tbody>
      </table>
    </div>
  </div>

  <script>
    const diagramUrl = "<?php echo $diagramUrl; ?>";

    fetch(diagramUrl)
      .then(response => response.json())
      .then(data => {
        const hadirCount = data.hadir;
        const terlambatCount = data.terlambat;

        if (hadirCount == 0 && terlambatCount == 0) {
          document.getElementById('chartsWrapper').innerHTML = '<p style="text-align:center; font-size:18px; color:#555;">Data tidak terdeteksi</p>';
          return;
        }

        const ctxHadir = document.getElementById('hadirChart').getContext('2d');
        new Chart(ctxHadir, {
          type: 'doughnut',
          data: {
            labels: ['Hadir Tepat Waktu'],
            datasets: [{
              label: 'Hadir Tepat Waktu',
              data: [hadirCount],
              backgroundColor: ['#4A90E2'],
              borderColor: ['#4A90E2'],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              title: {
                display: true,
                text: 'Hadir Tepat Waktu'
              }
            }
          }
        });

        const ctxTerlambat = document.getElementById('terlambatChart').getContext('2d');
        new Chart(ctxTerlambat, {
          type: 'doughnut',
          data: {
            labels: ['Terlambat'],
            datasets: [{
              label: 'Terlambat',
              data: [terlambatCount],
              backgroundColor: ['red'],
              borderColor: ['red'],
              borderWidth: 1
            }]
          },
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              title: {
                display: true,
                text: 'Terlambat'
              }
            }
          }
        });

        const ctxCombined = document.getElementById('combinedChart').getContext('2d');
        const originalCombinedData = {
          labels: ['Hadir Tepat Waktu', 'Terlambat'],
          datasets: [{
            label: 'Perbandingan Kehadiran',
            data: [hadirCount, terlambatCount],
            backgroundColor: ['#4A90E2', 'red'],
            borderColor: ['#4A90E2', 'red'],
            borderWidth: 1
          }]
        };

        new Chart(ctxCombined, {
          type: 'doughnut',
          data: JSON.parse(JSON.stringify(originalCombinedData)),
          options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
              title: {
                display: true,
                text: 'Perbandingan Kehadiran'
              }
            }
          }
        });
      })
      .catch(error => console.error("Error fetching data:", error));
  </script>
</body>
</html>
