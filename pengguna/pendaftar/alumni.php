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

                    <div id="load_data">
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <!-- Search Form -->
                                            <form method="GET" action="">
                                                <div class="input-group mt-3">
                                                    <input type="text" class="form-control"
                                                        placeholder="Cari siswa ..." name="search"
                                                        value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                                    <button class="btn btn-outline-secondary"
                                                        type="submit">Cari</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>

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
                                                                <th style="white-space: nowrap;">Aksi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $nomor = $offset + 1; // Mulai nomor urut dari $offset + 1
                                                            while ($row = $result->fetch_assoc()) :
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $nomor++; ?></td>
                                                                    <td><?php echo htmlspecialchars($row['id_alumni']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['sekolah']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['id_siswa']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['nis']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['jk']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['agama']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['tempat_lahir']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['tanggal_lahir']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                                                    <td>
                                                                        <button class="btn btn-warning btn-sm"
                                                                            onclick="openEditModal('<?php echo $row['id_alumni']; ?>', '<?php echo $row['sekolah']; ?>', '<?php echo $row['id_siswa']; ?>')">Edit</button>
                                                                        <button class="btn btn-danger btn-sm"
                                                                            onclick="hapus('<?php echo $row['id_alumni']; ?>')">Hapus</button>
                                                                    </td>
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

            <!-- Modal Tambah Data -->
            <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="tambahForm" method="POST" action="proses/<?= $page_title_proses ?>/tambah.php"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="tambahDataModalLabel">Tambah <?= $page_title ?></h5>
                                <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="sekolah" class="form-label">Sekolah</label>
                                    <input type="text" class="form-control" id="sekolah" name="sekolah" required>
                                </div>
                                <div class="mb-3">
                                    <label for="id_siswa" class="form-label">ID Siswa</label>
                                    <select class="form-select" id="id_siswa" name="id_siswa" required>
                                        <!-- Ambil data siswa dari database untuk pilihan -->
                                        <?php
                                        $query_siswa = "SELECT id_siswa, nama FROM siswa";
                                        $result_siswa = $koneksi->query($query_siswa);
                                        while ($siswa = $result_siswa->fetch_assoc()) {
                                            echo "<option value='" . $siswa['id_siswa'] . "'>" . $siswa['nama'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Modal Edit Data -->
            <div class="modal fade" id="editDataModal" tabindex="-1" aria-labelledby="editDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form id="editForm" method="POST" action="proses/<?= $page_title_proses ?>/edit.php"
                            enctype="multipart/form-data">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editDataModalLabel">Edit <?= $page_title ?></h5>
                                <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="edit_id_alumni" name="id_alumni">
                                <div class="mb-3">
                                    <label for="edit_sekolah" class="form-label">Sekolah</label>
                                    <input type="text" class="form-control" id="edit_sekolah" name="sekolah" required>
                                </div>
                                <div class="mb-3">
                                    <label for="edit_id_siswa" class="form-label">ID Siswa</label>
                                    <select class="form-select" id="edit_id_siswa" name="id_siswa" required>
                                        <!-- Ambil data siswa dari database untuk pilihan -->
                                        <?php
                                        $query_siswa = "SELECT id_siswa, nama FROM siswa";
                                        $result_siswa = $koneksi->query($query_siswa);
                                        while ($siswa = $result_siswa->fetch_assoc()) {
                                            echo "<option value='" . $siswa['id_siswa'] . "'>" . $siswa['nama'] . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <script>
                // Function untuk membuka modal edit dengan data dari tabel
                function openEditModal(id_alumni, sekolah, id_siswa) {
                    document.getElementById('edit_id_alumni').value = id_alumni;
                    document.getElementById('edit_sekolah').value = sekolah;
                    document.getElementById('edit_id_siswa').value = id_siswa;

                    // Tampilkan modal edit
                    var editModal = new bootstrap.Modal(document.getElementById('editDataModal'));
                    editModal.show();
                }
            </script>


            <?php include 'fitur/footer.php'; ?>
        </div>
    </div>
    <?php include 'fitur/js.php'; ?>
</body>

</html>