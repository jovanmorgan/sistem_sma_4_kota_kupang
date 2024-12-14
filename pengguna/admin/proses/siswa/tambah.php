<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_jurusan = $_POST['id_jurusan'];
$siswa = $_POST['siswa'];
$jk = $_POST['jk'];
$agama = $_POST['agama'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];

// Lakukan validasi data
if (empty($id_jurusan) || empty($siswa) || empty($jk) || empty($agama) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($alamat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Cari jurusan untuk mendapatkan karakter dari nama_jurusan
$query_jurusan = "SELECT nama_jurusan FROM jurusan WHERE id_jurusan = '$id_jurusan'";
$result_jurusan = mysqli_query($koneksi, $query_jurusan);
$row_jurusan = mysqli_fetch_assoc($result_jurusan);
$char_jurusan = strtoupper(substr($row_jurusan['nama_jurusan'], 0, 1)); // Ambil huruf pertama dari nama_jurusan

// Cari kelas berdasarkan id_jurusan
$query_kelas = "SELECT id_kelas, nama_kelas FROM kelas WHERE id_jurusan = '$id_jurusan'";
$result_kelas = mysqli_query($koneksi, $query_kelas);

// Variabel untuk menyimpan id_kelas yang valid
$id_kelas_valid = null;
$nis = null; // Variabel untuk menyimpan NIS
$next_nama_kelas = 'A'; // Mulai nama kelas dari 'A'

if (mysqli_num_rows($result_kelas) > 0) {
    // Looping untuk memeriksa apakah ada kelas yang kurang dari 20 siswa
    while ($row_kelas = mysqli_fetch_assoc($result_kelas)) {
        $id_kelas = $row_kelas['id_kelas'];
        $nama_kelas = $row_kelas['nama_kelas'];

        // Cek jumlah siswa dengan id_kelas ini
        $query_count = "SELECT COUNT(*) as count FROM siswa WHERE id_kelas = '$id_kelas'";
        $result_count = mysqli_query($koneksi, $query_count);
        $count = mysqli_fetch_assoc($result_count)['count'];

        // Jika kurang dari 20 siswa, gunakan id_kelas ini
        if ($count < 20) {
            $id_kelas_valid = $id_kelas;

            // Generate NIS berdasarkan kelas dan jurusan
            $next_nis_number = 100000 + $count; // NIS dimulai dari 100000
            $nis = strtoupper(substr($nama_kelas, 0, 1)) . $char_jurusan . $next_nis_number; // Format NIS

            break; // Hentikan pencarian jika ditemukan id_kelas yang valid
        }

        // Simpan nama kelas terakhir
        $next_nama_kelas = chr(ord($nama_kelas) + 1); // Naikkan nama kelas ke huruf berikutnya
    }
}

// Jika tidak ada id_kelas yang valid, buat kelas baru jika masih dalam batas "Z"
if ($id_kelas_valid === null) {
    if (ord($next_nama_kelas) <= ord('Z')) {
        // Tambahkan kelas baru
        $query_insert_kelas = "INSERT INTO kelas (nama_kelas, id_jurusan) VALUES ('$next_nama_kelas', '$id_jurusan')";
        if (mysqli_query($koneksi, $query_insert_kelas)) {
            // Ambil id_kelas yang baru ditambahkan
            $id_kelas_valid = mysqli_insert_id($koneksi);

            // NIS dimulai dari 100000 untuk kelas baru
            $next_nis_number = 100000;
            $nis = $next_nama_kelas . $char_jurusan . $next_nis_number; // Format NIS
        } else {
            echo "error: " . mysqli_error($koneksi); // Tambahkan detail error
            exit();
        }
    } else {
        echo "tidak_ada_kelas_tersedia";
        exit();
    }
}

// Buat query SQL untuk menambahkan data siswa ke dalam database
$query_insert_siswa = "INSERT INTO siswa (nis, nama, jk, agama, tempat_lahir, tanggal_lahir, alamat, id_kelas) 
                       VALUES ('$nis', '$siswa', '$jk', '$agama', '$tempat_lahir', '$tanggal_lahir', '$alamat', '$id_kelas_valid')";

// Jalankan query
if (mysqli_query($koneksi, $query_insert_siswa)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi); // Tambahkan detail error
}

// Tutup koneksi ke database
mysqli_close($koneksi);
