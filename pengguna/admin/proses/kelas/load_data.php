   <div id="load_data">
       <section class="section">
           <div class="row">
               <div class="col-lg-12">
                   <div class="card">
                       <div class="card-body text-center">
                           <!-- Search Form -->
                           <form method="GET" action="">
                               <div class="input-group mt-3">
                                   <input type="text" class="form-control" placeholder="Cari kelas ..." name="search"
                                       value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>">
                                   <button class="btn btn-outline-secondary" type="submit">Cari</button>
                               </div>
                           </form>
                       </div>
                   </div>
               </div>
           </div>
       </section>

       <?php
        // Ambil data kelas dari database
        include '../../../../keamanan/koneksi.php';

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 10;
        $offset = ($page - 1) * $limit;

        // Query untuk mendapatkan data kelas dengan pencarian dan pagination
        $query = "
    SELECT k.*, j.nama_jurusan, g.nama AS nama_guru 
    FROM kelas k
    LEFT JOIN jurusan j ON k.id_jurusan = j.id_jurusan
    LEFT JOIN guru g ON k.id_guru = g.id_guru
    WHERE k.nama_kelas LIKE ? 
    LIMIT ?, ?";
        $stmt = $koneksi->prepare($query);
        $search_param = '%' . $search . '%';
        $stmt->bind_param("sii", $search_param, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        // Hitung total halaman
        $total_query = "SELECT COUNT(*) as total FROM kelas WHERE nama_kelas LIKE ?";
        $stmt_total = $koneksi->prepare($total_query);
        $stmt_total->bind_param("s", $search_param);
        $stmt_total->execute();
        $total_result = $stmt_total->get_result();
        $total_row = $total_result->fetch_assoc();
        $total_pages = ceil($total_row['total'] / $limit);
        ?>

       <!-- Tabel Data kelas -->
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
                                               <th style="white-space: nowrap;">ID Kelas</th>
                                               <th style="white-space: nowrap;">Kelas</th>
                                               <th style="white-space: nowrap;">Nama Jurusan</th>
                                               <th style="white-space: nowrap;">Wali Kelas</th>
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
                                                   <td><?php echo htmlspecialchars($row['id_kelas']); ?></td>
                                                   <td><?php echo htmlspecialchars($row['nama_kelas']); ?></td>
                                                   <td><?php echo htmlspecialchars($row['nama_jurusan']); ?>
                                                   </td>
                                                   <td><?php echo htmlspecialchars($row['nama_guru']); ?></td>
                                                   <td>
                                                       <button class="btn btn-warning btn-sm"
                                                           onclick="openEditModal('<?php echo $row['id_kelas']; ?>', '<?php echo $row['nama_kelas']; ?>', '<?php echo $row['id_jurusan']; ?>', '<?php echo $row['id_guru']; ?>')">Edit</button>
                                                       <button class="btn btn-danger btn-sm"
                                                           onclick="hapus('<?php echo $row['id_kelas']; ?>')">Hapus</button>
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