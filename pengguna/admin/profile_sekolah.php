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
                        // Ambil data profile_sekolah dari database
                        include '../../keamanan/koneksi.php';

                        $search = isset($_GET['search']) ? $_GET['search'] : '';
                        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                        $limit = 10;
                        $offset = ($page - 1) * $limit;

                        // Query untuk mendapatkan data profile_sekolah dengan pencarian dan pagination
                        $query = "SELECT * FROM profile_sekolah WHERE visi LIKE ? LIMIT ?, ?";
                        $stmt = $koneksi->prepare($query);
                        $search_param = '%' . $search . '%';
                        $stmt->bind_param("sii", $search_param, $offset, $limit);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        // Hitung total halaman
                        $total_query = "SELECT COUNT(*) as total FROM profile_sekolah WHERE visi LIKE ?";
                        $stmt_total = $koneksi->prepare($total_query);
                        $stmt_total->bind_param("s", $search_param);
                        $stmt_total->execute();
                        $total_result = $stmt_total->get_result();
                        $total_row = $total_result->fetch_assoc();
                        $total_pages = ceil($total_row['total'] / $limit);
                        ?>

                        <!-- Tabel Data profile_sekolah -->
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
                                                                <th style="white-space: nowrap;">ID profile_sekolah</th>
                                                                <th style="white-space: nowrap;">Visi</th>
                                                                <th style="white-space: nowrap;">Misi</th>
                                                                <th style="white-space: nowrap;">Alamat Sekolah</th>
                                                                <th style="white-space: nowrap;">Aksi</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <?php
                                                            $nomor = $offset + 1; // Mulai nomor urut dari $offset + 1
                                                            while ($row = $result->fetch_assoc()) :
                                                                $id_profile_sekolah = htmlspecialchars($row['id_profile_sekolah']);
                                                                $visi = htmlspecialchars($row['visi']);
                                                                $misi = htmlspecialchars($row['misi']);
                                                                $alamat_sekolah = htmlspecialchars($row['alamat_sekolah']);
                                                            ?>
                                                                <tr>
                                                                    <td><?php echo $nomor++; ?></td>
                                                                    <td><?php echo $id_profile_sekolah; ?></td>
                                                                    <td><?php echo $visi; ?></td>
                                                                    <td><?php echo $misi; ?></td>
                                                                    <td><?php echo $alamat_sekolah; ?></td>
                                                                    <td>
                                                                        <!-- Tombol untuk memunculkan modal -->
                                                                        <button class="btn btn-warning btn-sm"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#editModal-<?php echo $id_profile_sekolah; ?>">Edit</button>
                                                                    </td>
                                                                </tr>

                                                                <!-- Modal Edit Dinamis -->
                                                                <div class="modal fade"
                                                                    id="editModal-<?php echo $id_profile_sekolah; ?>"
                                                                    tabindex="-1"
                                                                    aria-labelledby="editModalLabel-<?php echo $id_profile_sekolah; ?>"
                                                                    aria-hidden="true">
                                                                    <div class="modal-dialog">
                                                                        <div class="modal-content">
                                                                            <div class="modal-header">
                                                                                <h5 class="modal-title"
                                                                                    id="editModalLabel-<?php echo $id_profile_sekolah; ?>">
                                                                                    Edit Data Sekolah</h5>
                                                                                <button id="closeEditModal" type="button"
                                                                                    class="btn-close" data-bs-dismiss="modal"
                                                                                    aria-label="Close"></button>
                                                                            </div>
                                                                            <div class="modal-body">
                                                                                <form
                                                                                    id="editForm-<?php echo $id_profile_sekolah; ?>"
                                                                                    method="POST"
                                                                                    action="proses/<?= $page_title_proses ?>/edit.php"
                                                                                    enctype="multipart/form-data">
                                                                                    <input type="hidden"
                                                                                        name="id_profile_sekolah"
                                                                                        value="<?php echo $id_profile_sekolah; ?>">
                                                                                    <input type="hidden"
                                                                                        name="id_profile_sekolah"
                                                                                        value="<?php echo $id_profile_sekolah; ?>">

                                                                                    <!-- Textarea VISI -->
                                                                                    <div class="mb-3">
                                                                                        <label
                                                                                            for="visi-<?php echo $id_profile_sekolah; ?>"
                                                                                            class="form-label">VISI</label>
                                                                                        <textarea
                                                                                            id="visi-<?php echo $id_profile_sekolah; ?>"
                                                                                            name="visi" class="form-control"
                                                                                            rows="3"
                                                                                            required><?php echo $visi; ?></textarea>
                                                                                    </div>

                                                                                    <!-- Textarea MISI -->
                                                                                    <div class="mb-3">
                                                                                        <label
                                                                                            for="misi-<?php echo $id_profile_sekolah; ?>"
                                                                                            class="form-label">MISI</label>
                                                                                        <textarea
                                                                                            id="misi-<?php echo $id_profile_sekolah; ?>"
                                                                                            name="misi" class="form-control"
                                                                                            rows="3"
                                                                                            required><?php echo $misi; ?></textarea>
                                                                                    </div>

                                                                                    <!-- Textarea ALAMAT SEKOLAH -->
                                                                                    <div class="mb-3">
                                                                                        <label
                                                                                            for="alamat-<?php echo $id_profile_sekolah; ?>"
                                                                                            class="form-label">Alamat
                                                                                            Sekolah</label>
                                                                                        <textarea
                                                                                            id="alamat-<?php echo $id_profile_sekolah; ?>"
                                                                                            name="alamat_sekolah"
                                                                                            class="form-control" rows="3"
                                                                                            required><?php echo $alamat_sekolah; ?></textarea>
                                                                                    </div>

                                                                                    <div class="text-end">
                                                                                        <button type="submit"
                                                                                            class="btn btn-primary">Simpan</button>
                                                                                    </div>
                                                                                </form>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>

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

            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    // Dapatkan semua form edit yang ada
                    var editForms = document.querySelectorAll('form[id^="editForm-"]');

                    editForms.forEach(function(form) {
                        form.addEventListener('submit', function(event) {
                            event.preventDefault(); // Mencegah form submit default

                            var formData = new FormData(form); // Ambil data dari form saat ini
                            var xhr = new XMLHttpRequest();

                            xhr.open('POST', form.action, true);
                            xhr.onload = function() {
                                if (xhr.status === 200) {
                                    var response = xhr.responseText.trim();
                                    console.log(response); // Debugging

                                    if (response === 'success') {
                                        Swal.fire({
                                            title: "Berhasil!",
                                            text: "Data berhasil diperbarui",
                                            icon: "success",
                                            timer: 1200,
                                            showConfirmButton: false,
                                        });
                                        form.reset(); // Reset form setelah sukses
                                        loadTable()

                                        document.getElementById('closeEditModal').click();
                                        location.reload();
                                    } else if (response === 'data_sudah_ada') {
                                        Swal.fire({
                                            title: "Error",
                                            text: "Data sudah ada, silakan pilih data lain",
                                            icon: "info",
                                            timer: 2000,
                                            showConfirmButton: false,
                                        });
                                    } else if (response === 'data_tidak_lengkap') {
                                        Swal.fire({
                                            title: "Error",
                                            text: "Data yang anda masukan belum lengkap",
                                            icon: "info",
                                            timer: 2000,
                                            showConfirmButton: false,
                                        });
                                    } else {
                                        Swal.fire({
                                            title: "Error",
                                            text: "Gagal memperbarui data",
                                            icon: "error",
                                            timer: 2000,
                                            showConfirmButton: false,
                                        });
                                    }
                                } else {
                                    Swal.fire({
                                        title: "Error",
                                        text: "Terjadi kesalahan saat mengirim data",
                                        icon: "error",
                                        timer: 2000,
                                        showConfirmButton: false,
                                    });
                                }
                            };

                            xhr.send(formData); // Kirim form data melalui AJAX
                        });
                    });
                });
            </script>

            <?php include 'fitur/footer.php'; ?>
        </div>
    </div>

    <?php include 'fitur/js.php'; ?>
</body>

</html>