<?php
include '../../../../keamanan/koneksi.php';

// Terima ID kelas yang akan dihapus dari formulir HTML
$id_kelas = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_kelas)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data kelas berdasarkan ID
$query_delete_kelas = "DELETE FROM kelas WHERE id_kelas = '$id_kelas'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_kelas)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
