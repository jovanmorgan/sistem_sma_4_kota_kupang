<?php
include '../../../../keamanan/koneksi.php';

// Terima data dari formulir HTML
$id_siswa = $_POST['id_siswa'];
$id_jurusan = $_POST['id_jurusan'];
$siswa = $_POST['siswa'];
$jk = $_POST['jk'];
$agama = $_POST['agama'];
$tempat_lahir = $_POST['tempat_lahir'];
$tanggal_lahir = $_POST['tanggal_lahir'];
$alamat = $_POST['alamat'];

// Lakukan validasi data
if (empty($id_siswa) || empty($id_jurusan) || empty($siswa) || empty($jk) || empty($agama) || empty($tempat_lahir) || empty($tanggal_lahir) || empty($alamat)) {
    echo "data_tidak_lengkap";
    exit();
}

// Cari jurusan untuk mendapatkan karakter dari nama_jurusan
$query_jurusan = "SELECT nama_jurusan FROM jurusan WHERE id_jurusan = '$id_jurusan'";
$result_jurusan = mysqli_query($koneksi, $query_jurusan);
$row_jurusan = mysqli_fetch_assoc($result_jurusan);

if ($row_jurusan) {
    $char_jurusan = strtoupper(substr($row_jurusan['nama_jurusan'], 0, 1)); // Ambil huruf pertama dari nama_jurusan
} else {
    echo "jurusan_tidak_ditemukan";
    exit();
}

// Cari kelas berdasarkan id_jurusan
$query_kelas = "SELECT id_kelas, nama_kelas FROM kelas WHERE id_jurusan = '$id_jurusan'";
$result_kelas = mysqli_query($koneksi, $query_kelas);

// Variabel untuk menyimpan id_kelas yang valid
$id_kelas_valid = null;
$nama_kelas = "";
$kelas_ditemukan = mysqli_num_rows($result_kelas) > 0;

if ($kelas_ditemukan) {
    // Jika ada kelas, cek jumlah siswa dan pilih kelas dengan kurang dari 20 siswa
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
            break;
        }
    }
}

// Jika tidak ada kelas valid atau belum ada kelas untuk id_jurusan
if (!$kelas_ditemukan || $id_kelas_valid === null) {
    // Buat kelas baru dari A hingga Z
    $query_last_kelas = "SELECT nama_kelas FROM kelas WHERE id_jurusan = '$id_jurusan' ORDER BY nama_kelas DESC LIMIT 1";
    $result_last_kelas = mysqli_query($koneksi, $query_last_kelas);
    $last_kelas_row = mysqli_fetch_assoc($result_last_kelas);
    $last_kelas = $last_kelas_row ? $last_kelas_row['nama_kelas'] : 'A';

    // Jika sudah sampai Z, berikan pesan kesalahan
    if ($last_kelas === 'Z') {
        echo "kelas_penuh";
        exit();
    }

    // Tentukan nama kelas baru
    $nama_kelas_baru = $last_kelas ? chr(ord($last_kelas) + 1) : 'A';

    // Insert kelas baru
    $query_insert_kelas = "INSERT INTO kelas (id_jurusan, nama_kelas) VALUES ('$id_jurusan', '$nama_kelas_baru')";
    if (mysqli_query($koneksi, $query_insert_kelas)) {
        $id_kelas_valid = mysqli_insert_id($koneksi); // Ambil id_kelas baru yang dimasukkan
        $nama_kelas = $nama_kelas_baru;
    } else {
        echo "error_insert_kelas: " . mysqli_error($koneksi);
        exit();
    }
}

// Generate NIS baru
$query_nis = "SELECT MAX(nis) as max_nis FROM siswa WHERE id_kelas = '$id_kelas_valid'";
$result_nis = mysqli_query($koneksi, $query_nis);
$max_nis_row = mysqli_fetch_assoc($result_nis);

// Ambil angka dari NIS tertinggi yang ada
if ($max_nis_row['max_nis'] !== null) {
    $next_nis_number = (int)substr($max_nis_row['max_nis'], 2) + 1; // Ambil angka setelah 2 karakter pertama
} else {
    $next_nis_number = 100000; // Jika belum ada NIS, mulai dari 100000
}

// Format NIS baru: [huruf pertama nama_kelas][huruf pertama nama_jurusan][angka]
$char_kelas = strtoupper(substr($nama_kelas, 0, 1)); // Ambil huruf pertama dari nama_kelas
$nis_baru = $char_kelas . $char_jurusan . str_pad($next_nis_number, 5, '0', STR_PAD_LEFT); // Format NIS

// Cek jika NIS sudah ada sebelumnya
$query_nis_exist = "SELECT COUNT(*) as count FROM siswa WHERE nis = '$nis_baru'";
$result_nis_exist = mysqli_query($koneksi, $query_nis_exist);
$nis_exist_count = mysqli_fetch_assoc($result_nis_exist)['count'];

if ($nis_exist_count > 0) {
    echo "nis_sudah_ada"; // Pesan error jika NIS sudah ada
    exit();
}

// Buat query SQL untuk mengupdate data
$query_update = "UPDATE siswa SET nis = '$nis_baru', nama = '$siswa', jk = '$jk', agama = '$agama', tempat_lahir = '$tempat_lahir', tanggal_lahir = '$tanggal_lahir', alamat = '$alamat', id_kelas = '$id_kelas_valid' 
                 WHERE id_siswa = '$id_siswa'";

// Jalankan query
if (mysqli_query($koneksi, $query_update)) {
    echo "success";
} else {
    echo "error: " . mysqli_error($koneksi); // Tambahkan detail error
}

// Tutup koneksi ke database
mysqli_close($koneksi);
