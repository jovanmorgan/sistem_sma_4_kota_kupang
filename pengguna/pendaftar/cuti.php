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
                                                        placeholder="Cari jabatan ..." name="search"
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
                        include '../../keamanan/koneksi.php';

                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;

                        // Query untuk mendapatkan data cuti dan pegawai dengan pencarian dan pagination
                        $query = "
                                SELECT cuti.*, pegawai.nama_pegawai 
                                FROM cuti 
                                LEFT JOIN pegawai ON cuti.id_pegawai = pegawai.id_pegawai 
                                WHERE cuti.tanggal_cuti LIKE ? 
                                OR pegawai.nama_pegawai LIKE ? 
                                OR cuti.jenis_cuti LIKE ? 
                                OR cuti.lama_cuti LIKE ? 
                                LIMIT ?, ?";

                        $stmt = $koneksi->prepare($query);
                        $search_param = '%' . $search . '%';
                        $stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hitung total halaman
                        $total_query = "
                                SELECT COUNT(*) as total 
                                FROM cuti 
                                LEFT JOIN pegawai ON cuti.id_pegawai = pegawai.id_pegawai 
                                WHERE pegawai.nama_pegawai LIKE ? 
                                OR cuti.tanggal_cuti LIKE ? 
                                OR cuti.jenis_cuti LIKE ? 
                                OR cuti.lama_cuti LIKE ?";

                        $stmt_total = $koneksi->prepare($total_query);
                        $stmt_total->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result();
                        $total_row = $total_result->fetch_assoc();
                        $total_pages = ceil($total_row['total'] / $limit);
                        ?>

                        <!-- Tabel Data cuti -->
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
                                                                <th>Nomor</th>
                                                                <th>Nama Pegawai</th>
                                                                <th>Tanggal</th>
                                                                <th>Tempat</th>
                                                                <th>Lama Cuti</th>
                                                                <th>Aksi</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php
                                                            $nomor = $offset + 1;
                                                            while ($row = $result->fetch_assoc()) :
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $nomor++; ?></td>
                                                                    <td><?php echo htmlspecialchars($row['nama_pegawai']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['tanggal_cuti']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['jenis_cuti']); ?>
                                                                    </td>
                                                                    <td><?php echo htmlspecialchars($row['lama_cuti']); ?></td>
                                                                    <td>
                                                                        <button class="btn btn-warning btn-sm"
                                                                            onclick="openEditModal('<?php echo $row['id_cuti']; ?>', '<?php echo $row['tanggal_cuti']; ?>', '<?php echo $row['jenis_cuti']; ?>', '<?php echo $row['lama_cuti']; ?>', '<?php echo $row['id_pegawai']; ?>')">Edit</button>
                                                                        <button class="btn btn-danger btn-sm"
                                                                            onclick="hapus('<?php echo $row['id_cuti']; ?>')">Hapus</button>
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
                                <!-- Pegawai (Select Option) -->
                                <div class="mb-3">
                                    <label for="id_pegawai" class="form-label">Nama Pegawai</label>
                                    <select id="id_pegawai" name="id_pegawai" class="form-control" required>
                                        <option value="" selected>Silakan pilih pegawai</option>
                                        <?php
                                        $pegawai_query = "SELECT id_pegawai, nama_pegawai FROM pegawai";
                                        $pegawai_result = mysqli_query($koneksi, $pegawai_query);
                                        while ($pegawai = mysqli_fetch_assoc($pegawai_result)) {
                                            echo "<option value='{$pegawai['id_pegawai']}'>{$pegawai['nama_pegawai']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="tanggal_cuti" class="form-label">Tanggal cuti</label>
                                    <input type="date" id="tanggal_cuti" name="tanggal_cuti" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="jenis_cuti" class="form-label">Jenis Cuti</label>
                                    <select id="jenis_cuti" name="jenis_cuti" class="form-control" required>
                                        <option value="" selected>Pilih jenis cuti</option>
                                        <option value="Cuti Tahunan">Cuti Tahunan</option>
                                        <option value="Cuti Sakit">Cuti Sakit</option>
                                        <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                                        <option value="Cuti Besar">Cuti Besar</option>
                                        <option value="Cuti Alasan Penting">Cuti Alasan Penting</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="lama_cuti" class="form-label">Lama cuti</label>
                                    <input type="text" id="lama_cuti" name="lama_cuti" class="form-control" required>
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
                                <input type="hidden" id="id_cuti" name="id_cuti">

                                <!-- cuti Pokok -->
                                <div class="mb-3">
                                    <label for="edit_tanggal_cuti" class="form-label">Tanggal cuti</label>
                                    <input type="date" id="edit_tanggal_cuti" name="tanggal_cuti" class="form-control"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="edit_jenis_cuti" class="form-label">Jenis Cuti</label>
                                    <select id="edit_jenis_cuti" name="jenis_cuti" class="form-control" required>
                                        <option value="" selected>Pilih jenis cuti</option>
                                        <option value="Cuti Tahunan">Cuti Tahunan</option>
                                        <option value="Cuti Sakit">Cuti Sakit</option>
                                        <option value="Cuti Melahirkan">Cuti Melahirkan</option>
                                        <option value="Cuti Besar">Cuti Besar</option>
                                        <option value="Cuti Alasan Penting">Cuti Alasan Penting</option>
                                    </select>
                                </div>


                                <!-- Potongan -->
                                <div class="mb-3">
                                    <label for="edit_lama_cuti" class="form-label">SK cuti</label>
                                    <input type="number" id="edit_lama_cuti" name="lama_cuti" class="form-control"
                                        required>
                                </div>

                                <!-- Pegawai (Select Option) -->
                                <div class="mb-3">
                                    <label for="edit_id_pegawai" class="form-label">Nama Pegawai</label>
                                    <select id="edit_id_pegawai" name="id_pegawai" class="form-control" required>
                                        <!-- PHP untuk menampilkan pilihan pegawai -->
                                        <option value="" selected>Silakan pilih pegawai</option>
                                        <?php
                                        $pegawai_result = mysqli_query($koneksi, "SELECT id_pegawai, nama_pegawai FROM pegawai");
                                        while ($pegawai = mysqli_fetch_assoc($pegawai_result)) {
                                            echo "<option value='{$pegawai['id_pegawai']}'>{$pegawai['nama_pegawai']}</option>";
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('tambahForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Menghentikan aksi default form submit

                var form = this;
                var formData = new FormData(form);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'proses/<?= $page_title_proses ?>/tambah.php', true);
                xhr.onload = function() {
                    if (xhr.status === 200) {
                        var response = xhr.responseText.trim();
                        console.log(response); // Debugging

                        if (response === 'success') {
                            form.reset();
                            document.getElementById('closeTambahModal').click();
                            loadTable(); // reload table data

                            Swal.fire({
                                title: "Berhasil!",
                                text: "Data berhasil ditambahkan",
                                icon: "success",
                                timer: 1200, // 1,2 detik
                                showConfirmButton: false, // Tidak menampilkan tombol OK
                            });
                        } else if (response === 'data_sudah_ada') {
                            Swal.fire({
                                title: "Error",
                                text: "Data data sudah dipromosikan, silakan pilih data roti lainnya",
                                icon: "info",
                                timer: 2000, // 2 detik
                                showConfirmButton: false,
                            });
                        } else if (response === 'data_tidak_lengkap') {
                            Swal.fire({
                                title: "Error",
                                text: "Data yang anda masukan belum lengkap",
                                icon: "info",
                                timer: 2000, // 2 detik
                                showConfirmButton: false,
                            });
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: "Gagal menambahkan data",
                                icon: "error",
                                timer: 2000, // 2 detik
                                showConfirmButton: false,
                            });
                        }
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan saat mengirim data",
                            icon: "error",
                            timer: 2000, // 2 detik
                            showConfirmButton: false,
                        });
                    }
                };
                xhr.send(formData);
            });
        });

        function openEditModal(id_cuti, tanggal_cuti, jenis_cuti, lama_cuti, id_pegawai) {
            // Mengisi nilai input di modal edit
            document.getElementById('id_cuti').value = id_cuti;
            document.getElementById('edit_tanggal_cuti').value = tanggal_cuti;
            document.getElementById('edit_jenis_cuti').value = jenis_cuti;
            document.getElementById('edit_lama_cuti').value = lama_cuti;
            document.getElementById('edit_id_pegawai').value = id_pegawai;

            // Pilihan pegawai pada select option
            let selectPegawai = document.getElementById('edit_id_pegawai');
            for (let i = 0; i < selectPegawai.options.length; i++) {
                if (selectPegawai.options[i].value == id_pegawai) {
                    selectPegawai.selectedIndex = i;
                    break;
                }
            }

            // Menampilkan modal edit
            var editModal = new bootstrap.Modal(document.getElementById('editModal'), {
                keyboard: false
            });
            editModal.show();
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('editForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Menghentikan aksi default form submit

                var form = this;
                var formData = new FormData(form);

                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'proses/<?= $page_title_proses ?>/edit.php', true);
                xhr.onload = function() {

                    if (xhr.status === 200) {
                        var response = xhr.responseText.trim();
                        console.log(response); // Debugging

                        if (response === 'success') {
                            form.reset();
                            document.getElementById('closeEditModal').click();
                            loadTable(); // reload table data

                            Swal.fire({
                                title: "Berhasil!",
                                text: "Data berhasil diperbarui",
                                icon: "success",
                                timer: 1200, // 1,2 detik
                                showConfirmButton: false, // Tidak menampilkan tombol OK
                            });
                        } else if (response === 'data_sudah_ada') {
                            Swal.fire({
                                title: "Error",
                                text: "Data data sudah dipromosikan, silakan pilih data data lainnya",
                                icon: "info",
                                timer: 2000, // 2 detik
                                showConfirmButton: false,
                            });
                        } else if (response === 'data_tidak_lengkap') {
                            Swal.fire({
                                title: "Error",
                                text: "Data yang anda masukan belum lengkap",
                                icon: "info",
                                timer: 2000, // 2 detik
                                showConfirmButton: false,
                            });
                        } else {
                            Swal.fire({
                                title: "Error",
                                text: "Gagal memperbarui data",
                                icon: "error",
                                timer: 2000, // 2 detik
                                showConfirmButton: false,
                            });
                        }
                    } else {
                        Swal.fire({
                            title: "Error",
                            text: "Terjadi kesalahan saat mengirim data",
                            icon: "error",
                            timer: 2000, // 2 detik
                            showConfirmButton: false,
                        });
                    }
                };
                xhr.send(formData);
            });
        });

        function hapus(id) {
            Swal.fire({
                title: "Apakah Anda yakin?",
                text: "Setelah dihapus, Anda tidak akan dapat memulihkan data ini!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonText: "Ya, hapus!",
                cancelButtonText: "Batal",
                dangerMode: true,
            }).then((result) => {
                if (result.isConfirmed) {
                    // Jika pengguna mengonfirmasi untuk menghapus
                    var xhr = new XMLHttpRequest();

                    xhr.open('POST', 'proses/<?= $page_title_proses ?>/hapus.php', true);
                    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                    xhr.onload = function() {

                        if (xhr.status === 200) {
                            var response = xhr.responseText.trim();
                            if (response === 'success') {
                                loadTable();
                                Swal.fire({
                                    title: 'Sukses!',
                                    text: 'Data berhasil dihapus.',
                                    icon: 'success',
                                    timer: 1200, // 1,2 detik
                                    showConfirmButton: false // Menghilangkan tombol OK
                                }).then(() => {
                                    location.reload()
                                })
                            } else if (response === 'error') {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Gagal menghapus Data.',
                                    icon: 'error',
                                    timer: 2000, // 2 detik
                                    showConfirmButton: false // Menghilangkan tombol OK
                                });
                            } else {
                                Swal.fire({
                                    title: 'Error',
                                    text: 'Terjadi kesalahan saat mengirim data.',
                                    icon: 'error',
                                    timer: 2000, // 2 detik
                                    showConfirmButton: false // Menghilangkan tombol OK
                                });
                            }
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: 'Terjadi kesalahan saat mengirim data.',
                                icon: 'error',
                                timer: 2000, // 2 detik
                                showConfirmButton: false // Menghilangkan tombol OK
                            });
                        }
                    };
                    xhr.send("id=" + id);
                } else {
                    // Jika pengguna membatalkan penghapusan
                    Swal.fire({
                        title: 'Penghapusan dibatalkan',
                        icon: 'info',
                        timer: 1500, // 1,5 detik
                        showConfirmButton: false // Menghilangkan tombol OK
                    });
                }
            });
        }

        function loadTable() {
            // Get current page and search query from URL
            var currentPage = new URLSearchParams(window.location.search).get('page') || 1;
            var searchQuery = new URLSearchParams(window.location.search).get('search') || '';

            var xhrTable = new XMLHttpRequest();
            xhrTable.onreadystatechange = function() {
                if (xhrTable.readyState == 4 && xhrTable.status == 200) {
                    document.getElementById('load_data').innerHTML = xhrTable.responseText;
                }
            };

            // Send request with current page and search query
            xhrTable.open('GET', 'proses/<?= $page_title_proses ?>/load_data.php?page=' + currentPage + '&search=' +
                encodeURIComponent(
                    searchQuery), true);
            xhrTable.send();
        }
    </script>
    <?php include 'fitur/js.php'; ?>
</body>

</html>