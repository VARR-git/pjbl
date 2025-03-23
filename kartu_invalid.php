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

if (isset($_GET['action']) && isset($_GET['uid']) && $_GET['action'] == "register") {
    $uid = $_GET['uid'];
    $registerSQL = "INSERT INTO data_siswa (uid, nama, kelas, no_telp) 
                    SELECT uid, 'Nama Baru', 'Kelas', 'No Telp' FROM kartu_invalid WHERE uid = ?";
    $stmt = $conn->prepare($registerSQL);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->close();
    $deleteSQL2 = "DELETE FROM kartu_invalid WHERE uid = ?";
    $stmt = $conn->prepare($deleteSQL2);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $stmt->close();
    header("Location: register.php");
    exit();
}

$sql = "SELECT * FROM kartu_invalid";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Daftar Kartu Tidak Terdaftar</title>
  <link rel="stylesheet" href="css/styleKartu.css">
  <style>
    .btn {
      display: inline-block;
      padding: 8px 16px;
      margin: 2px;
      text-decoration: none;
      border-radius: 5px;
      font-weight: bold;
    }
    .btn-register {
      background-color: #4A90E2;
      color: white;
    }
    .btn-delete {
      background-color: #e74c3c;
      color: white;
      cursor: pointer;
    }
    .btn:hover {
      opacity: 0.8;
    }
    .actions {
      display: block;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      text-align: center;
      table-layout: auto;
      margin-top: 20px;
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
      .actions {
        display: flex;
        justify-content: center;
        gap: 5px;
      }
    }
    .modal {
      display: none;
      position: fixed;
      z-index: 1100;
      left: 0;
      top: 0;
      width: 100%;
      height: 100%;
      overflow: auto;
      background-color: rgba(0,0,0,0.5);
    }
    .modal-content {
      background-color: #fefefe;
      margin: 15% auto;
      padding: 20px;
      border: 1px solid #888;
      width: 300px;
      text-align: center;
      border-radius: 5px;
      font-family: Arial, sans-serif;
    }
    .modal-buttons button {
      margin: 10px;
      padding: 8px 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
    }
    .modal-buttons .btn-yes {
      background-color: rgb(92, 155, 255);
      color: white;
    }
    .modal-buttons .btn-no {
      background-color: #ccc;
      color: black;
    }
  </style>
</head>
<body>
  <?php include 'header.php'; ?>
  <h2 style="text-align:center;">Daftar Kartu Tidak Terdaftar</h2>
  <table id="kartuTable">
    <tr>
      <th>UID</th>
      <th>Aksi</th>
    </tr>
    <?php while ($row = $result->fetch_assoc()) { ?>
      <tr id="row-<?php echo htmlspecialchars($row['uid']); ?>">
        <td><?php echo htmlspecialchars($row['uid']); ?></td>
        <td class="actions">
          <a href="register.php?action=register&uid=<?php echo urlencode($row['uid']); ?>" class="btn btn-register">Daftarkan</a> 
          <a href="#" class="btn btn-delete delete-link" data-uid="<?php echo htmlspecialchars($row['uid']); ?>">Hapus</a>
        </td>
      </tr>
    <?php } ?>
  </table>

  <div id="deleteModal" class="modal">
    <div class="modal-content">
      <p>Apakah Anda yakin ingin menghapus kartu ini?</p>
      <div class="modal-buttons">
        <button class="btn-yes" id="deleteYes">Ya</button>
        <button class="btn-no" id="deleteNo">Tidak</button>
      </div>
    </div>
  </div>

  <script>
    let deleteUid = "";
    const deleteLinks = document.querySelectorAll('.delete-link');
    deleteLinks.forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        deleteUid = this.getAttribute('data-uid');
        document.getElementById('deleteModal').style.display = 'block';
      });
    });

    document.getElementById('deleteYes').addEventListener('click', function() {
      window.location.href = "delete.php?uid=" + encodeURIComponent(deleteUid);
    });

    document.getElementById('deleteNo').addEventListener('click', function() {
      document.getElementById('deleteModal').style.display = 'none';
    });

    window.addEventListener('click', function(event) {
      const modal = document.getElementById('deleteModal');
      if (event.target == modal) {
        modal.style.display = 'none';
      }
    });
  </script>
</body>
</html>
<?php
$conn->close();
ob_end_flush();
?>
