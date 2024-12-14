<?php
include '../../../../keamanan/koneksi.php';

// Terima ID jurusan yang akan dihapus dari formulir HTML
$id_jurusan = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_jurusan)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data jurusan berdasarkan ID
$query_delete_jurusan = "DELETE FROM jurusan WHERE id_jurusan = '$id_jurusan'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_jurusan)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
