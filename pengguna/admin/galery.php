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
                                                    <input type="text" class="form-control" placeholder="Cari galery..."
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

                        <section class="section">
                            <div class="row align-items-start">
                                <?php
                                include '../../keamanan/koneksi.php';

                                // Pagination variables
                                $limit = 6; // Jumlah item per halaman
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                $offset = ($page - 1) * $limit;

                                // Searching
                                $search = isset($_GET['search']) ? mysqli_real_escape_string($koneksi, $_GET['search']) : '';

                                // Query to count total records
                                $total_result = mysqli_query($koneksi, "SELECT COUNT(*) AS total FROM galery WHERE nama LIKE '%$search%'");
                                $total_row = mysqli_fetch_assoc($total_result);
                                $total_items = $total_row['total'];
                                $total_pages = ceil($total_items / $limit);

                                // Query to fetch limited records with search
                                $result = mysqli_query($koneksi, "SELECT * FROM galery WHERE nama LIKE '%$search%' LIMIT $limit OFFSET $offset");

                                if (mysqli_num_rows($result) > 0) {
                                    // Looping data galery
                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $id_galery = $row['id_galery'];
                                        $nama = $row['nama'];
                                        $waktu = $row['waktu'];
                                        $deskripsi = $row['deskripsi'];
                                        $gambar = $row['gambar'];
                                ?>
                                        <div class="col-lg-4">
                                            <div class="card">
                                                <div class="card-body">
                                                    <!-- Title -->
                                                    <h5 class="card-title text-center" style="font-size: 1.7rem;">
                                                        <?php echo $nama; ?></h5>

                                                    <!-- Carousel -->
                                                    <div id="carouselExampleSlidesOnly" class="carousel slide"
                                                        data-bs-ride="carousel">
                                                        <div class="carousel-inner">
                                                            <div class="carousel-item active">
                                                                <img src="../../assets/img/galery/<?php echo $gambar; ?>"
                                                                    class="d-block w-100" alt="<?php echo $nama; ?>" />
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Description -->
                                                    <p class="text-center mt-2"
                                                        style="font-size: 12px; justify-content: end; align-items: end; display: flex">
                                                        "<?php echo $waktu; ?>"
                                                    </p>
                                                    <hr>
                                                    <p class="text-center">"<?php echo $deskripsi; ?>"</p>
                                                    <hr>

                                                    <!-- Action Buttons -->
                                                    <div class="d-flex justify-content-between mt-3">
                                                        <button onclick="hapus('<?php echo $id_galery; ?>');"
                                                            class="btn btn-danger">Delete</button>
                                                        <button
                                                            onclick="openEditModal('<?php echo $id_galery; ?>', '<?php echo addslashes($nama); ?>', '<?php echo $waktu; ?>', '<?php echo addslashes($deskripsi); ?>', '<?php echo addslashes($gambar); ?>');"
                                                            class="btn btn-primary">Edit</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                <?php
                                    }
                                } else {
                                    echo "<div class='col-12'><p class='text-center'>Tidak ada data galery 😖.</p></div>";
                                }
                                ?>
                            </div>
                        </section>

                        <section class="section">
                            <div class="row">
                                <div class="col-lg-12">
                                    <div class="card">
                                        <div class="card-body text-center">
                                            <!-- Pagination with icons -->
                                            <nav aria-label="Page navigation example" style="margin-top: 2.2rem;">
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

                    <!-- Modal -->
                    <div class="modal fade" id="tambahDataModal" tabindex="-1" aria-labelledby="tambahDataModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="tambahDataModalLabel">Tambah Promo</h5>
                                    <button type="button" class="btn-close" id="closeTambahModal"
                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="tambahForms" method="POST" action="proses/galery/tambah.php"
                                        enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="nama" class="form-label">Nama</label>
                                            <input type="text" id="nama" name="nama" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="waktu" class="form-label">Waktu</label>
                                            <input type="date" id="waktu" name="waktu" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-file-text-line"></i></span>
                                                <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"
                                                    required></textarea>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label for="kover">Data Gambar :</label>
                                            <input type="file" class="form-control-file d-none" id="kover" name="gambar"
                                                onchange="previewImage(this, 'koverPreview')" accept="image/*">
                                            <label class="btn btn-primary text-white" for="kover">Pilih Gambar</label>
                                        </div>

                                        <div class="card mt-2" id="koverPreview" style="display: none;">
                                            <img class="card-img-top" id="koverImage" src="#" alt="Kover Image">
                                        </div>
                                        <script>
                                            function previewImage(input, previewId) {
                                                var preview = document.getElementById(previewId);
                                                var image = document.getElementById('koverImage');
                                                var file = input.files[0];
                                                var fileType = file.type;

                                                if (fileType.match('image.*')) {
                                                    if (input.files && input.files[0]) {
                                                        var reader = new FileReader();

                                                        reader.onload = function(e) {
                                                            image.src = e.target.result;
                                                            preview.style.display = 'block';
                                                        }

                                                        reader.readAsDataURL(input.files[0]);
                                                    } else {
                                                        image.src = '#';
                                                        preview.style.display = 'none';
                                                    }
                                                }
                                            }
                                        </script>
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
                                    <h5 class="modal-title" id="editDataModalLabel">Edit Promo</h5>
                                    <button type="button" class="btn-close" id="closeEditModal" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="editForm" method="POST" action="proses/bank/edit.php"
                                        enctype="multipart/form-data">
                                        <input type="hidden" id="id_galery" name="id_galery">

                                        <div class="mb-3">
                                            <label for="edit-nama" class="form-label">Nama</label>
                                            <input type="text" id="edit-nama" name="nama" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="edit-waktu" class="form-label">Waktu</label>
                                            <input type="date" id="edit-waktu" name="waktu" class="form-control"
                                                required>
                                        </div>

                                        <div class="mb-3">
                                            <label for="deskripsi" class="form-label">Deskripsi</label>
                                            <div class="input-group">
                                                <span class="input-group-text"><i class="ri-file-text-line"></i></span>
                                                <textarea class="form-control" id="edit-deskripsi" name="deskripsi"
                                                    rows="3" required></textarea>
                                            </div>
                                        </div>

                                        <!-- Data Kover -->
                                        <div class="form-group">
                                            <label for="editKover">Data Kover:</label>
                                            <input type="file" class="form-control-file d-none" id="editKover"
                                                name="gambar"
                                                onchange="previewImageAndSetExisting(this, 'editkoverPreview', 'editkoverImage')"
                                                accept="image/*">
                                            <label class="btn btn-primary text-white" for="editKover"><i
                                                    class="ri-image-line"></i>
                                                Pilih Gambar</label>
                                        </div>

                                        <!-- Preview Kover -->
                                        <div class="card" id="editkoverPreview" style="display: none; margin-top: 10px">
                                            <img class="card-img-top" id="editkoverImage" src="#" alt="Kover Image">
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
                    document.getElementById('tambahForms').addEventListener('submit', function(event) {
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

                function openEditModal(id_galery, nama, waktu, deskripsi, gambar_galery) {
                    // Set data to modal inputs
                    document.getElementById('id_galery').value = id_galery;
                    document.getElementById('edit-nama').value = nama;
                    document.getElementById('edit-waktu').value = waktu;
                    document.getElementById('edit-deskripsi').value = deskripsi;

                    let gambar = "../../assets/img/galery/" + gambar_galery; // Perbaiki path jika perlu
                    let editModal = new bootstrap.Modal(document.getElementById('editModal'));

                    // Show preview of the existing image if available
                    if (gambar_galery !== '') { // Pastikan gambar ada sebelum menampilkan
                        var koverPreview = document.getElementById('editkoverPreview');
                        var koverImage = document.getElementById('editkoverImage');
                        koverImage.src = gambar;
                        koverPreview.style.display = 'block';
                    } else {
                        var koverPreview = document.getElementById('editkoverPreview');
                        koverPreview.style.display = 'none'; // Sembunyikan preview jika tidak ada gambar
                    }

                    // Show the modal
                    editModal.show();
                }

                function previewImageAndSetExisting(input, previewDivId, imgElementId) {
                    var previewDiv = document.getElementById(previewDivId);
                    var imgElement = document.getElementById(imgElementId);

                    if (input.files && input.files[0]) {
                        var reader = new FileReader();

                        reader.onload = function(e) {
                            imgElement.src = e.target.result;
                            previewDiv.style.display = 'block';
                        }

                        reader.readAsDataURL(input.files[0]); // Baca file gambar dan tampilkan preview
                    } else {
                        previewDiv.style.display = 'none'; // Sembunyikan preview jika tidak ada file
                    }
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