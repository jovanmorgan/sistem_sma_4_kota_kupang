<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_guru = $_POST['id_guru'];
$nip = $_POST['nip'];
$nama = $_POST['nama'];
$jk = $_POST['jk'];
$pangkat = $_POST['pangkat'];
$alamat = $_POST['alamat'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$tempat_lahir = $_POST['tempat_lahir'];
$agama = $_POST['agama'];

// Lakukan validasi data
if (empty($id_guru) || empty($nip) || empty($nama) || empty($jk) || empty($pangkat) || empty($alamat) || empty($tanggal_lahir) || empty($tempat_lahir) || empty($agama)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data guru
$query_update = "UPDATE guru 
                 SET nip = '$nip', 
                     nama = '$nama', 
                     jk = '$jk', 
                     pangkat = '$pangkat', 
                     alamat = '$alamat', 
                     tanggal_lahir = '$tanggal_lahir', 
                     tempat_lahir = '$tempat_lahir', 
                     agama = '$agama' 
                 WHERE id_guru = '$id_guru'";

// Jalankan query
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);
