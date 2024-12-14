<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$visi = $_POST['visi'];
$misi = $_POST['misi'];
$alamat_sekolah = $_POST['alamat_sekolah'];

// Lakukan validasi data
if (empty($visi) || empty($misi) || empty($alamat_sekolah)) {
    echo "data_tidak_lengkap";
    exit();
}
// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO profile_sekolah (visi, misi, alamat_sekolah) 
        VALUES ('$visi' ,'$misi', '$alamat_sekolah')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
