<?php
include '../../../../keamanan/koneksi.php';

// Terima ID siswa yang akan dihapus dari formulir HTML
$id_siswa = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_siswa)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data siswa berdasarkan ID
$query_delete_siswa = "DELETE FROM siswa WHERE id_siswa = '$id_siswa'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_siswa)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
