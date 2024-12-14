<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nama_kelas = $_POST['nama_kelas'];
$id_jurusan = $_POST['id_jurusan'];
$id_guru = $_POST['id_guru'];

// Lakukan validasi data
if (empty($nama_kelas) || empty($id_jurusan) || empty($id_guru)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data kelas ke dalam database
$query = "INSERT INTO kelas (nama_kelas, id_jurusan, id_guru) VALUES ('$nama_kelas', '$id_jurusan', '$id_guru')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
