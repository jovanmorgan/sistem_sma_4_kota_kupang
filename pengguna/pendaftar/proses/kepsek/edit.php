<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_kepsek = $_POST['id_kepsek']; // Pastikan 'id_kepsek' sudah dikirim melalui form
$nama_lengkap = $_POST['nama_lengkap'];
$username = $_POST['username'];
$password = $_POST['password'];

// Lakukan validasi data
if (empty($nama_lengkap) || empty($username) || empty($password)) {
    echo "data_tidak_lengkap";
    exit();
}

// Cek apakah username sudah ada di database
$check_query = "SELECT * FROM admin WHERE username = '$username'";
$result = mysqli_query($koneksi, $check_query);
if (mysqli_num_rows($result) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika username sudah terdaftar
    exit();
}

$check_query_pegawai = "SELECT * FROM pegawai WHERE username = '$username'";
$result_pegawai = mysqli_query($koneksi, $check_query_pegawai);
if (mysqli_num_rows($result_pegawai) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika username sudah terdaftar
    exit();
}

$check_query_kepsek = "SELECT * FROM kepsek WHERE username = '$username' AND id_kepsek != '$id_kepsek'";
$result_kepsek = mysqli_query($koneksi, $check_query_kepsek);
if (mysqli_num_rows($result_kepsek) > 0) {
    echo "data_sudah_ada"; // Kirim respon "data_sudah_ada" jika username sudah terdaftar
    exit();
}

if (strlen($password) < 8) {
    echo "error_password_length"; // Kirim respon jika panjang password kurang dari 8 karakter
    exit();
}

// Tambahkan logika untuk memeriksa password
if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $password)) {
    echo "error_password_strength"; // Kirim respon jika password tidak memenuhi syarat
    exit();
}

// Buat query SQL untuk mengedit data kepsek yang sudah ada berdasarkan id_kepsek
$query = "UPDATE kepsek 
            SET nama_lengkap = '$nama_lengkap', 
                username = '$username',
                password = '$password'
          WHERE id_kepsek = '$id_kepsek'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
