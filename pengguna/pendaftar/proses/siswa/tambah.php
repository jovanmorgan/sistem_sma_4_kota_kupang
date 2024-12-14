<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nis = $_POST['nis'];
$siswa = $_POST['siswa'];
$jk = $_POST['jk'];
$agama = $_POST['agama'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$id_kelas = $_POST['id_kelas'];

// Lakukan validasi data
if (empty($nis) || empty($siswa) || empty($jk) || empty($agama) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($alamat) || empty($id_kelas)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk menambahkan data siswa ke dalam database
$query = "INSERT INTO siswa (nis, nama, jk, agama, tempat_lahir, tanggal_lahir, alamat, id_kelas) 
          VALUES ('$nis', '$siswa', '$jk', '$agama', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$id_kelas')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi); // Tambahkan detail error
}

// Tutup koneksi ke database
mysqli_close($koneksi);
