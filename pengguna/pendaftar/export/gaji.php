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

                    // Query untuk mendapatkan data gaji dan pegawai dengan pencarian dan pagination
                    $query = "
    SELECT gaji.*, pegawai.nama_pegawai 
    FROM gaji 
    LEFT JOIN pegawai ON gaji.id_pegawai = pegawai.id_pegawai 
    WHERE gaji.gaji_pokok LIKE ? 
    OR gaji.tunjangan LIKE ? 
    OR gaji.total LIKE ? 
    OR gaji.potongan LIKE ? 
    LIMIT ?, ?";

                    $stmt = $koneksi->prepare($query);
                    $search_param = '%' . $search . '%';
                    $stmt->bind_param("ssssii", $search_param, $search_param, $search_param, $search_param, $offset, $limit);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Hitung total halaman
                    $total_query = "
    SELECT COUNT(*) as total 
    FROM gaji 
    LEFT JOIN pegawai ON gaji.id_pegawai = pegawai.id_pegawai 
    WHERE gaji.gaji_pokok LIKE ? 
    OR gaji.tunjangan LIKE ? 
    OR gaji.total LIKE ? 
    OR gaji.potongan LIKE ?";

                    $stmt_total = $koneksi->prepare($total_query);
                    $stmt_total->bind_param("ssss", $search_param, $search_param, $search_param, $search_param);
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
                                            <th>Nomor</th>
                                            <th>Gaji</th>
                                            <th>Nama Pegawai</th> <!-- Tambahkan kolom Nama Pegawai -->
                                            <th>Tunjangan</th>
                                            <th>Potongan</th>
                                            <th>Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nomor = $offset + 1;
                                        while ($row = $result->fetch_assoc()) :
                                        ?>
                                            <tr>
                                                <td><?php echo $nomor++; ?></td>
                                                <td><?php echo htmlspecialchars($row['gaji_pokok']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['nama_pegawai']); ?>
                                                </td> <!-- Menampilkan nama pegawai -->
                                                <td><?php echo htmlspecialchars($row['tunjangan']); ?></td>
                                                <td><?php echo htmlspecialchars($row['potongan']); ?></td>
                                                <td><?php echo htmlspecialchars($row['total']); ?></td>
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