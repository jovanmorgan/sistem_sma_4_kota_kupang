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

                    // Query untuk mendapatkan data pegawai dan nama jabatan dengan pencarian dan pagination
                    $query = "
                            SELECT p.*, j.jabatan 
                            FROM pegawai p
                            JOIN jabatan j ON p.id_jabatan = j.id_jabatan
                            WHERE p.nama_pegawai LIKE ? OR p.nip_pegawai LIKE ?
                            LIMIT ?, ?";

                    $stmt = $koneksi->prepare($query);
                    $search_param = '%' . $search . '%';
                    $stmt->bind_param("ssii", $search_param, $search_param, $offset, $limit);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    // Query total untuk pagination
                    $total_query = "
                                            SELECT COUNT(*) as total
                                            FROM pegawai p
                                            JOIN jabatan j ON p.id_jabatan = j.id_jabatan
                                            WHERE p.nama_pegawai LIKE ? OR p.nip_pegawai LIKE ?";
                    $stmt_total = $koneksi->prepare($total_query);
                    $stmt_total->bind_param("ss", $search_param, $search_param);
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
                                            <th style="white-space: nowrap;">Nama Pegawai</th>
                                            <th style="white-space: nowrap;">NIP Pegawai</th>
                                            <th style="white-space: nowrap;">Jabatan</th>
                                            <th style="white-space: nowrap;">Jenis Kelamin</th>
                                            <th style="white-space: nowrap;">Tempat Lahir</th>
                                            <th style="white-space: nowrap;">Tanggal Lahir</th>
                                            <th style="white-space: nowrap;">Status</th>
                                            <th style="white-space: nowrap;">Golongan</th>
                                            <th style="white-space: nowrap;">Tahun Golongan</th>
                                            <th style="white-space: nowrap;">Jenjang Pendidikan</th>
                                            <th style="white-space: nowrap;">Tahun Lulus</th>
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
                                                <td><?php echo htmlspecialchars($row['nip_pegawai']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['jabatan']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['jenis_kelamin']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['tempat_lahir']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['tanggal_lahir']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['status']); ?></td>
                                                <td><?php echo htmlspecialchars($row['golongan']); ?></td>
                                                <td><?php echo htmlspecialchars($row['tahun_golongan']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['jenjang_pendidikan']); ?>
                                                </td>
                                                <td><?php echo htmlspecialchars($row['tahun_lulus']); ?>
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