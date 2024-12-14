<?php
include '../../../../keamanan/koneksi.php';

// Terima ID pegawai yang akan dihapus dari formulir HTML
$id_pegawai = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_pegawai)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menghapus data pegawai berdasarkan ID
$query_delete_pegawai = "DELETE FROM pegawai WHERE id_pegawai = '$id_pegawai'";

// Jalankan query untuk menghapus data
if (mysqli_query($koneksi, $query_delete_pegawai)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
