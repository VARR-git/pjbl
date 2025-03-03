<?php
header("Content-Type: application/json");
include 'config/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uid = $_POST['uid'];

    // Cek apakah UID sudah terdaftar
    $sql = "SELECT * FROM data_murid WHERE uid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $uid);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows == 0) {
        // UID belum terdaftar, masukkan ke tabel kartu_invalid
        $insertInvalid = "INSERT INTO kartu_invalid (uid) VALUES (?)";
        $stmt = $conn->prepare($insertInvalid);
        $stmt->bind_param("s", $uid);
        $stmt->execute();

        echo json_encode(["status" => "unregistered", "message" => "Kartu tidak terdaftar", "redirect" => "http://192.168.1.8/kartu_invalid.php"]);
    } else {
        // UID sudah terdaftar, lakukan absensi
        date_default_timezone_set("Asia/Jakarta");
        $murid = $result->fetch_assoc();
        $nama_murid = $murid['nama'];
        $kelas = $murid['kelas'];
        $tanggal = date("d-m-Y");
        $waktu_sekarang = date("H:i");

        // Atur batas waktu
        $batas_masuk = strtotime("06:45");
        $batas_keluar = strtotime("15:00");
        $waktu_sekarang_int = strtotime($waktu_sekarang);

        // Cek kartu sudah absen atau belum
        $query = "SELECT * FROM data_absen WHERE nama = '$nama_murid' AND tanggal = '$tanggal'";
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($result);

        if($data) {
            if (is_null($data['jam_keluar']) && $waktu_sekarang_int >= $batas_keluar) {
                $updateQuery = "UPDATE data_absen SET jam_keluar = '$waktu_sekarang' WHERE id = " . $data['id'];
                mysqli_query($conn, $updateQuery);
                echo "Jam keluar tercatat: " . $waktu_sekarang;
            } else {
                echo "Anda sudah melakukan absensi hari ini.";
            }
        } else {
            // Absen masuk
            $keterangan = ($waktu_sekarang_int <= $batas_masuk) ? "Hadir" : "Terlambat";

            $insertQuery = "INSERT INTO data_absen (nama, kelas, tanggal, jam_masuk, keterangan) 
                VALUES ((SELECT nama FROM data_murid WHERE uid = '$uid'), 
                        '$kelas', 
                        '$tanggal', 
                        '$waktu_sekarang', 
                        '$keterangan')";
            mysqli_query($conn, $insertQuery);
            echo "Jam masuk tercatat: " . $waktu_sekarang . " | Keterangan: " . $keterangan;
        }
    }
}
$conn->close();
?>
