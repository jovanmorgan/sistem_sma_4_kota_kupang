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
                                                        placeholder="Cari jurusan ..." name="search"
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
                        // Sertakan koneksi ke database
                        include '../../keamanan/koneksi.php';

                        // Ambil data search dan pagination
                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;

                        // Query untuk mengambil data dari tabel pembagian_kelas, siswa, kelas, dan guru
                        $query = "
    SELECT pk.id_pembagian_kelas, k.nama_kelas, s.nis, s.nama AS nama_siswa, g.id_guru, g.nama AS nama_guru, k.id_kelas
    FROM pembagian_kelas pk
    JOIN kelas k ON pk.id_kelas = k.id_kelas
    JOIN siswa s ON pk.nis_siswa = s.nis
    JOIN guru g ON pk.id_guru = g.id_guru
    WHERE k.nama_kelas LIKE ? OR s.nama LIKE ? OR g.nama LIKE ?
    LIMIT ?, ?";

                        // Siapkan statement
                        $stmt = $koneksi->prepare($query);
                        $search_param = '%' . $search . '%';
                        $stmt->bind_param("ssiii", $search_param, $search_param, $search_param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hitung total halaman
                        $total_query = "
    SELECT COUNT(*) as total
    FROM pembagian_kelas pk
    JOIN kelas k ON pk.id_kelas = k.id_kelas
    JOIN siswa s ON pk.nis_siswa = s.nis
    JOIN guru g ON pk.id_guru = g.id_guru
    WHERE k.nama_kelas LIKE ? OR s.nama LIKE ? OR g.nama LIKE ?";
                        $stmt_total = $koneksi->prepare($total_query);
                        $stmt_total->bind_param("sss", $search_param, $search_param, $search_param);
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result();
                        $total_row = $total_result->fetch_assoc();
                        $total_pages = ceil($total_row['total'] / $limit);
                        ?>
                        <!-- Tabel Data Pembagian Kelas -->
                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body" style="overflow-x: hidden;">
                                            <!-- Overflow-x diatur untuk menyembunyikan scrollbar -->
                                            <div style="overflow-x: auto;">
                                                <?php if ($result->num_rows > 0): ?>
                                                    <table class="table table-hover text-center mt-3"
                                                        style="border-collapse: separate; border-spacing: 0;">
                                                        <!-- Atur lebar minimum tabel -->
                                                        <thead>
                                                            <tr>
                                                                <th>Nomor</th>
                                                                <th>ID Pembagian Kelas</th>
                                                                <th>Kelas</th>
                                                                <th>NIS Siswa</th>
                                                                <th>Nama Siswa</th>
                                                                <th>ID Guru</th>
                                                                <th>Nama Guru</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $nomor = $offset + 1; // Mulai nomor urut dari $offset + 1
                                                            while ($row = $result->fetch_assoc()) :
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $nomor++; ?></td>
                                                                    <td><?php echo htmlspecialchars($row['id_pembagian_kelas']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['nis']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['nama_siswa']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['id_guru']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['nama_guru']); ?></td>
                                                                    <td>
                                                                        <button class="btn btn-warning btn-sm"
                                                                            onclick="openEditModal('<?php echo $row['id_pembagian_kelas']; ?>','<?php echo $row['id_kelas']; ?>','<?php echo $row['nis']; ?>','<?php echo $row['id_guru']; ?>')">Edit</button>
                                                                        <button class="btn btn-danger btn-sm"
                                                                            onclick="hapus('<?php echo $row['id_pembagian_kelas']; ?>')">Hapus</button>
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

            <!-- bagian pop up edit dan tambah -->

            <!-- Modal -->
            <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="tambahDataModalLabel">Tambah <?= $page_title ?></h5>
                            <button type="button" class="btn-close" id="closeTambahModal" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="tambahForm" method="POST" action="proses/<?= $page_title_proses ?>/tambah.php"
                                enctype="multipart/form-data">

                                <div class="mb-3">
                                    <label for="nis" class="form-label">Siswa</label>
                                    <select id="nis" name="nis" class="form-select" required>
                                        <!-- Populate options from the database -->
                                        <?php
                                        // Fetch siswa for the dropdown
                                        $siswa_query = "SELECT * FROM siswa";
                                        $siswa_result = $koneksi->query($siswa_query);
                                        while ($siswa = $siswa_result->fetch_assoc()) {
                                            echo '<option value="' . $siswa['nis'] . '">' . htmlspecialchars($siswa['nama']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="id_kelas" class="form-label">Kelas</label>
                                    <select id="id_kelas" name="id_kelas" class="form-select" required>
                                        <!-- Populate options from the database -->
                                        <?php
                                        // Fetch kelas for the dropdown
                                        $kelas_query = "SELECT * FROM kelas";
                                        $kelas_result = $koneksi->query($kelas_query);
                                        while ($kelas = $kelas_result->fetch_assoc()) {
                                            echo '<option value="' . $kelas['id_kelas'] . '">' . htmlspecialchars($kelas['nama_kelas']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="id_guru" class="form-label">Guru</label>
                                    <select id="id_guru" name="id_guru" class="form-select" required>
                                        <!-- Populate options from the database -->
                                        <?php
                                        // Fetch guru for the dropdown
                                        $guru_query = "SELECT * FROM guru";
                                        $guru_result = $koneksi->query($guru_query);
                                        while ($guru = $guru_result->fetch_assoc()) {
                                            echo '<option value="' . $guru['id_guru'] . '">' . htmlspecialchars($guru['nama']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Wrapper for the submit button to align it to the right -->
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDataModalLabel">Edit <?= $page_title ?></h5>
                            <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST" action="proses/<?= $page_title_proses ?>/edit.php"
                                enctype="multipart/form-data">
                                <input type="hidden" id="edit_id" name="id_pembagian_kelas">

                                <div class="mb-3">
                                    <label for="edit_nis_siswa" class="form-label">Siswa</label>
                                    <select id="edit_nis_siswa" name="nis_siswa" class="form-select" required>
                                        <!-- Populate options from the database -->
                                        <?php
                                        // Fetch siswa for the dropdown
                                        $siswa_query = "SELECT * FROM siswa";
                                        $siswa_result = $koneksi->query($siswa_query);
                                        while ($siswa = $siswa_result->fetch_assoc()) {
                                            echo '<option value="' . $siswa['nis'] . '">' . htmlspecialchars($siswa['nama']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_id_kelas" class="form-label">Kelas</label>
                                    <select id="edit_id_kelas" name="id_kelas" class="form-select" required>
                                        <!-- Populate options from the database -->
                                        <?php
                                        // Fetch kelas for the dropdown
                                        $kelas_query = "SELECT * FROM kelas";
                                        $kelas_result = $koneksi->query($kelas_query);
                                        while ($kelas = $kelas_result->fetch_assoc()) {
                                            echo '<option value="' . $kelas['id_kelas'] . '">' . htmlspecialchars($kelas['nama_kelas']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_id_guru" class="form-label">Guru</label>
                                    <select id="edit_id_guru" name="id_guru" class="form-select" required>
                                        <!-- Populate options from the database -->
                                        <?php
                                        // Fetch guru for the dropdown
                                        $guru_query = "SELECT * FROM guru";
                                        $guru_result = $koneksi->query($guru_query);
                                        while ($guru = $guru_result->fetch_assoc()) {
                                            echo '<option value="' . $guru['id_guru'] . '">' . htmlspecialchars($guru['nama']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <?php include 'fitur/footer.php'; ?>
        </div>
    </div>
    <script>
        function openEditModal(id, id_kelas, nis_siswa, id_guru) {
            let editModal = new bootstrap.Modal(document.getElementById('editModal'));
            document.getElementById('edit_id').value = id;
            document.getElementById('edit_id_kelas').value = id_kelas;
            document.getElementById('edit_nis_siswa').value = nis_siswa;
            document.getElementById('edit_id_guru').value = id_guru;
            editModal.show();
        }
    </script>
    <?php include 'fitur/js.php'; ?>
</body>

</html>