<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$nis_siswa = $_POST['nis'];
$id_kelas = $_POST['id_kelas'];
$id_guru = $_POST['id_guru'];

// Lakukan validasi data
if (empty($nis_siswa) || empty($id_kelas) || empty($id_guru)) {
    echo "data_tidak_lengkap";
    exit();
}
// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO pembagian_kelas (nis_siswa, id_kelas, id_guru) 
        VALUES ('$nis_siswa', '$id_kelas', '$id_guru')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
