<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_jurusan = $_POST['id_jurusan'];
$nama_jurusan = $_POST['nama_jurusan'];

// Lakukan validasi data
if (empty($id_jurusan) || empty($nama_jurusan)) {
    echo "data_tidak_lengkap";
    exit();
}
// Buat query SQL untuk mengupdate data
$query_update = "UPDATE jurusan SET nama_jurusan = '$nama_jurusan' WHERE id_jurusan = '$id_jurusan'";

// Jalankan query
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
