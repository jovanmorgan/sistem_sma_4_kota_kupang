<?php
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_berita = $_POST['id_berita'];
    $nama = $_POST['nama'];
    $waktu = $_POST['waktu'];
    $deskripsi = $_POST['deskripsi'];

    // Handling image upload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "../../../../assets/img/berita/";
        $target_file = $target_dir . basename($gambar);

        // Upload file
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Update query with new image
            $query = "UPDATE berita SET nama='$nama', waktu='$waktu', deskripsi='$deskripsi', gambar='$gambar' WHERE id_berita='$id_berita'";
        } else {
            echo 'error';
            exit;
        }
    } else {
        // Update query without new image
        $query = "UPDATE berita SET nama='$nama', waktu='$waktu', deskripsi='$deskripsi' WHERE id_berita='$id_berita'";
    }

    // Execute query
    if (mysqli_query($koneksi, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
