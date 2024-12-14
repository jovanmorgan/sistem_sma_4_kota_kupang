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
                                           placeholder="Cari kepsek ..." name="search"
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
            // Ambil data kepsek dari database
            include '../../../../keamanan/koneksi.php';

            $search = isset($_GET['search']) ? $_GET['search'] : '';
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            $limit = 10;
            $offset = ($page - 1) * $limit;

            // Query untuk mendapatkan data nama_lengkap dengan pencarian dan pagination
            $query = "SELECT * FROM kepsek WHERE nama_lengkap LIKE ? OR  username LIKE ? OR password LIKE ? LIMIT ?, ?";
            $stmt = $koneksi->prepare($query);
            $search_param = '%' . $search . '%';
            $stmt->bind_param("sssii", $search_param, $search_param, $search_param, $offset, $limit);
            $stmt->execute();
            $result = $stmt->get_result();

            // Hitung total halaman
            $total_query = "SELECT COUNT(*) as total FROM kepsek WHERE nama_lengkap LIKE ? OR  username LIKE ? OR password LIKE ?";
            $stmt_total = $koneksi->prepare($total_query);
            $stmt_total->bind_param("sss", $search_param, $search_param, $search_param);
            $stmt_total->execute();
            $total_result = $stmt_total->get_result();
            $total_row = $total_result->fetch_assoc();
            $total_pages = ceil($total_row['total'] / $limit);
            ?>

           <!-- Tabel Data kepsek -->
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
                                                   <th style="white-space: nowrap;">ID kepsek</th>
                                                   <th style="white-space: nowrap;">Username</th>
                                                   <th style="white-space: nowrap;">Password</th>
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
                                                       <td><?php echo htmlspecialchars($row['id_kepsek']); ?></td>
                                                       <td><?php echo htmlspecialchars($row['nama_lengkap']); ?>
                                                       <td><?php echo htmlspecialchars($row['username']); ?>
                                                       <td><?php echo htmlspecialchars($row['password']); ?>
                                                       </td>
                                                       <td>
                                                           <button class="btn btn-warning btn-sm"
                                                               onclick="openEditModal('<?php echo $row['id_kepsek']; ?>','<?php echo $row['nama_lengkap']; ?>','<?php echo $row['username']; ?>','<?php echo $row['password']; ?>')">Edit</button>
                                                           <button class="btn btn-danger btn-sm"
                                                               onclick="hapus('<?php echo $row['id_kepsek']; ?>')">Hapus</button>
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