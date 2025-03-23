<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($username)) {
    $username = isset($_SESSION['username']) ? $_SESSION['username'] : '';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Dashboard Header</title>
  <style>
    body {
      margin: 0;
      padding: 0;
      font-family: Arial, sans-serif;
      font-weight: bold;
      padding-top: 70px;
    }
    
    header {
      position: fixed;
      top: 0;
      left: 0;
      z-index: 1100;
      width: 100%;
      background-color: rgb(92, 155, 255);
      color: white;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 10px 15px;
      box-sizing: border-box;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.16);
    }

    .menu-button {
      background-color: transparent;
      border: none;
      font-size: 20px;
      color: white;
      cursor: pointer;
      padding: 8px 10px;
    }
    .menu-button:hover {
      background-color: rgba(255,255,255,0.2);
      border-radius: 5px;
    }

    h1 {
      margin: 0;
      font-size: 20px;
      text-align: center;
    }
    h1 a {
      color: white;
      text-decoration: none;
    }

    .user-info {
      display: flex;
      align-items: center;
      gap: 10px;
    }
    .username-shape {
      background-color: white;
      color: rgb(92, 155, 255);
      border-radius: 5px;
      padding: 5px 10px;
      font-size: 1em;
    }

    .dashboard-logo {
      display: flex;
      align-items: center;
      justify-content: center;
      margin-left: -5px;
    }
    .dashboard-logo img {
      max-width: 50px;
      max-height: 50px;
      cursor: pointer;
      transform: rotate(0deg) !important;
      object-fit: contain;
    }

    .sidebar {
      position: fixed;
      top: 74px; 
      left: -250px;
      width: 250px;
      height: calc(100% - 70px);
      background-color: rgb(92, 155, 255);
      transition: left 0.3s ease-in-out, background-color 0.3s ease-in-out;
      z-index: 1000;
      display: flex;
      flex-direction: column;
      padding-top: 10px;
    }
    .sidebar.active {
      left: 0;
      background-color: rgb(82, 135, 219);
    }
    .close-btn {
      margin-left: 220px;
      position: fixed;
      font-size: 24px;
      color: white;
      cursor: pointer;
    }

    .options-list {
      list-style: none;
      padding: 0;
      margin-top: 20px;
    }
    .options-list li {
      cursor: pointer;
      border-bottom: 1px solid rgb(92, 155, 255);
      height: 50px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      padding: 0 10px;
    }
    .options-list li a {
      text-decoration: none;
      color: white;
      font-size: 18px;
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .options-list li:hover {
      background-color: rgb(92, 155, 255);
    }
    .menu-icon {
      text-align: right;
    }
    .menu-icon .icon {
      width: 20px;
      height: auto;
      vertical-align: middle;
      margin-left: 8px;
    }
    .menu-icon .hover {
      display: none;
    }
    .options-list li a:hover .default {
      display: none;
    }
    .options-list li a:hover .hover {
      display: inline;
    }

    .overlay {
      display: none;
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(3, 154, 255, 0);
      z-index: 999;
    }
    .overlay.active {
      display: block;
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
      width: 250px;
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

    @media (max-width: 600px) {
      body {
        padding-top: 60px;
      }
      header {
        padding: 10px;
      }
      .menu-button {
        font-size: 16px; 
        padding: 4px 6px;
      }
      
      h1 {
        font-size: 14px; 
      }
      .username-shape {
        font-size: 0.8em;
        padding: 3px 6px; 
      }
      
      .dashboard-logo img {
        max-width: 40px;
        max-height: 40px;
      }
      .sidebar {
        top: 60px;
        height: calc(100% - 60px);
      }
    }

    @media (min-width: 992px) {
      h1 {
        font-size: 28px;
      }
    }
  </style>
</head>
<body>
  <header>
    <button class="menu-button" onclick="toggleMenu()">☰</button>
    <h1>
      <a href="dashboard.php">Absensi Siswa/Siswi SMK Mitra Industri MM2100</a>
    </h1>

    <div class="user-info">
      <div class="username-shape"><?= htmlspecialchars($username); ?></div>
      <div class="dashboard-logo">
        <a href="dashboard.php">
          <img src="icon/mitra.png" alt="Logo Dashboard" />
        </a>
      </div>
    </div>
  </header>

  <div class="sidebar" id="sidebar">
    <span class="close-btn" onclick="toggleMenu()">&times;</span>
    <ul class="options-list">
      <li>
        <a href="dashboard.php">
          <span class="menu-text">Dashboard</span>
          <span class="menu-icon">
            <img src="icon/unclicked-dashboard.png" alt="Dashboard" class="icon default" />
            <img src="icon/clicked-dashboard.png" alt="Dashboard" class="icon hover" />
          </span>
        </a>
      </li>
      <li>
        <a href="kehadiran.php">
          <span class="menu-text">Data Kehadiran</span>
          <span class="menu-icon">
            <img src="icon/unclicked-attandance.png" alt="Data Kehadiran" class="icon default" />
            <img src="icon/clicked-attandance.png" alt="Data Kehadiran" class="icon hover" />
          </span>
        </a>
      </li>
      <li>
        <a href="data_murid.php">
          <span class="menu-text">Data Murid</span>
          <span class="menu-icon">
            <img src="icon/unclicked-student.png" alt="Data Murid" class="icon default" />
            <img src="icon/clicked-student.png" alt="Data Murid" class="icon hover" />
          </span>
        </a>
      </li>
      <li>
        <a href="kartu_invalid.php">
          <span class="menu-text">Daftar Kartu</span>
          <span class="menu-icon">
            <img src="icon/unclicked-idcard.png" alt="Daftar Kartu" class="icon default" />
            <img src="icon/clicked-idcard.png" alt="Daftar Kartu" class="icon hover" />
          </span>
        </a>
      </li>
      <li>
        <a href="#" class="logout-link">
          <span class="menu-text">Logout</span>
          <span class="menu-icon">
            <img src="icon/unclicked-logout.png" alt="Logout" class="icon default" />
            <img src="icon/clicked-logout.png" alt="Logout" class="icon hover" />
          </span>
        </a>
      </li>
    </ul>
  </div>

  <div class="overlay" id="overlay" onclick="toggleMenu()"></div>

  <div id="logoutModal" class="modal">
    <div class="modal-content">
      <p>Anda yakin ingin logout?</p>
      <div class="modal-buttons">
        <button class="btn-yes" id="logoutYes">Ya</button>
        <button class="btn-no" id="logoutNo">Tidak</button>
      </div>
    </div>
  </div>

  <script>
    function toggleMenu() {
      const sidebar = document.getElementById("sidebar");
      const overlay = document.getElementById("overlay");
      sidebar.classList.toggle("active");
      overlay.style.display = sidebar.classList.contains("active") ? "block" : "none";
    }

    document.querySelector('.logout-link').addEventListener('click', function(e) {
      e.preventDefault();
      document.getElementById('logoutModal').style.display = 'block';
    });

    document.getElementById('logoutYes').addEventListener('click', function() {
      window.location.href = 'logout.php';
    });
    document.getElementById('logoutNo').addEventListener('click', function() {
      document.getElementById('logoutModal').style.display = 'none';
    });
  </script>
</body>
</html>
