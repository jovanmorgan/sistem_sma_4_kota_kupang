<?php
include '../../../../keamanan/koneksi.php';

// Terima ID pembagian_kelas yang akan dihapus dari formulir HTML
$id_pembagian_kelas = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_pembagian_kelas)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data pembagian_kelas berdasarkan ID
$query_delete_pembagian_kelas = "DELETE FROM pembagian_kelas WHERE id_pembagian_kelas = '$id_pembagian_kelas'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_pembagian_kelas)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
