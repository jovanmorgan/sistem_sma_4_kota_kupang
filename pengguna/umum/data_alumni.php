<!DOCTYPE html>
<html lang="en">
<?php include "fitur/head.php"; ?>

<body>

    <?php include "fitur/navbar.php"; ?>

    <!-- Header Start -->
    <div class="jumbotron jumbotron-fluid position-relative overlay-bottom" style="margin-bottom: 90px">
        <div class="container text-center my-5 py-5">
            <h1 class="text-white mt-4 mb-4">Silakan Lihat Dan Cari Data Alumni Disini</h1>
            <h1 class="text-white display-1 mb-5">DATA ALUMNI</h1>
            <div class="mx-auto mb-5" style="width: 100%; max-width: 600px">
                <form method="GET" action="">
                    <div class="input-group">
                        <input type="text" name="search"
                            value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>"
                            class="form-control border-light" style="padding: 30px 25px"
                            placeholder="Masukkan Nama Atau Nis Alumni Disini" required />
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

                            <?php
                            // Ambil data alumni dan siswa dari database
                            include '../../keamanan/koneksi.php';

                            $search = isset($_GET['search']) ? $_GET['search'] : '';
                            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                            $limit = 10;
                            $offset = ($page - 1) * $limit;

                            // Query untuk mendapatkan data alumni dan siswa dengan pencarian dan pagination
                            $query = "
    SELECT a.id_alumni, a.sekolah, a.id_siswa, s.nis, s.nama, s.jk, s.agama, s.tempat_lahir, s.tanggal_lahir, s.alamat
    FROM alumni a
    JOIN siswa s ON a.id_siswa = s.id_siswa
    WHERE s.nama LIKE ? LIMIT ?, ?";
                            $stmt = $koneksi->prepare($query);
                            $search_param = '%' . $search . '%';
                            $stmt->bind_param("sii", $search_param, $offset, $limit);
                            $stmt->execute();
                            $result = $stmt->get_result();

                            // Hitung total halaman
                            $total_query = "
    SELECT COUNT(*) as total 
    FROM alumni a
    JOIN siswa s ON a.id_siswa = s.id_siswa
    WHERE s.nama LIKE ? OR s.nis LIKE ? OR s.jk LIKE ? OR s.agama LIKE ?";
                            $stmt_total = $koneksi->prepare($total_query);
                            $stmt_total->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
                            $stmt_total->execute();
                            $total_result = $stmt_total->get_result();
                            $total_row = $total_result->fetch_assoc();
                            $total_pages = ceil($total_row['total'] / $limit);
                            ?>

                            <!-- Tabel Data Alumni -->
                            <section class="section">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body" style="overflow-x: hidden;">
                                                <div style="overflow-x: auto;">
                                                    <?php if ($result->num_rows > 0): ?>
                                                    <table class="table table-hover text-center mt-3"
                                                        style="border-collapse: separate; border-spacing: 0;">
                                                        <thead>
                                                            <tr>
                                                                <th style="white-space: nowrap;">Nomor</th>
                                                                <th style="white-space: nowrap;">ID Alumni</th>
                                                                <th style="white-space: nowrap;">Sekolah</th>
                                                                <th style="white-space: nowrap;">ID Siswa</th>
                                                                <th style="white-space: nowrap;">NIS</th>
                                                                <th style="white-space: nowrap;">Nama</th>
                                                                <th style="white-space: nowrap;">Jenis Kelamin</th>
                                                                <th style="white-space: nowrap;">Agama</th>
                                                                <th style="white-space: nowrap;">Tempat Lahir</th>
                                                                <th style="white-space: nowrap;">Tanggal Lahir</th>
                                                                <th style="white-space: nowrap;">Alamat</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                                $nomor = $offset + 1; // Mulai nomor urut dari $offset + 1
                                                                while ($row = $result->fetch_assoc()) :
                                                                ?>
                                                            <tr>
                                                                <td><?php echo $nomor++; ?></td>
                                                                <td><?php echo htmlspecialchars($row['id_alumni']); ?>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($row['sekolah']); ?>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($row['id_siswa']); ?>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($row['nis']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['jk']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['agama']); ?></td>
                                                                <td><?php echo htmlspecialchars($row['tempat_lahir']); ?>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($row['tanggal_lahir']); ?>
                                                                </td>
                                                                <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                                            </tr>
                                                            <?php endwhile; ?>
                                                        </tbody>
                                                    </table>
                                                    <?php else: ?>
                                                    <p class="text-center mt-4">Data tidak ditemukan.</p>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>

                            <!-- Pagination Section -->
                            <section class="section">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="card">
                                            <div class="card-body text-center">
                                                <!-- Pagination with icons -->
                                                <nav aria-label="Pagxample" style="margin-top: 2.2rem;">
                                                    <ul class="pagination justify-content-center">
                                                        <li class="page-item <?php if ($page <= 1) {
                                                                                    echo 'disabled';
                                                                                } ?>">
                                                            <a class="page-link" href="<?php if ($page > 1) {
                                                                                            echo "?page=" . ($page - 1) . "&search=" . $search;
                                                                                        } ?>" aria-label="Previous">
                                                                <span aria-hidden="true">&laquo;</span>
                                                            </a>
                                                        </li>
                                                        <?php for ($i = 1; $i <= $total_pages; $i++) { ?>
                                                        <li class="page-item <?php if ($i == $page) {
                                                                                        echo 'active';
                                                                                    } ?>">
                                                            <a class="page-link"
                                                                href="?page=<?php echo $i; ?>&search=<?php echo $search; ?>"><?php echo $i; ?></a>
                                                        </li>
                                                        <?php } ?>
                                                        <li class="page-item <?php if ($page >= $total_pages) {
                                                                                    echo 'disabled';
                                                                                } ?>">
                                                            <a class="page-link" href="<?php if ($page < $total_pages) {
                                                                                            echo "?page=" . ($page + 1) . "&search=" . $search;
                                                                                        } ?>" aria-label="Next">
                                                                <span aria-hidden="true">&raquo;</span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </nav>
                                                <!-- End Pagination with icons -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </section>
                        </div>
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