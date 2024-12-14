<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$sekolah = $_POST['sekolah'];
$id_siswa = $_POST['id_siswa'];

// Lakukan validasi data
if (empty($sekolah) || empty($id_siswa)) {
    echo "data_tidak_lengkap";
    exit();
}
// Buat query SQL untuk menambahkan data masyarakat ke dalam database
$query = "INSERT INTO alumni (sekolah, id_siswa) 
        VALUES ('$sekolah','$id_siswa')";

// Jalankan query
if (mysqli_query($koneksi, $query)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
