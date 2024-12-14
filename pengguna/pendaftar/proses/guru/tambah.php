<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nip = $_POST['nip'];
$nama = $_POST['nama'];
$jk = $_POST['jk'];
$pangkat = $_POST['pangkat'];
$alamat = $_POST['alamat'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$tempat_lahir = $_POST['tempat_lahir'];
$agama = $_POST['agama'];

// Lakukan validasi data
if (empty($nip) || empty($nama) || empty($jk) || empty($pangkat) || empty($alamat) || empty($tanggal_lahir) || empty($tempat_lahir) || empty($agama)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data guru ke dalam database
$query = "INSERT INTO guru (nip, nama, jk, pangkat, alamat, tanggal_lahir, tempat_lahir, agama) 
          VALUES ('$nip', '$nama', '$jk', '$pangkat', '$alamat', '$tanggal_lahir', '$tempat_lahir', '$agama')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);
