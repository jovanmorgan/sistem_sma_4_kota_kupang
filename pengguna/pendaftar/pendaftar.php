<?php include 'fitur/penggunah.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'fitur/head.php'; ?>
<?php include 'fitur/nama_halaman.php'; ?>
<?php include 'fitur/nama_halaman_proses.php'; ?>

<body>
    <div class="wrapper">
        <?php include 'fitur/sidebar.php'; ?>
        <div class="main-panel">
            <?php include 'fitur/navbar.php'; ?>
            <div class="container">
                <div class="page-inner">
                    <?php include 'fitur/papan_halaman.php'; ?>

                    <style>
                    /* Title Styling */
                    .section-title {
                        font-size: 3rem;
                        font-weight: bold;
                        color: #4a90e2;
                        margin-bottom: 1rem;
                        text-transform: uppercase;
                        background: linear-gradient(45deg, #ff6b6b, #4a90e2);
                        -webkit-background-clip: text;
                        -webkit-text-fill-color: transparent;
                        animation: fadeIn 1s ease-in-out;
                    }

                    /* Card Styling */
                    .card {
                        border-radius: 20px;
                        background-color: #f7f8fa;
                        border: none;
                        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
                        transition: transform 0.3s ease;
                    }

                    .card:hover {
                        transform: scale(1.05);
                    }

                    /* Alert Messages */
                    .status-message {
                        font-size: 1.5rem;
                        font-weight: 600;
                        border-radius: 12px;
                        padding: 1.5rem;
                        margin-bottom: 1.5rem;
                        color: #fff;
                        background: linear-gradient(45deg, #4a90e2, #ff6b6b);
                        animation: pulse 1.5s infinite;
                    }

                    /* Success, Failure, Validation Styles */
                    .status-title.success {
                        color: #2ecc71;
                        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
                    }

                    .status-title.failed {
                        color: #e74c3c;
                        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
                    }

                    .status-title.validation {
                        color: #f39c12;
                        text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.2);
                    }

                    /* Icon Styling */
                    .status-title i {
                        margin-right: 10px;
                        font-size: 2rem;
                        animation: iconSpin 2s linear infinite;
                    }

                    /* Animations */
                    @keyframes fadeIn {
                        from {
                            opacity: 0;
                            transform: translateY(-20px);
                        }

                        to {
                            opacity: 1;
                            transform: translateY(0);
                        }
                    }

                    @keyframes pulse {
                        0% {
                            box-shadow: 0 0 10px rgba(255, 107, 107, 0.5);
                        }

                        100% {
                            box-shadow: 0 0 20px rgba(255, 107, 107, 1);
                        }
                    }

                    /* Responsive Font Scaling */
                    @media (max-width: 768px) {
                        .section-title {
                            font-size: 2.5rem;
                        }

                        .status-message {
                            font-size: 1.2rem;
                        }

                        .status-title i {
                            font-size: 1.75rem;
                        }
                    }
                    </style>

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
                        $query = "SELECT * FROM pendaftar WHERE id_pendaftar = ?";
                        $stmt = $koneksi->prepare($query);
                        $stmt->bind_param("s", $id_pendaftar);
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
                                                <div class="alert alert-info text-center status-message">
                                                    <?php
                                                            if ($row['status'] == 'lulus') {
                                                                echo '<h3 class="status-title success"><i class="fas fa-check-circle"></i> Selamat Anda Lulus!</h3>';
                                                                echo '<p><i class="fas fa-user-graduate"></i> Selamat menjadi bagian dari sekolah kami.</p>';
                                                            } elseif ($row['status'] == 'tidak_lulus') {
                                                                echo '<h3 class="status-title failed"><i class="fas fa-times-circle"></i> Maaf Anda Tidak Lulus.</h3>';
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
                                                        Data Masih Divalidasi</h3>
                                                    <p><i class="fas fa-spinner fa-spin"></i> Silakan tunggu sementara
                                                        kami memproses pendaftaran Anda.</p>
                                                </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>

                </div>
            </div>

            <?php include 'fitur/footer.php'; ?>
        </div>
    </div>
    <script>
    function openEditModal(id, jurusan) {
        let editModal = new bootstrap.Modal(document.getElementById('editModal'));
        document.getElementById('edit_id').value = id;
        document.getElementById('edit_jurusan').value = jurusan;
        editModal.show();
    }
    </script>
    <?php include 'fitur/js.php'; ?>
</body>

</html>