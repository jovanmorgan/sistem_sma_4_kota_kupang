<?php
// Sertakan koneksi ke database
include '../../../../keamanan/koneksi.php';

// Terima data dari form
$nip = $_POST['nip'];
$nama = $_POST['nama'];
$jk = $_POST['jk'];
$agama = $_POST['agama'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$jabatan = $_POST['jabatan'];

// Lakukan validasi data
if (empty($nip) || empty($nama) || empty($jk) || empty($agama) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($alamat) || empty($jabatan)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data ke tabel pegawai
$query_tambah = "INSERT INTO pegawai (nip, nama, jk, agama, tempat_lahir, tanggal_lahir, alamat, jabatan) 
                 VALUES ('$nip', '$nama', '$jk', '$agama', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$jabatan')";

// Jalankan query
if (mysqli_query($koneksi, $query_tambah)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi);
}

// Tutup koneksi
mysqli_close($koneksi);
