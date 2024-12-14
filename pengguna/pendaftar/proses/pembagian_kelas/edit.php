<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_pembagian_kelas = $_POST['id_pembagian_kelas']; // ID untuk mencari record yang akan diedit
$nis_siswa = $_POST['nis_siswa'];
$id_kelas = $_POST['id_kelas'];
$id_guru = $_POST['id_guru'];

// Lakukan validasi data
if (empty($id_pembagian_kelas) || empty($nis_siswa) || empty($id_kelas) || empty($id_guru)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk memperbarui data di database
$query = "UPDATE pembagian_kelas SET nis_siswa = '$nis_siswa', id_kelas = '$id_kelas', id_guru = '$id_guru' 
          WHERE id_pembagian_kelas = '$id_pembagian_kelas'";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);
