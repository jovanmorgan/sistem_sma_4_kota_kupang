<!DOCTYPE html>
<html lang="en">
<?php include "fitur/head.php"; ?>

<body>

    <?php include "fitur/navbar.php"; ?>

    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid position-relative overlay-bottom" style="margin-bottom: 90px">
        <div class="container text-center my-5 py-5">
            <h1 class="text-white mt-4 mb-4">Silakan Lihat Dan Cari Data Anda Disini</h1>
            <h1 class="text-white display-1 mb-5">DATA SISWA</h1>
            <div class="mx-auto mb-5" style="width: 100%; max-width: 600px">
                <form method="POST" action="">
                    <div class="input-group">
                        <input type="text" name="search_term" class="form-control border-light"
                            style="padding: 30px 25px" placeholder="Masukkan NISN, NIS, atau Nama" required />
                        <div class="input-group-append">
                            <button class="btn btn-secondary px-4 px-lg-5" type="submit">Search</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Header End -->

    <!-- Detail Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mb-5">
                        <div id="load_data">
                            <section class="section">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card shadow-sm">
                                            <div class="card-body text-center">
                                                <h2 class="section-title">Hasil Pendaftaran</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <?php
                            include '../../keamanan/koneksi.php';

                            // Cek apakah form disubmit
                            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                                $search_term = $_POST['search_term'];

                                // Query untuk mencari data pendaftar
                                $query = "SELECT * FROM pendaftar WHERE nisn = ? OR nik = ? OR nama LIKE ?";
                                $stmt = $koneksi->prepare($query);
                                $like_search = "%$search_term%"; // Untuk pencarian dengan LIKE
                                $stmt->bind_param("sss", $search_term, $search_term, $like_search);
                                $stmt->execute();
                                $result = $stmt->get_result();
                            ?>

                                <section class="section">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="card shadow-lg">
                                                <div class="card-body">
                                                    <div style="overflow-x: auto;">
                                                        <?php if ($result->num_rows > 0): ?>
                                                            <?php while ($row = $result->fetch_assoc()): ?>
                                                                <div
                                                                    class="alert alert-<?php echo ($row['status'] == 'lulus') ? 'info' : (($row['status'] == 'tidak_lulus') ? 'danger' : 'warning'); ?> text-center status-message">
                                                                    <?php
                                                                    if ($row['status'] == 'lulus') {
                                                                        echo '<h3 class="status-title success"><i class="fas fa-check-circle"></i> Selamat Anda Lulus!</h3>';
                                                                        echo '<p><i class="fas fa-user-graduate"></i> Selamat ' . $row['nama'] . ' menjadi bagian dari sekolah kami.</p>';
                                                                    } elseif ($row['status'] == 'tidak_lulus') {
                                                                        echo '<h3 class="status-title failed"><i class="fas fa-times-circle"></i> Maaf ' . $row['nama'] . ' Anda Tidak Lulus.</h3>';
                                                                        echo '<p><i class="fas fa-thumbs-up"></i> Tetap semangat dan coba lagi tahun depan.</p>';
                                                                    } else {
                                                                        echo '<h3 class="status-title validation"><i class="fas fa-clock"></i> Data Masih Divalidasi</h3>';
                                                                        echo '<p><i class="fas fa-spinner fa-spin"></i> Silakan tunggu sementara kami memproses pendaftaran Anda.</p>';
                                                                    }
                                                                    ?>
                                                                </div>

                                                            <?php endwhile; ?>
                                                        <?php else: ?>
                                                            <div class="alert alert-warning text-center status-message">
                                                                <h3 class="status-title validation"><i class="fas fa-clock"></i>
                                                                    Data Tidak Ditemukan</h3>
                                                                <p><i class="fas fa-exclamation-circle"></i> Silakan coba NISN,
                                                                    NIS, atau nama yang lain.</p>
                                                            </div>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </section>
                            <?php
                            } // Akhir dari cek form disubmit
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Detail End -->

    <?php include "fitur/footer.php"; ?>
</body>

</html>