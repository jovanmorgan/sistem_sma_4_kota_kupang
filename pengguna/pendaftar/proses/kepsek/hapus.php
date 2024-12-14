<?php
include '../../../../keamanan/koneksi.php';

// Terima ID kepsek yang akan dihapus dari formulir HTML
$id_kepsek = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_kepsek)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data kepsek berdasarkan ID
$query_delete_kepsek = "DELETE FROM kepsek WHERE id_kepsek = '$id_kepsek'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_kepsek)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);