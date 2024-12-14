<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_pendaftar = $_POST['id_pendaftar'];
$status = $_POST['status'];

// Lakukan validasi data
if (empty($id_pendaftar) || empty($status)) {
    echo "data_tidak_lengkap";
    exit();
}
// Buat query SQL untuk mengupdate data
$query_update = "UPDATE pendaftar SET status = '$status' WHERE id_pendaftar = '$id_pendaftar'";

// Jalankan query
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
