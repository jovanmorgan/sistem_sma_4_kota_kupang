<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form tambah
$tanggal_pensiun = $_POST['tanggal_pensiun'];
$sk_pensiun = $_POST['sk_pensiun'];
$id_pegawai = $_POST['id_pegawai'];

// Lakukan validasi data
if (empty($tanggal_pensiun) || empty($sk_pensiun) || empty($id_pegawai)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data pensiun ke dalam database
$query = "INSERT INTO pensiun (tanggal_pensiun,sk_pensiun, id_pegawai) 
          VALUES ('$tanggal_pensiun', '$sk_pensiun', '$id_pegawai')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
