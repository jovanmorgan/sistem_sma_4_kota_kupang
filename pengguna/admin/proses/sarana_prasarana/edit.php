<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_sarana_prasarana = $_POST['id_sarana_prasarana'];
$jumlah_gudang = $_POST['jumlah_gudang'];
$jumlah_ruangan = $_POST['jumlah_ruangan'];
$jumlah_kelas = $_POST['jumlah_kelas'];
$jumlah_lab = $_POST['jumlah_lab'];
$jumlah_lapangan = $_POST['jumlah_lapangan'];
$jumlah_kamar_mandi = $_POST['jumlah_kamar_mandi'];
$jumlah_perpustakaan = $_POST['jumlah_perpustakaan'];

// Lakukan validasi data
if (
    empty($id_sarana_prasarana) ||
    empty($jumlah_gudang) ||
    empty($jumlah_ruangan) ||
    empty($jumlah_kelas) ||
    empty($jumlah_lab) ||
    empty($jumlah_lapangan) ||
    empty($jumlah_kamar_mandi) ||
    empty($jumlah_perpustakaan)
) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data
$query_update = "UPDATE sarana_prasarana SET 
                    jumlah_gudang = '$jumlah_gudang', 
                    jumlah_ruangan = '$jumlah_ruangan', 
                    jumlah_kelas = '$jumlah_kelas', 
                    jumlah_lab = '$jumlah_lab', 
                    jumlah_lapangan = '$jumlah_lapangan', 
                    jumlah_kamar_mandi = '$jumlah_kamar_mandi', 
                    jumlah_perpustakaan = '$jumlah_perpustakaan' 
                WHERE id_sarana_prasarana = '$id_sarana_prasarana'";

// Jalankan query
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi);
}

// Tutup koneksi ke database
mysqli_close($koneksi);
