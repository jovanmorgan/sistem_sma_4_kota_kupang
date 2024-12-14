<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_alumni = $_POST['id_alumni'];
$id_siswa = $_POST['id_siswa'];
$sekolah = $_POST['sekolah'];

// Lakukan validasi data
if (empty($id_alumni) || empty($id_siswa) || empty($sekolah)) {
    echo "data_tidak_lengkap";
    exit();
}
// Buat query SQL untuk mengupdate data
$query_update = "UPDATE alumni SET id_siswa = '$id_siswa', sekolah = '$sekolah' WHERE id_alumni = '$id_alumni'";

// Jalankan query
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
