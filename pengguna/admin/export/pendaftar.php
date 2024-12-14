<?php include '../fitur/nama_halaman.php'; ?>
<!DOCTYPE html>
<html lang="en">
<?php include 'head_export.php'; ?>

<body translate="no">
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header pb-0">
                        <h3 class="text-center">Data Export <?= $page_title ?> </h3>
                    </div>
                    <?php
                    // Ambil data checkout dari database
                    include '../../../keamanan/koneksi.php';
                    $search = isset($_GET['search']) ? $_GET['search'] : '';
                    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                    $limit = 10;
                    $offset = ($page - 1) * $limit;

                    // Query untuk mendapatkan data pendaftar dengan pencarian dan pagination
                    $query = "SELECT * FROM pendaftar WHERE nama LIKE ? LIMIT ?, ?";
                    $stmt = $koneksi->prepare($query);
                    $search_param = '%' . $search . '%';
                    $stmt->bind_param("sii", $search_param, $offset, $limit);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Hitung total halaman
                    $total_query = "SELECT COUNT(*) as total FROM pendaftar WHERE nama LIKE ?";
                    $stmt_total = $koneksi->prepare($total_query);
                    $stmt_total->bind_param("s", $search_param);
                    $stmt_total->execute();
                    $total_result = $stmt_total->get_result();
                    $total_row = $total_result->fetch_assoc();
                    $total_pages = ceil($total_row['total'] / $limit);
                    ?>

                    <div class="card-body">
                        <div class="table-responsive">

                            <?php if ($result->num_rows > 0): ?>
                                <table id="example" class="table table-hover text-center mt-3"
                                    style="border-collapse: separate; border-spacing: 0;">
                                    <thead>
                                        <tr>
                                            <th style="white-space: nowrap;">Nomor</th>
                                            <th style="white-space: nowrap;">ID Pendaftar</th>
                                            <th style="white-space: nowrap;">Nama</th>
                                            <th style="white-space: nowrap;">JK</th>
                                            <th style="white-space: nowrap;">NISN</th>
                                            <th style="white-space: nowrap;">NIK</th>
                                            <th style="white-space: nowrap;">Username</th>
                                            <th style="white-space: nowrap;">Tempat Lahir</th>
                                            <th style="white-space: nowrap;">Tanggal Lahir</th>
                                            <th style="white-space: nowrap;">Agama</th>
                                            <th style="white-space: nowrap;">Alamat</th>
                                            <th style="white-space: nowrap;">Anak Keberapa</th>
                                            <th style="white-space: nowrap;">Sekolah Asal</th>
                                            <th style="white-space: nowrap;">Kode Pos</th>
                                            <th style="white-space: nowrap;">Tanggal Mendaftar</th>
                                            <th style="white-space: nowrap;">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nomor = $offset + 1;
                                        while ($row = $result->fetch_assoc()) :
                                        ?>
                                            <tr>
                                                <td><?php echo $nomor++; ?></td>
                                                <td><?php echo htmlspecialchars($row['id_pendaftar']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['nama']); ?></td>
                                                <td><?php echo htmlspecialchars($row['jk']); ?></td>
                                                <td><?php echo htmlspecialchars($row['nisn']); ?></td>
                                                <td><?php echo htmlspecialchars($row['nik']); ?></td>
                                                <td><?php echo htmlspecialchars($row['username']); ?></td>
                                                <td><?php echo htmlspecialchars($row['tempat_lahir']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['tanggal_lahir']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['agama']); ?></td>
                                                <td><?php echo htmlspecialchars($row['alamat']); ?></td>
                                                <td><?php echo htmlspecialchars($row['anak_keberapa']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['skl']); ?></td>
                                                <td><?php echo htmlspecialchars($row['kode_pos']); ?></td>

                                                <td><?php echo htmlspecialchars($row['tgl_mendaftar']); ?>
                                                </td>
                                                <td>
                                                    <button class="btn btn-warning btn-sm"
                                                        onclick="openEditModal('<?php echo $row['id_pendaftar']; ?>', '<?php echo $row['status']; ?>')">
                                                        <span class="badge 
            <?php
                                            if ($row['status'] == 'lulus') {
                                                echo 'bg-success'; // Jika status Lulus, gunakan bg-success (warna hijau)
                                            } elseif ($row['status'] == 'tidak_lulus') {
                                                echo 'bg-danger'; // Jika status Tidak Lulus, gunakan bg-danger (warna merah)
                                            } else {
                                                echo 'bg-info'; // Status lainnya atau kosong menggunakan bg-info
                                            }
            ?>">
                                                            <?php
                                                            if (empty($row['status'])) {
                                                                echo 'Setujui Pendaftaran'; // Tampilkan teks "Setujui Pendaftaran" jika status kosong
                                                            } else {
                                                                echo htmlspecialchars($row['status']); // Tampilkan status jika ada
                                                            }
                                                            ?>
                                                        </span>
                                                    </button>
                                                </td>


                                            </tr>
                                        <?php endwhile; ?>
                                    </tbody>
                                </table>

                            <?php else: ?>
                                <p class="text-center mt-4">Data tidak ditemukan 😖.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    <!-- Pagination -->
                </div>
            </div>
        </div>
    </div>

    <?php include '../fitur/js_export.php'; ?>

</body>

</html>