<?php
include '../../../../keamanan/koneksi.php';

// Terima ID pensiun yang akan dihapus dari formulir HTML
$id_pensiun = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_pensiun)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data pensiun berdasarkan ID
$query_delete_pensiun = "DELETE FROM pensiun WHERE id_pensiun = '$id_pensiun'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_pensiun)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
