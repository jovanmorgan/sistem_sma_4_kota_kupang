<?php
// Lakukan koneksi ke database
include '../../../../keamanan/koneksi.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Tangkap data lainnya dari form
    $id_pendaftar = $_POST['id_pendaftar'];
    $nama = $_POST['nama'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $jk = $_POST['jk'];
    $nisn = $_POST['nisn'];
    $nik = $_POST['nik'];
    $tempat_lahir = $_POST['tempat_lahir'];
    $tanggal_lahir = $_POST['tanggal_lahir'];
    $agama = $_POST['agama'];
    $alamat = $_POST['alamat'];
    $anak_keberapa = $_POST['anak_keberapa'];
    $kode_pos = $_POST['kode_pos'];
    $tgl_mendaftar = date('d-m-Y H:i:s');

    // Proses file SKL
    $new_file_name = null; // Inisialisasi variabel untuk nama file SKL
    if (isset($_FILES['skl']) && $_FILES['skl']['error'] === UPLOAD_ERR_OK) {
        $file_tmp = $_FILES['skl']['tmp_name'];
        $file_name = $_FILES['skl']['name'];

        // Tentukan direktori untuk menyimpan file
        $upload_dir = '../../../../assets/img/pdf/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true); // Buat folder jika belum ada
        }

        // Buat nama file unik untuk menghindari bentrok nama
        $new_file_name = uniqid('skl_', true) . '.' . pathinfo($file_name, PATHINFO_EXTENSION);

        // Pindahkan file dari temporary ke direktori tujuan
        if (!move_uploaded_file($file_tmp, $upload_dir . $new_file_name)) {
            echo "Gagal mengunggah file.";
            exit();
        }
    } else {
        echo "Harap unggah file SKL.";
        exit();
    }

    // Query SQL untuk update data (termasuk path file SKL)
    $query = "UPDATE pendaftar SET 
        nama='$nama', 
        password='$password', 
        username='$username', 
        jk='$jk', 
        nisn='$nisn', 
        nik='$nik', 
        tempat_lahir='$tempat_lahir', 
        tanggal_lahir='$tanggal_lahir', 
        agama='$agama', 
        alamat='$alamat', 
        anak_keberapa='$anak_keberapa', 
        skl='$new_file_name',  /* Simpan nama file SKL di database */
        tgl_mendaftar='$tgl_mendaftar', 
        kode_pos='$kode_pos' 
        WHERE id_pendaftar='$id_pendaftar'";

    // Lakukan proses update data di database
    $result = mysqli_query($koneksi, $query);
    if ($result) {
        echo "success"; // Respon berhasil jika semua proses berhasil
    } else {
        echo "Gagal melakukan proses update data: " . mysqli_error($koneksi);
    }
} else {
    echo "error_request_method";
}
