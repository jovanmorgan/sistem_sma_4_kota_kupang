<?php
include '../../../../keamanan/koneksi.php';

// Terima ID guru yang akan dihapus dari formulir HTML
$id_guru = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_guru)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data guru berdasarkan ID
$query_delete_guru = "DELETE FROM guru WHERE id_guru = '$id_guru'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_guru)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
