<?php
// Sertakan koneksi ke database
include '../../../../keamanan/koneksi.php';

// Terima data dari form edit
$id_pegawai = $_POST['id_pegawai'];
$nip = $_POST['nip'];
$nama = $_POST['nama'];
$jk = $_POST['jk'];
$agama = $_POST['agama'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];
$jabatan = $_POST['jabatan'];

// Lakukan validasi data
if (empty($id_pegawai) || empty($nip) || empty($nama) || empty($jk) || empty($agama) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($alamat) || empty($jabatan)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mengupdate data pegawai
$query_edit = "UPDATE pegawai 
               SET nip = '$nip', nama = '$nama', jk = '$jk', agama = '$agama', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', alamat = '$alamat', jabatan = '$jabatan' 
               WHERE id_pegawai = '$id_pegawai'";

// Jalankan query
if (mysqli_query($koneksi, $query_edit)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi);
}

// Tutup koneksi
mysqli_close($koneksi);
