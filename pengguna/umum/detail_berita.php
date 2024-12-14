<!DOCTYPE html>
<html lang="en">
<?php include "fitur/head.php"; ?>

<body>
    <!-- Topbar End -->
    <!-- Navbar Start -->
    <div class="container-fluid p-0">
        <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
            <a href="index.html" class="navbar-brand ml-lg-3">
                <h1 class="m-0 text-uppercase text-primary">
                    <img src="../../assets/img/sma/logo.png" alt="" width="50px" /><span style="margin-left: 10px">SMA
                        1
                        ABAD</span>
                </h1>
            </a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
                <div class="navbar-nav mx-auto py-0">
                    <a href="home" class="nav-item nav-link">Home</a>

                    <a href="home#tentang" class="nav-item nav-link">About</a>
                    <a href="home#berita" class="nav-item nav-link active">Berita</a>
                    <a href="home#galery" class="nav-item nav-link">Galery</a>
                    <a href="home#kontak" class="nav-item nav-link">Kontak</a>
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">Data</a>
                        <div class="dropdown-menu m-0">
                            <a href="data_siswa" class="dropdown-item">Siswa</a>
                            <a href="guru" class="dropdown-item">Guru</a>
                            <a href="pegawai" class="dropdown-item">Pegawai</a>
                            <a href="alumni" class="dropdown-item">Alumni</a>
                        </div>
                    </div>
                </div>
                <a href="../../berlangganan/login" class="btn btn-primary py-2 px-4 d-none d-lg-block">Gabung
                    Sekarang</a>
            </div>
        </nav>
    </div>
    <!-- Navbar End -->
    <?php include "fitur/header.php"; ?>

    <!-- Detail Start -->
    <div class="container-fluid py-5" id="berita">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-5">
                        <div class="section-title position-relative mb-5">
                            <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">
                                Detail Berita
                            </h6>
                            <h1 class="display-4">
                                <?php
                                include '../../keamanan/koneksi.php';

                                // Ambil id_berita dari parameter GET
                                $id_berita = isset($_GET['id_berita']) ? (int)$_GET['id_berita'] : 0;

                                // Query untuk mengambil data berita berdasarkan id
                                if ($id_berita > 0) {
                                    $query = "SELECT * FROM berita WHERE id_berita = $id_berita";
                                    $result = mysqli_query($koneksi, $query);

                                    if (mysqli_num_rows($result) > 0) {
                                        $berita = mysqli_fetch_assoc($result);
                                        $nama = $berita['nama'];
                                        $gambar = $berita['gambar'];
                                        $deskripsi = $berita['deskripsi'];
                                        echo $nama; // Menampilkan nama berita
                                    } else {
                                        echo "Berita tidak ditemukan.";
                                    }
                                } else {
                                    echo "ID berita tidak valid.";
                                }
                                ?>
                            </h1>
                        </div>
                        <img class="img-fluid rounded w-100 mb-4"
                            src="../../assets/img/berita/<?php echo isset($berita['gambar']) ? $berita['gambar'] : 'default.jpg'; ?>"
                            alt="<?php echo $nama; ?>" />
                        <p>
                            <?php echo isset($berita['deskripsi']) ? $berita['deskripsi'] : 'Deskripsi tidak tersedia.'; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail End -->

    <?php include "fitur/footer.php"; ?>
</body>

</html>