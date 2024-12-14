<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_kelas = $_POST['id_kelas'];
$nama_kelas = $_POST['nama_kelas'];
$id_jurusan = $_POST['id_jurusan'];
$id_guru = $_POST['id_guru'];

// Lakukan validasi data
if (empty($id_kelas) || empty($nama_kelas) || empty($id_jurusan) || empty($id_guru)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data kelas
$query_update = "UPDATE kelas SET nama_kelas = '$nama_kelas', id_jurusan = '$id_jurusan', id_guru = '$id_guru' WHERE id_kelas = '$id_kelas'";

// Jalankan query
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
