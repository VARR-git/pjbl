<head>
    <style>
        body {
            margin: 0;
            padding: 0;
        }
        header {
            font-family: Arial, sans-serif;
            width: 100%;
            background-color: #4CAF50; /* Warna hijau */
            color: white;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 15px;
            box-sizing: border-box;
        }

        /* Gaya untuk judul */
        h1, a {
            color: white;
            margin: 0 auto; /* Pusatkan teks di tengah */
            font-size: 24px;
            text-align: center;
            text-decoration: none;
        }

        /* Tombol menu */
        .menu-button {
            background-color: transparent; /* Menyamakan dengan header */
            border: none; /* Hapus border */
            box-shadow: none; /* Hapus bayangan */
            padding: 10px 15px;
            cursor: pointer;
            font-size: 20px;
            color: white; /* Sesuaikan dengan warna teks header */
            position: fixed;
        }

        .menu-button:hover {
            background-color: rgba(255, 255, 255, 0.2); /* Efek hover jika diperlukan */
            border-radius: 5px;
        }

        /* Sidebar */
        .sidebar {
            display: flex;
            position: fixed;
            top: 0;
            left: -250px; /* Awalnya tersembunyi di kiri */
            width: 250px;
            height: 100%;
            background-color: #222;
            box-shadow: 2px 0 5px rgba(0, 0, 0, 0.5);
            transition: left 0.3s ease-in-out;
            z-index: 1000;
            padding-top: 5px;
            flex-direction: column;
        }

        /* Tombol close */
        .close-btn {
            margin-left: 220px;
            position: fixed;
            font-size: 24px;
            color: white;
            cursor: pointer;
        }

        /* Daftar navigasi */
        .options-list {
            list-style: none;
            padding: 0;
            margin-top: 30px;
        }

        .options-list li {
            cursor: pointer;
            border-bottom: 1px solid #444;
            text-align: center;
            height: 50px; /* Atur tinggi agar teks bisa dipusatkan */
            display: flex; /* Flexbox untuk pemusatan */
            align-items: center; /* Pusatkan vertikal */
            justify-content: center; /* Pusatkan horizontal */
        }

        .options-list li a {
            text-decoration: none;
            color: white;
            font-size: 18px;
            width: 100%; /* Pastikan link mengisi seluruh lebar li */
            height: 100%; /* Pastikan link mengisi seluruh tinggi li */
            display: flex; /* Flexbox untuk pemusatan */
            align-items: center; /* Pusatkan vertikal */
            justify-content: center; /* Pusatkan horizontal */
        }

        .options-list li:hover {
            background-color: #333;
        }

        /* Efek saat sidebar aktif */
        .sidebar.active {
            left: 0;
        }

        /* Overlay */
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        .overlay.active {
            display: block;
        }
    </style>
</head>

<header>
    <!-- Navigasi -->
    <button class="menu-button" onclick="toggleMenu()">☰</button>
    <!-- Sidebar -->
    <div class="sidebar" id="sidebar">
        <span class="close-btn" onclick="toggleMenu()">&times;</span>
        <ul class="options-list">
            <li><a href="kehadiran.php">Data Kehadiran</a></li>
            <li><a href="data_murid.php">Data Murid</a></li>
            <li><a href="kartu_invalid.php">Daftar Kartu</a></li>
            <li><a href="logout.php" onclick="return confirm('Yakin ingin logout?');">Logout</a></li>
        </ul>
    </div>

    <!-- Overlay -->
    <div class="overlay" id="overlay" onclick="toggleMenu()"></div>
        
    <h1><a href="dashboard.php">Absensi ID Card</a></h1>   
</header>

<script>
    function toggleMenu() {
    let sidebar = document.getElementById("sidebar");
    let overlay = document.getElementById("overlay");

    if (sidebar.style.left === "0px") {
        sidebar.style.left = "-250px";
        overlay.style.display = "none";
    } else {
        sidebar.style.left = "0px";
        overlay.style.display = "block";
    }
}
</script>