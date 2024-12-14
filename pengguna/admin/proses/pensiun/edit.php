<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari form edit
$id_pensiun = $_POST['id_pensiun'];
$tanggal_pensiun = $_POST['tanggal_pensiun'];
$sk_pensiun = $_POST['sk_pensiun'];
$id_pegawai = $_POST['id_pegawai'];

// Lakukan validasi data
if (empty($id_pensiun) || empty($tanggal_pensiun) ||  empty($sk_pensiun) || empty($id_pegawai)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data pensiun berdasarkan id_pensiun
$query = "UPDATE pensiun 
          SET tanggal_pensiun = '$tanggal_pensiun', sk_pensiun = '$sk_pensiun', id_pegawai = '$id_pegawai'
          WHERE id_pensiun = '$id_pensiun'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
