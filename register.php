<?php 
if (!isset($_GET['uid'])) {
    die("UID tidak ditemukan.");
}
$uid = $_GET['uid'];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pendaftaran Siswa</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background: linear-gradient(135deg, rgb(92, 155, 255),rgb(82, 135, 219), rgb(63, 123, 191));
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      margin: 0;
    }
    .login-form {
      background: white;
      width: 300px;
      padding: 20px 40px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      text-align: center;
    }
    .login-form h2 {
      margin-bottom: 20px;
      color: rgb(92, 155, 255);
    }
    .login-form label {
      display: block;
      text-align: left;
      margin-bottom: 5px;
      font-weight: bold;
      color: #333;
    }
    .login-form input[type="text"] {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border: 1px solid #ccc;
      border-radius: 5px;
      box-sizing: border-box;
    }
    .login-form button {
      width: 100%;
      padding: 10px;
      background: #4A90E2;
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }
    .login-form button:hover {
      background:rgb(63, 123, 191);
    }

    .login-form .back-button {
      width: 100%;
      padding: 10px;
      background: #e74c3c;
      border: none;
      border-radius: 5px;
      color: white;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
      margin-top: 10px;
    }
    .login-form .back-button:hover {
      background: #c0392b;
    }
    
    .modal {
      display: none;
      position: fixed;
      z-index: 10000;
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
      border-radius: 5px;
      text-align: center;
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
      background-color:  rgb(92, 155, 255);
      color: white;
    }
    .modal-buttons .btn-no {
      background-color: #ccc;
      color: #333;
    }
  </style>
</head>
<body>
  <div class="login-form">
    <h2>Pendaftaran Siswa</h2>
    <form action="register_process.php" method="POST">
      <input type="hidden" name="uid" value="<?= htmlspecialchars($uid) ?>">
      <label>Nama:</label>
      <input type="text" name="nama" required>
      <label>Kelas:</label>
      <input type="text" name="kelas" required>
      <label>No. Telp:</label>
      <input type="text" name="no_telp" required>
      <button type="submit">Daftar</button>
    </form>
    <button class="back-button" id="backBtn">Kembali</button>
  </div>

  
  <div id="confirmModal" class="modal">
    <div class="modal-content">
      <p>Anda yakin ingin keluar?</p>
      <div class="modal-buttons">
        <button class="btn-yes" id="confirmYes">Ya</button>
        <button class="btn-no" id="confirmNo">Tidak</button>
      </div>
    </div>
  </div>

  <script>
    
    const backBtn = document.getElementById('backBtn');
    const confirmModal = document.getElementById('confirmModal');
    const confirmYes = document.getElementById('confirmYes');
    const confirmNo = document.getElementById('confirmNo');

    
    backBtn.addEventListener('click', function() {
      confirmModal.style.display = 'block';
    });

    confirmYes.addEventListener('click', function() {
      window.location.href = 'dashboard.php';
    });

    confirmNo.addEventListener('click', function() {
      confirmModal.style.display = 'none';
    });

    window.addEventListener('click', function(event) {
      if (event.target == confirmModal) {
        confirmModal.style.display = 'none';
      }
    });
  </script>
</body>
</html>
