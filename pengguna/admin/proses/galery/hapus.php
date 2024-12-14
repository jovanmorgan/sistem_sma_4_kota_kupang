<?php
include '../../../../keamanan/koneksi.php';

// Terima ID galery yang akan dihapus dari formulir HTML
$id_galery = $_POST['id']; // Ubah menjadi $_GET jika menggunakan metode GET

// Lakukan validasi data
if (empty($id_galery)) {
    echo "data_tidak_lengkap";
    exit();
}

// Buat query SQL untuk mendapatkan path gambar yang akan dihapus
$query_get_gambar = "SELECT gambar FROM galery WHERE id_galery = ?";
$stmt = mysqli_prepare($koneksi, $query_get_gambar);
mysqli_stmt_bind_param($stmt, 'i', $id_galery);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$row = mysqli_fetch_assoc($result);
$gambar_to_delete = $row['gambar'];

// Buat query SQL untuk memeriksa apakah ada data lain yang menggunakan file gambar yang akan dihapus
$query_check_gambar = "SELECT COUNT(*) AS total FROM galery WHERE gambar = ?";
$stmt_check = mysqli_prepare($koneksi, $query_check_gambar);
mysqli_stmt_bind_param($stmt_check, 's', $gambar_to_delete);
mysqli_stmt_execute($stmt_check);
$result_check = mysqli_stmt_get_result($stmt_check);
$row_check = mysqli_fetch_assoc($result_check);
$total_pengguna_gambar = $row_check['total'];

// Jika tidak ada data lain yang menggunakan file gambar, hapus gambar
if ($total_pengguna_gambar <= 1 && file_exists($gambar_to_delete)) {
    // Hapus file gambar dari folder
    if (!unlink($gambar_to_delete)) {
        echo "error"; // Error saat menghapus file
        exit();
    }
}

// Buat query SQL untuk menghapus data galery berdasarkan ID
$query_delete_galery = "DELETE FROM galery WHERE id_galery = ?";
$stmt_delete = mysqli_prepare($koneksi, $query_delete_galery);
mysqli_stmt_bind_param($stmt_delete, 'i', $id_galery);
if (mysqli_stmt_execute($stmt_delete)) {
    echo "success";
} else {
    echo "error";
}

// Tutup koneksi ke database
mysqli_close($koneksi);
