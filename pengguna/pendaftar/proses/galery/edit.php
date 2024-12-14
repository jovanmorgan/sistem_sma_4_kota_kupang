<?php
include '../../../../keamanan/koneksi.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_galery = $_POST['id_galery'];
    $nama = $_POST['nama'];
    $waktu = $_POST['waktu'];
    $deskripsi = $_POST['deskripsi'];

    // Handling image upload
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $gambar = $_FILES['gambar']['name'];
        $target_dir = "../../../../assets/img/galery/";
        $target_file = $target_dir . basename($gambar);

        // Upload file
        if (move_uploaded_file($_FILES['gambar']['tmp_name'], $target_file)) {
            // Update query with new image
            $query = "UPDATE galery SET nama='$nama', waktu='$waktu', deskripsi='$deskripsi', gambar='$gambar' WHERE id_galery='$id_galery'";
        } else {
            echo 'error';
            exit;
        }
    } else {
        // Update query without new image
        $query = "UPDATE galery SET nama='$nama', waktu='$waktu', deskripsi='$deskripsi' WHERE id_galery='$id_galery'";
    }

    // Execute query
    if (mysqli_query($koneksi, $query)) {
        echo 'success';
    } else {
        echo 'error';
    }
}
