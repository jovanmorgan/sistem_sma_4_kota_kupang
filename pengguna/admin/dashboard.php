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


                    $query_kelas = "
    SELECT kelas.nama_kelas, COUNT(pembagian_kelas.id_kelas) as total_pembagian
    FROM pembagian_kelas
    INNER JOIN kelas ON pembagian_kelas.id_kelas = kelas.id_kelas
    GROUP BY kelas.nama_kelas
    ORDER BY total_pembagian DESC
    LIMIT 7
";
                    $result_kelas = mysqli_query($koneksi, $query_kelas);

                    $kelas_nama = [];
                    $total_pembagian = [];

                    while ($row_kelas = mysqli_fetch_assoc($result_kelas)) {
                        $kelas_nama[] = $row_kelas['nama_kelas'];
                        $total_pembagian[] = $row_kelas['total_pembagian'];
                    }

                    mysqli_free_result($result_kelas);

                    $query_siswa_kelas_jurusan = "
    SELECT kelas.nama_kelas, jurusan.nama_jurusan, COUNT(siswa.id_siswa) as total_siswa
    FROM siswa
    INNER JOIN kelas ON siswa.id_kelas = kelas.id_kelas
    INNER JOIN jurusan ON kelas.id_jurusan = jurusan.id_jurusan
    GROUP BY kelas.nama_kelas, jurusan.nama_jurusan
    ORDER BY total_siswa DESC
";
                    $result_siswa_kelas_jurusan = mysqli_query($koneksi, $query_siswa_kelas_jurusan);

                    $kelas_jurusan_nama = [];
                    $total_siswa = [];

                    while ($row_siswa_kelas_jurusan = mysqli_fetch_assoc($result_siswa_kelas_jurusan)) {
                        $kelas_jurusan_nama[] = $row_siswa_kelas_jurusan['nama_kelas'] . ' - ' . $row_siswa_kelas_jurusan['nama_jurusan'];
                        $total_siswa[] = $row_siswa_kelas_jurusan['total_siswa'];
                    }

                    mysqli_free_result($result_siswa_kelas_jurusan);

                    $query_status_pendaftar = "
    SELECT 
        SUM(CASE WHEN status = 'lulus' THEN 1 ELSE 0 END) AS jumlah_lulus,
        SUM(CASE WHEN status = 'tidak_lulus' THEN 1 ELSE 0 END) AS jumlah_tidak_lulus
    FROM pendaftar
";
                    $result_status_pendaftar = mysqli_query($koneksi, $query_status_pendaftar);

                    $row_status_pendaftar = mysqli_fetch_assoc($result_status_pendaftar);
                    $jumlah_lulus = $row_status_pendaftar['jumlah_lulus'];
                    $jumlah_tidak_lulus = $row_status_pendaftar['jumlah_tidak_lulus'];

                    mysqli_free_result($result_status_pendaftar);


                    $query_pendaftar_per_hari = "
    SELECT DATE(tgl_mendaftar) AS tanggal, COUNT(*) AS jumlah_pendaftar
    FROM pendaftar
    GROUP BY DATE(tgl_mendaftar)
    ORDER BY tanggal DESC
    LIMIT 10
";
                    $result_pendaftar_per_hari = mysqli_query($koneksi, $query_pendaftar_per_hari);

                    $tanggal_pendaftar = [];
                    $jumlah_pendaftar = [];

                    while ($row_pendaftar_per_hari = mysqli_fetch_assoc($result_pendaftar_per_hari)) {
                        $tanggal_pendaftar[] = $row_pendaftar_per_hari['tanggal'];
                        $jumlah_pendaftar[] = $row_pendaftar_per_hari['jumlah_pendaftar'];
                    }

                    mysqli_free_result($result_pendaftar_per_hari);

                    // Query untuk menghitung jumlah data pada setiap tabel
                    $tables = [
                        'alumni' => [
                            'label' => 'Alumni',
                            'icon' => 'fas fa-procedures',
                            'color' => '#FFC107' // Yellow
                        ],
                        'berita' => [
                            'label' => 'Berita',
                            'icon' => 'fas fa-hand-holding-usd',
                            'color' => '#DC3545' // Red
                        ],
                        'guru' => [
                            'label' => 'Guru',
                            'icon' => 'fas fa-id-card',
                            'color' => '#0D6EFD' // Blue
                        ],
                        'jurusan' => [
                            'label' => 'Jurusan',
                            'icon' => 'fas fa-id-card-alt',
                            'color' => '#28A745' // Green
                        ],
                        'kelas' => [
                            'label' => 'Kelas',
                            'icon' => 'fas fa-map-marker-alt',
                            'color' => '#6C757D' // Gray
                        ],
                        'pegawai' => [
                            'label' => 'Pegawai',
                            'icon' => 'fas fa-walking',
                            'color' => '#17A2B8' // Teal
                        ],
                        'pembagian_kelas' => [
                            'label' => 'Pembagian Kelas',
                            'icon' => 'fas fa-id-card',
                            'color' => '#FFC107' // Yellow
                        ],
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
                        ],
                        'galery' => [
                            'label' => 'Galeri',
                            'icon' => 'fas fa-image',
                            'color' => '#17A2B8' // Blue
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

                            <!-- Kelas yang paling banyak dibagi -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Kelas Yang Paling Banyak Dibagi</h5>
                                        <!-- Bar Chart -->
                                        <canvas id="kelasChart" style="max-height: 400px"></canvas>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new Chart(document.querySelector("#kelasChart"), {
                                                    type: "bar",
                                                    data: {
                                                        labels: <?= json_encode($kelas_nama); ?>,
                                                        datasets: [{
                                                            label: "Jumlah Pembagian Kelas",
                                                            data: <?= json_encode($total_pembagian); ?>,
                                                            backgroundColor: [
                                                                "rgba(255, 99, 132, 0.2)",
                                                                "rgba(255, 159, 64, 0.2)",
                                                                "rgba(255, 205, 86, 0.2)",
                                                                "rgba(75, 192, 192, 0.2)",
                                                                "rgba(54, 162, 235, 0.2)",
                                                                "rgba(153, 102, 255, 0.2)",
                                                                "rgba(201, 203, 207, 0.2)",
                                                            ],
                                                            borderColor: [
                                                                "rgb(255, 99, 132)",
                                                                "rgb(255, 159, 64)",
                                                                "rgb(255, 205, 86)",
                                                                "rgb(75, 192, 192)",
                                                                "rgb(54, 162, 235)",
                                                                "rgb(153, 102, 255)",
                                                                "rgb(201, 203, 207)",
                                                            ],
                                                            borderWidth: 1,
                                                        }],
                                                    },
                                                    options: {
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true,
                                                            },
                                                        },
                                                    },
                                                });
                                            });
                                        </script>
                                        <!-- End Bar Chart -->
                                    </div>
                                </div>
                            </div>

                            <!-- Siswa Berdasarkan Kelas dan Jurusan -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Jumlah Siswa per Kelas dan Jurusan</h5>
                                        <!-- Bar Chart -->
                                        <canvas id="siswaKelasJurusanChart" style="max-height: 400px"></canvas>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new Chart(document.querySelector("#siswaKelasJurusanChart"), {
                                                    type: "bar",
                                                    data: {
                                                        labels: <?= json_encode($kelas_jurusan_nama); ?>,
                                                        datasets: [{
                                                            label: "Jumlah Siswa",
                                                            data: <?= json_encode($total_siswa); ?>,
                                                            backgroundColor: [
                                                                "rgba(75, 192, 192, 0.2)",
                                                                "rgba(54, 162, 235, 0.2)",
                                                                "rgba(153, 102, 255, 0.2)",
                                                                "rgba(255, 205, 86, 0.2)",
                                                                "rgba(255, 99, 132, 0.2)",
                                                                "rgba(255, 159, 64, 0.2)",
                                                                "rgba(201, 203, 207, 0.2)",
                                                            ],
                                                            borderColor: [
                                                                "rgb(75, 192, 192)",
                                                                "rgb(54, 162, 235)",
                                                                "rgb(153, 102, 255)",
                                                                "rgb(255, 205, 86)",
                                                                "rgb(255, 99, 132)",
                                                                "rgb(255, 159, 64)",
                                                                "rgb(201, 203, 207)",
                                                            ],
                                                            borderWidth: 1,
                                                        }],
                                                    },
                                                    options: {
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true,
                                                            },
                                                        },
                                                    },
                                                });
                                            });
                                        </script>
                                        <!-- End Bar Chart -->
                                    </div>
                                </div>
                            </div>

                            <!-- Pendaftar Berdasarkan Status (Lulus / Tidak Lulus) -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Status Pendaftar (Lulus dan Tidak Lulus)</h5>
                                        <!-- Pie Chart -->
                                        <canvas id="pendaftarStatusChart" style="max-height: 400px"></canvas>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new Chart(document.querySelector("#pendaftarStatusChart"), {
                                                    type: "pie",
                                                    data: {
                                                        labels: ["Lulus", "Tidak Lulus"],
                                                        datasets: [{
                                                            label: "Jumlah Pendaftar",
                                                            data: [<?= $jumlah_lulus; ?>,
                                                                <?= $jumlah_tidak_lulus; ?>
                                                            ],
                                                            backgroundColor: [
                                                                "rgba(75, 192, 192, 0.7)",
                                                                "rgba(255, 99, 132, 0.7)",
                                                            ],
                                                            hoverBackgroundColor: [
                                                                "rgba(75, 192, 192, 0.9)",
                                                                "rgba(255, 99, 132, 0.9)",
                                                            ],
                                                            borderColor: [
                                                                "rgba(75, 192, 192, 1)",
                                                                "rgba(255, 99, 132, 1)",
                                                            ],
                                                            borderWidth: 1,
                                                        }],
                                                    },
                                                    options: {
                                                        responsive: true,
                                                        plugins: {
                                                            legend: {
                                                                position: 'top',
                                                            },
                                                            tooltip: {
                                                                callbacks: {
                                                                    label: function(context) {
                                                                        let label = context.label || '';
                                                                        if (label) {
                                                                            label += ': ';
                                                                        }
                                                                        label += context.raw;
                                                                        return label;
                                                                    }
                                                                }
                                                            }
                                                        }
                                                    }
                                                });
                                            });
                                        </script>
                                        <!-- End Pie Chart -->
                                    </div>
                                </div>
                            </div>

                            <!-- Pendaftar Per Hari -->
                            <div class="col-lg-6">
                                <div class="card">
                                    <div class="card-body">
                                        <h5 class="card-title text-center">Pendaftar Per Hari</h5>
                                        <!-- Line Chart -->
                                        <canvas id="pendaftarChart" style="max-height: 400px"></canvas>
                                        <script>
                                            document.addEventListener("DOMContentLoaded", () => {
                                                new Chart(document.querySelector("#pendaftarChart"), {
                                                    type: "line", // Anda bisa mengganti ini ke "bar" jika ingin grafik batang
                                                    data: {
                                                        labels: <?= json_encode(array_reverse($tanggal_pendaftar)); ?>, // Tanggal dari PHP
                                                        datasets: [{
                                                            label: "Jumlah Pendaftar", // Label untuk dataset
                                                            data: <?= json_encode(array_reverse($jumlah_pendaftar)); ?>, // Data dari PHP
                                                            backgroundColor: "rgba(54, 162, 235, 0.2)", // Warna background area
                                                            borderColor: "rgba(54, 162, 235, 1)", // Warna garis
                                                            borderWidth: 1,
                                                        }],
                                                    },
                                                    options: {
                                                        scales: {
                                                            y: {
                                                                beginAtZero: true, // Memulai sumbu Y dari 0
                                                            },
                                                        },
                                                    },
                                                });
                                            });
                                        </script>
                                        <!-- End Line Chart -->
                                    </div>
                                </div>
                            </div>


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