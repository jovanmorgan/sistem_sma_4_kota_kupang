<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'fitur/head.php'; ?>

<body>
    <div class="wrapper">
        <?php include 'fitur/sidebar.php'; ?>
        <div class="main-panel">
            <?php include 'fitur/navbar.php'; ?>
            <div class="container">
                <div class="page-inner">
                    <div class="d-flex align-items-left align-items-md-center flex-column flex-md-row pt-2 pb-4">
                        <div>
                            <h3 class="fw-bold mb-3">Dashboard</h3>
                            <h6 class="op-7 mb-2">Halaman Dasboard</h6>
                        </div>
                    </div>

                    <?php
                    include '../../keamanan/koneksi.php';


                    // Query untuk mendapatkan status dan detail pendaftar
                    $query_detail_pendaftar = "
    SELECT 
        nisn, 
        nik, 
        jk, 
        kode_pos, 
        status 
    FROM pendaftar 
    WHERE id_pendaftar = ?
";

                    $stmt = $koneksi->prepare($query_detail_pendaftar);
                    $stmt->bind_param("s", $id_pendaftar);
                    $stmt->execute();
                    $result_detail_pendaftar = $stmt->get_result();

                    if ($result_detail_pendaftar->num_rows > 0) {
                        $row_detail_pendaftar = $result_detail_pendaftar->fetch_assoc();

                        // Ambil data pendaftar
                        $nisn = $row_detail_pendaftar['nisn'];
                        $nik = $row_detail_pendaftar['nik'];
                        $jk = $row_detail_pendaftar['jk'];
                        $kode_pos = $row_detail_pendaftar['kode_pos'];
                        $status = $row_detail_pendaftar['status'];

                        // Cek apakah data pendaftar lengkap
                        $data_incomplete = false;
                        if (empty($nisn) || empty($nik) || empty($jk) || empty($kode_pos)) {
                            $data_incomplete = true;
                        }
                    } else {
                        $data_incomplete = true; // Jika tidak ada data ditemukan
                        $status = 'Data tidak ditemukan';
                    }

                    $stmt->close();

                    // Query untuk mendapatkan jumlah lulus dan tidak lulus
                    $query_jumlah_pendaftar = "
    SELECT 
        SUM(CASE WHEN status = 'lulus' THEN 1 ELSE 0 END) AS jumlah_lulus,
        SUM(CASE WHEN status = 'tidak_lulus' THEN 1 ELSE 0 END) AS jumlah_tidak_lulus
    FROM pendaftar
";
                    $result_jumlah_pendaftar = mysqli_query($koneksi, $query_jumlah_pendaftar);
                    $row_jumlah_pendaftar = mysqli_fetch_assoc($result_jumlah_pendaftar);
                    $jumlah_lulus = $row_jumlah_pendaftar['jumlah_lulus'];
                    $jumlah_tidak_lulus = $row_jumlah_pendaftar['jumlah_tidak_lulus'];

                    mysqli_free_result($result_jumlah_pendaftar);

                    // Query untuk menghitung jumlah data pada setiap tabel
                    $tables = [
                        'pendaftar' => [
                            'label' => 'Pendaftar',
                            'icon' => 'fas fa-id-card-alt',
                            'color' => '#6C757D' // Gray
                        ],

                        // 'pengumuman' => [
                        //     'label' => 'Pengumuman',
                        //     'icon' => 'fas fa-bullhorn',
                        //     'color' => '#FFC107' // Yellow
                        // ],
                        'siswa' => [
                            'label' => 'Siswa',
                            'icon' => 'fas fa-user-graduate',
                            'color' => '#007BFF' // Blue
                        ]
                    ];

                    $counts = [];

                    foreach ($tables as $table => $details) {
                        $query = "SELECT COUNT(*) as count FROM $table";
                        $result = mysqli_query($koneksi, $query);
                        $row = mysqli_fetch_assoc($result);
                        $counts[$table] = $row['count'];
                        mysqli_free_result($result);
                    }

                    mysqli_close($koneksi);
                    ?>
                    <?php include 'fitur/nama_halaman.php'; ?>

                    <section class="section">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <h5 class="card-title" style="font-size: 30px;">Selamat Datang</h5>
                                        <p>
                                            Silakan lihat informsi yang kami sajikan pada website ini, Berikut adalah
                                            informasi data pada Halaman
                                            <?= $page_title ?>.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section class="section">
                        <div class="row">
                        </div>
                    </section>
                    <div class="row">
                        <?php foreach ($tables as $table => $details): ?>
                            <div class="col-sm-6 col-md-3">
                                <div class="card card-stats card-round">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-icon">
                                                <div class="icon-big text-center icon-secondary bubble-shadow-small"
                                                    style="background-color: <?= $details['color']; ?>;">
                                                    <i class="<?= $details['icon']; ?>"></i>
                                                </div>
                                            </div>
                                            <div class="col col-stats ms-3 ms-sm-0">
                                                <div class="numbers">
                                                    <p class="card-category"><?= $details['label']; ?></p>
                                                    <h4 class="card-title"><?= $counts[$table]; ?></h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <?php include 'fitur/footer.php'; ?>
        </div>

    </div>
    <?php include 'fitur/js.php'; ?>
</body>

</html>