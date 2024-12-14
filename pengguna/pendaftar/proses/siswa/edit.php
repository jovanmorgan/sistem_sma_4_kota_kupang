<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_siswa = $_POST['id_siswa'];
$nis = $_POST['nis'];
$siswa = $_POST['siswa'];
$jk = $_POST['jk'];
$agama = $_POST['agama'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$id_kelas = $_POST['id_kelas'];

// Lakukan validasi data
if (empty($id_siswa) || empty($nis) || empty($siswa) || empty($jk) || empty($agama) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($alamat) || empty($id_kelas)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data
$query_update = "UPDATE siswa SET nis = '$nis', nama = '$siswa', jk = '$jk', agama = '$agama', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', alamat = '$alamat', id_kelas = '$id_kelas' 
                 WHERE id_siswa = '$id_siswa'";

// Jalankan query
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
