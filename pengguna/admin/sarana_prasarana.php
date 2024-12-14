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
                                                        placeholder="Cari profile_sekolah ..." name="search"
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
                        // Ambil data sarana_prasarana dari database
                        include '../../keamanan/koneksi.php';

                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;

                        // Query untuk mendapatkan data sarana_prasarana dengan pencarian dan pagination
                        $query = "SELECT * FROM sarana_prasarana WHERE id_sarana_prasarana LIKE ? LIMIT ?, ?";
                        $stmt = $koneksi->prepare($query);
                        $search_param = '%' . $search . '%';
                        $stmt->bind_param("sii", $search_param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hitung total halaman
                        $total_query = "SELECT COUNT(*) as total FROM sarana_prasarana WHERE id_sarana_prasarana LIKE ?";
                        $stmt_total = $koneksi->prepare($total_query);
                        $stmt_total->bind_param("s", $search_param);
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result();
                        $total_row = $total_result->fetch_assoc();
                        $total_pages = ceil($total_row['total'] / $limit);
                        ?>

                        <!-- Tabel Data sarana_prasarana -->
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
                                                                <th style="white-space: nowrap;">ID Sarana Prasarana</th>
                                                                <th style="white-space: nowrap;">Jumlah Gudang</th>
                                                                <th style="white-space: nowrap;">Jumlah Ruangan</th>
                                                                <th style="white-space: nowrap;">Jumlah Kelas</th>
                                                                <th style="white-space: nowrap;">Jumlah Laboratorium</th>
                                                                <th style="white-space: nowrap;">Jumlah Lapangan</th>
                                                                <th style="white-space: nowrap;">Jumlah Kamar Mandi</th>
                                                                <th style="white-space: nowrap;">Jumlah Perpustakaan</th>
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
                                                                    <td><?php echo htmlspecialchars($row['id_sarana_prasarana']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['jumlah_gudang']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['jumlah_ruangan']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['jumlah_kelas']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['jumlah_lab']); ?></td>
                                                                    <td><?php echo htmlspecialchars($row['jumlah_lapangan']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['jumlah_kamar_mandi']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['jumlah_perpustakaan']); ?>
                                                                    </td>
                                                                    <td>
                                                                        <button class="btn btn-warning btn-sm"
                                                                            onclick="openEditModal('<?php echo $row['id_sarana_prasarana']; ?>','<?php echo $row['jumlah_gudang']; ?>','<?php echo $row['jumlah_ruangan']; ?>','<?php echo $row['jumlah_kelas']; ?>','<?php echo $row['jumlah_lab']; ?>','<?php echo $row['jumlah_lapangan']; ?>','<?php echo $row['jumlah_kamar_mandi']; ?>','<?php echo $row['jumlah_perpustakaan']; ?>')">Edit</button>
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

            <!-- Modal Edit -->
            <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editDataModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editDataModalLabel">Edit Sarana Prasarana</h5>
                            <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form id="editForm" method="POST" action="proses/sarana_prasarana/edit.php"
                                enctype="multipart/form-data">
                                <input type="hidden" id="edit_id" name="id_sarana_prasarana">

                                <!-- Jumlah Gudang -->
                                <div class="mb-3">
                                    <label for="jumlah_gudang" class="form-label">Jumlah Gudang</label>
                                    <input type="number" id="jumlah_gudang" name="jumlah_gudang" class="form-control"
                                        required>
                                </div>
                                <!-- Jumlah Ruangan -->
                                <div class="mb-3">
                                    <label for="jumlah_ruangan" class="form-label">Jumlah Ruangan</label>
                                    <input type="number" id="jumlah_ruangan" name="jumlah_ruangan" class="form-control"
                                        required>
                                </div>
                                <!-- Jumlah Kelas -->
                                <div class="mb-3">
                                    <label for="jumlah_kelas" class="form-label">Jumlah Kelas</label>
                                    <input type="number" id="jumlah_kelas" name="jumlah_kelas" class="form-control"
                                        required>
                                </div>
                                <!-- Jumlah Laboratorium -->
                                <div class="mb-3">
                                    <label for="jumlah_lab" class="form-label">Jumlah Laboratorium</label>
                                    <input type="number" id="jumlah_lab" name="jumlah_lab" class="form-control"
                                        required>
                                </div>
                                <!-- Jumlah Lapangan -->
                                <div class="mb-3">
                                    <label for="jumlah_lapangan" class="form-label">Jumlah Lapangan</label>
                                    <input type="number" id="jumlah_lapangan" name="jumlah_lapangan"
                                        class="form-control" required>
                                </div>
                                <!-- Jumlah Kamar Mandi -->
                                <div class="mb-3">
                                    <label for="jumlah_kamar_mandi" class="form-label">Jumlah Kamar Mandi</label>
                                    <input type="number" id="jumlah_kamar_mandi" name="jumlah_kamar_mandi"
                                        class="form-control" required>
                                </div>
                                <!-- Jumlah Perpustakaan -->
                                <div class="mb-3">
                                    <label for="jumlah_perpustakaan" class="form-label">Jumlah Perpustakaan</label>
                                    <input type="number" id="jumlah_perpustakaan" name="jumlah_perpustakaan"
                                        class="form-control" required>
                                </div>
                                <div class="text-end">
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                function openEditModal(id, jumlah_gudang, jumlah_ruangan, jumlah_kelas, jumlah_lab, jumlah_lapangan,
                    jumlah_kamar_mandi, jumlah_perpustakaan) {
                    let editModal = new bootstrap.Modal(document.getElementById('editModal'));
                    document.getElementById('edit_id').value = id;
                    document.getElementById('jumlah_gudang').value = jumlah_gudang;
                    document.getElementById('jumlah_ruangan').value = jumlah_ruangan;
                    document.getElementById('jumlah_kelas').value = jumlah_kelas;
                    document.getElementById('jumlah_lab').value = jumlah_lab;
                    document.getElementById('jumlah_lapangan').value = jumlah_lapangan;
                    document.getElementById('jumlah_kamar_mandi').value = jumlah_kamar_mandi;
                    document.getElementById('jumlah_perpustakaan').value = jumlah_perpustakaan;
                    editModal.show();
                }
            </script>


            <?php include 'fitur/footer.php'; ?>
        </div>
    </div>

    <?php include 'fitur/js.php'; ?>
</body>

</html>