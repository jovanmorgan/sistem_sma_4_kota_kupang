<?php
include '../../../../keamanan/koneksi.php';

// Terima ID alumni yang akan dihapus dari formulir HTML
$id_alumni = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_alumni)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data alumni berdasarkan ID
$query_delete_alumni = "DELETE FROM alumni WHERE id_alumni = '$id_alumni'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_alumni)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
