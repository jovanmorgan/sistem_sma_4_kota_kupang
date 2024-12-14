<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama_jurusan = $_POST['nama_jurusan'];

// Lakukan validasi data
if (empty($nama_jurusan)) {
    echo "data_tidak_lengkap";
    exit();
}
// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO jurusan (nama_jurusan) 
        VALUES ('$nama_jurusan')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
