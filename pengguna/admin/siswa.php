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
                                                    <input type="text" class="form-control" placeholder="Cari siswa ..."
                                                        name="search"
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
                        // Ambil data siswa dari database
                        include '../../keamanan/koneksi.php';

                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;

                        // Query untuk mendapatkan data siswa dengan pencarian dan pagination
                        $query = "SELECT s.id_siswa, s.nis, s.nama, s.jk, s.agama, s.tempat_lahir, s.tanggal_lahir, s.alamat, j.nama_jurusan, k.id_jurusan, k.nama_kelas, s.id_kelas
                                                FROM siswa s 
                                                JOIN kelas k ON s.id_kelas = k.id_kelas 
                                                JOIN jurusan j ON k.id_jurusan = j.id_jurusan 
                                                WHERE s.nama LIKE ? LIMIT ?, ?";
                        $stmt = $koneksi->prepare($query);
                        $search_param = '%' . $search . '%';
                        $stmt->bind_param("sii", $search_param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hitung total halaman
                        $total_query = "SELECT COUNT(*) as total FROM siswa WHERE nama LIKE ? OR nis LIKE ? OR jk LIKE ? OR agama LIKE ?";
                        $stmt_total = $koneksi->prepare($total_query);
                        $stmt_total->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result();
                        $total_row = $total_result->fetch_assoc();
                        $total_pages = ceil($total_row['total'] / $limit);
                        ?>

                        <!-- Tabel Data siswa -->
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
                                                            <th style="white-space: nowrap;">ID Siswa</th>
                                                            <th style="white-space: nowrap;">NIS</th>
                                                            <th style="white-space: nowrap;">Nama Kelas</th>
                                                            <th style="white-space: nowrap;">Nama Jurusan</th>
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
                                                            <td><?php echo htmlspecialchars($row['id_siswa']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['nis']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                                                            <td><?php echo htmlspecialchars($row['nama_jurusan']); ?>
                                                            </td>
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
                                                                    onclick="openEditModal('<?php echo $row['id_siswa']; ?>', '<?php echo $row['nama']; ?>', '<?php echo $row['jk']; ?>', '<?php echo $row['agama']; ?>', '<?php echo $row['tempat_lahir']; ?>', '<?php echo $row['tanggal_lahir']; ?>', '<?php echo $row['alamat']; ?>', '<?php echo $row['id_jurusan']; ?>')">Edit</button>
                                                                <button class="btn btn-danger btn-sm"
                                                                    onclick="hapus('<?php echo $row['id_siswa']; ?>')">Hapus</button>
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

            <!-- Modal Tambah Data -->
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

                                <!-- ID jurusan -->
                                <div class="mb-3">
                                    <label for="id_jurusan" class="form-label">Jurusan</label>
                                    <select id="id_jurusan" name="id_jurusan" class="form-select" required>
                                        <option value="">Pilih Jurusan</option>
                                        <!-- Ambil data jurusan dari database -->
                                        <?php
                                        // Ambil data jurusan dari database
                                        $query_jurusan = "SELECT * FROM jurusan";
                                        $result_jurusan = $koneksi->query($query_jurusan);
                                        while ($jurusan = $result_jurusan->fetch_assoc()) {
                                            echo '<option value="' . htmlspecialchars($jurusan['id_jurusan']) . '">' . htmlspecialchars($jurusan['nama_jurusan']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Nama siswa -->
                                <div class="mb-3">
                                    <label for="siswa" class="form-label">Nama siswa</label>
                                    <input type="text" id="siswa" name="siswa" class="form-control" required>
                                </div>

                                <!-- JK -->
                                <div class="mb-3">
                                    <label for="jk" class="form-label">Jenis Kelamin</label>
                                    <select id="jk" name="jk" class="form-select" required>
                                        <option value="">Pilih Jenis Kelamin</option>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>

                                <!-- Agama -->
                                <div class="mb-3">
                                    <label for="agama" class="form-label">Agama</label>
                                    <input type="text" id="agama" name="agama" class="form-control" required>
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="mb-3">
                                    <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" id="tempat_lahir" name="tempat_lahir" class="form-control"
                                        required>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="mb-3">
                                    <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" id="tanggal_lahir" name="tanggal_lahir" class="form-control"
                                        required>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control" required></textarea>
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


            <!-- Modal Edit Data -->
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
                                <input type="hidden" id="edit_id" name="id_siswa">

                                <!-- ID jurusan -->
                                <div class="mb-3">
                                    <label for="edit_id_jurusan" class="form-label">Jurusan</label>
                                    <select id="edit_id_jurusan" name="id_jurusan" class="form-select" required>
                                        <option value="">Pilih Jurusan</option>
                                        <?php
                                        // Ambil data jurusan dari database
                                        $query_jurusan = "SELECT * FROM jurusan";
                                        $result_jurusan = $koneksi->query($query_jurusan);
                                        while ($jurusan = $result_jurusan->fetch_assoc()) {
                                            echo '<option value="' . htmlspecialchars($jurusan['id_jurusan']) . '">' . htmlspecialchars($jurusan['nama_jurusan']) . '</option>';
                                        }
                                        ?>
                                    </select>
                                </div>

                                <!-- Nama siswa -->
                                <div class="mb-3">
                                    <label for="edit_siswa" class="form-label">Nama siswa</label>
                                    <input type="text" id="edit_siswa" name="siswa" class="form-control" required>
                                </div>

                                <!-- JK -->
                                <div class="mb-3">
                                    <label for="edit_jk" class="form-label">Jenis Kelamin</label>
                                    <select id="edit_jk" name="jk" class="form-select" required>
                                        <option value="L">Laki-laki</option>
                                        <option value="P">Perempuan</option>
                                    </select>
                                </div>

                                <!-- Agama -->
                                <div class="mb-3">
                                    <label for="edit_agama" class="form-label">Agama</label>
                                    <input type="text" id="edit_agama" name="agama" class="form-control" required>
                                </div>

                                <!-- Tempat Lahir -->
                                <div class="mb-3">
                                    <label for="edit_tempat_lahir" class="form-label">Tempat Lahir</label>
                                    <input type="text" id="edit_tempat_lahir" name="tempat_lahir" class="form-control"
                                        required>
                                </div>

                                <!-- Tanggal Lahir -->
                                <div class="mb-3">
                                    <label for="edit_tanggal_lahir" class="form-label">Tanggal Lahir</label>
                                    <input type="date" id="edit_tanggal_lahir" name="tanggal_lahir" class="form-control"
                                        required>
                                </div>

                                <!-- Alamat -->
                                <div class="mb-3">
                                    <label for="edit_alamat" class="form-label">Alamat</label>
                                    <textarea id="edit_alamat" name="alamat" class="form-control" required></textarea>
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
    function openEditModal(id, siswa, jk, agama, tempatLahir, tanggalLahir, alamat, id_jurusan) {
        let editModal = new bootstrap.Modal(document.getElementById('editModal'));

        document.getElementById('edit_id').value = id;
        document.getElementById('edit_id_jurusan').value = id_jurusan;
        document.getElementById('edit_siswa').value = siswa; // Set value for jenis kelamin
        document.getElementById('edit_jk').value = jk;
        document.getElementById('edit_agama').value = agama;
        document.getElementById('edit_tempat_lahir').value = tempatLahir;
        document.getElementById('edit_tanggal_lahir').value = tanggalLahir;
        document.getElementById('edit_alamat').value = alamat; // Set value for id_kelas

        editModal.show();
    }
    </script>
    <?php include 'fitur/js.php'; ?>
</body>

</html>