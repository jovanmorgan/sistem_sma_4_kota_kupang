<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_profile_sekolah = $_POST['id_profile_sekolah'];
$visi = $_POST['visi'];
$misi = $_POST['misi'];
$alamat_sekolah = $_POST['alamat_sekolah'];

// Lakukan validasi data
if (empty($id_profile_sekolah) || empty($visi) || empty($misi) || empty($alamat_sekolah)) {
    echo "data_tidak_lengkap";
    exit();
}
// Buat query SQL untuk mengupdate data
$query_update = "UPDATE profile_sekolah SET visi = '$visi' , misi = '$misi' , alamat_sekolah = '$alamat_sekolah' WHERE id_profile_sekolah = '$id_profile_sekolah'";

// Jalankan query
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
