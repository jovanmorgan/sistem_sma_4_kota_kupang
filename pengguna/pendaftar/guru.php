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
                                                        placeholder="Cari guru ..." name="search"
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
                        // Ambil data guru dari database
                        include '../../keamanan/koneksi.php';

                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;

                        // Query untuk mendapatkan data guru dengan pencarian dan pagination
                        $query = "SELECT * FROM guru WHERE nama LIKE ? OR nama LIKE ? LIMIT ?, ?";
                        $stmt = $koneksi->prepare($query);
                        $search_param = '%' . $search . '%';
                        $stmt->bind_param("ssii", $search_param, $search_param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hitung total halaman
                        $total_query = "SELECT COUNT(*) as total FROM guru WHERE nama LIKE ? OR  nama LIKE ?";
                        $stmt_total = $koneksi->prepare($total_query);
                        $stmt_total->bind_param("ss", $search_param, $search_param);
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result();
                        $total_row = $total_result->fetch_assoc();
                        $total_pages = ceil($total_row['total'] / $limit);
                        ?>

                        <!-- Tabel Data guru -->
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
                                                                <th style="white-space: nowrap;">Nomor</th>
                                                                <th style="white-space: nowrap;">ID guru</th>
                                                                <th style="white-space: nowrap;">NIP</th>
                                                                <th style="white-space: nowrap;">Nama</th>
                                                                <th style="white-space: nowrap;">Jk</th>
                                                                <th style="white-space: nowrap;">Pangkat</th>
                                                                <th style="white-space: nowrap;">Alamat</th>
                                                                <th style="white-space: nowrap;">Tanggal Lahir</th>
                                                                <th style="white-space: nowrap;">Tempat Lahir</th>
                                                                <th style="white-space: nowrap;">Agama</th>
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
                                                                    <!-- Menampilkan nomor urut -->
                                                                    <td><?php echo htmlspecialchars($row['id_guru']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['nip']); ?>
                                                                    <td><?php echo htmlspecialchars($row['nama']); ?>
                                                                    <td><?php echo htmlspecialchars($row['jk']); ?>
                                                                    <td><?php echo htmlspecialchars($row['pangkat']); ?>
                                                                    <td><?php echo htmlspecialchars($row['alamat']); ?>
                                                                    <td><?php echo htmlspecialchars($row['tanggal_lahir']); ?>
                                                                    <td><?php echo htmlspecialchars($row['tempat_lahir']); ?>
                                                                    <td><?php echo htmlspecialchars($row['agama']); ?>
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-warning btn-sm"
                                                                            onclick="openEditModal('<?php echo $row['id_guru']; ?>', '<?php echo $row['nip']; ?>', '<?php echo $row['nama']; ?>', '<?php echo $row['jk']; ?>', '<?php echo $row['pangkat']; ?>', '<?php echo $row['alamat']; ?>', '<?php echo $row['tanggal_lahir']; ?>', '<?php echo $row['tempat_lahir']; ?>', '<?php echo $row['agama']; ?>')">Edit</button>
                                                                        <button class="btn btn-danger btn-sm"
                                                                            onclick="hapus('<?php echo $row['id_guru']; ?>')">Hapus</button>
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

                                <!-- NIP -->
                                <div class="mb-3">
                                    <label for="add_nip" class="form-label">NIP</label>
                                    <input type="text" id="add_nip" name="nip" class="form-control" required>
                                </div>

                                <!-- Nama guru -->
                                <div class="mb-3">
                                    <label for="add_guru" class="form-label">Nama guru</label>
                                    <input type="text" id="add_guru" name="nama" class="form-control" required>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="mb-3">
                                    <label for="add_jk" class="form-label">Jenis Kelamin</label>
                                    <input type="text" id="add_jk" name="jk" class="form-control" required>
                                </div>

                                <!-- Pangkat -->
                                <div class="mb-3">
                                    <label for="add_pangkat" class="form-label">Pangkat</label>
                                    <input type="text" id="add_pangkat" name="pangkat" class="form-control" required>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3">
                                    <label for="add_alamat" class="form-label">Alamat</label>
                                    <input type="text" id="add_alamat" name="alamat" class="form-control" required>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="mb-3">
                                    <label for="add_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" id="add_tanggal_lahir" name="tanggal_lahir" class="form-control"
                                        required>
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="mb-3">
                                    <label for="add_tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" id="add_tempat_lahir" name="tempat_lahir" class="form-control"
                                        required>
                                </div>

                                <!-- Agama -->
                                <div class="mb-3">
                                    <label for="add_agama" class="form-label">Agama</label>
                                    <input type="text" id="add_agama" name="agama" class="form-control" required>
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
                                <input type="hidden" id="edit_id" name="id_guru">

                                <!-- NIP -->
                                <div class="mb-3">
                                    <label for="edit_nip" class="form-label">NIP</label>
                                    <input type="text" id="edit_nip" name="nip" class="form-control" required>
                                </div>

                                <!-- Nama guru -->
                                <div class="mb-3">
                                    <label for="edit_guru" class="form-label">Nama guru</label>
                                    <input type="text" id="edit_guru" name="nama" class="form-control" required>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="mb-3">
                                    <label for="edit_jk" class="form-label">Jenis Kelamin</label>
                                    <input type="text" id="edit_jk" name="jk" class="form-control" required>
                                </div>

                                <!-- Pangkat -->
                                <div class="mb-3">
                                    <label for="edit_pangkat" class="form-label">Pangkat</label>
                                    <input type="text" id="edit_pangkat" name="pangkat" class="form-control" required>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3">
                                    <label for="edit_alamat" class="form-label">Alamat</label>
                                    <input type="text" id="edit_alamat" name="alamat" class="form-control" required>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="mb-3">
                                    <label for="edit_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" class="form-control"
                                        required>
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="mb-3">
                                    <label for="edit_tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" id="edit_tempat_lahir" name="tempat_lahir" class="form-control"
                                        required>
                                </div>

                                <!-- Agama -->
                                <div class="mb-3">
                                    <label for="edit_agama" class="form-label">Agama</label>
                                    <input type="text" id="edit_agama" name="agama" class="form-control" required>
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
        function openEditModal(id_guru, nip, nama, jk, pangkat, alamat, tanggal_lahir, tempat_lahir, agama) {
            // Set nilai ke dalam form modal edit
            document.getElementById('edit_id').value = id_guru;
            document.getElementById('edit_nip').value = nip;
            document.getElementById('edit_guru').value = nama;
            document.getElementById('edit_jk').value = jk;
            document.getElementById('edit_pangkat').value = pangkat;
            document.getElementById('edit_alamat').value = alamat;
            document.getElementById('edit_tanggal_lahir').value = tanggal_lahir;
            document.getElementById('edit_tempat_lahir').value = tempat_lahir;
            document.getElementById('edit_agama').value = agama;

            // Tampilkan modal edit
            var myModal = new bootstrap.Modal(document.getElementById('editModal'));
            myModal.show();
        }
    </script>
    <?php include 'fitur/js.php'; ?>
</body>

</html>