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

                    <div class="card-body">
                        <div class="table-responsive">

                            <?php if ($result->num_rows > 0): ?>
                                <table id="example" class="table table-hover text-center mt-3"
                                    style="border-collapse: separate; border-spacing: 0;">
                                    <thead>
                                        <tr>
                                            <th>Nomor</th>
                                            <th>ID Pembagian Kelas</th>
                                            <th>Kelas</th>
                                            <th>NIS Siswa</th>
                                            <th>Nama Siswa</th>
                                            <th>ID Guru</th>
                                            <th>Nama Guru</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        $nomor = $offset + 1;
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