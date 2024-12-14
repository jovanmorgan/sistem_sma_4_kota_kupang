  <!DOCTYPE html>
  <html lang="en">
  <?php include "fitur/head.php"; ?>

  <body>
      <?php include "fitur/navbar.php"; ?>
      <?php include "fitur/header.php"; ?>

      <?php
        // Ambil data sarana_prasarana dari database
        include '../../keamanan/koneksi.php';

        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $limit = 1; // Ambil satu data saja untuk ditampilkan di bagian About
        $offset = ($page - 1) * $limit;

        // Query untuk mendapatkan satu data sarana_prasarana
        $query = "SELECT * FROM sarana_prasarana WHERE id_sarana_prasarana LIKE ? LIMIT ?, ?";
        $stmt = $koneksi->prepare($query);
        $search_param = '%' . $search . '%';
        $stmt->bind_param("sii", $search_param, $offset, $limit);
        $stmt->execute();
        $result = $stmt->get_result();

        $data = $result->fetch_assoc(); // Ambil data satu baris
        ?>

      <!-- About Start -->
      <div class="container-fluid py-5" id="tentang">
          <div class="container py-5">
              <div class="row">
                  <div class="col-lg-5 mb-5 mb-lg-0" style="min-height: 500px">
                      <div class="position-relative h-100">
                          <img class="position-absolute w-100 h-100" src="../../assets/img/sma/halaman_depan.jpg"
                              style="object-fit: cover" />
                      </div>
                  </div>
                  <div class="col-lg-7">
                      <div class="section-title position-relative mb-4">
                          <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">
                              Tentang Kami
                          </h6>
                          <h1 class="display-4">
                              Kualitas Dari SMA Negeri 1 ABAD
                          </h1>
                      </div>
                      <p>
                          SMA Negeri 1 ABAD telah menjadi pilihan utama bagi siswa yang ingin
                          mendapatkan pendidikan berkualitas di lingkungan yang mendukung dan
                          inspiratif. Kami tidak hanya berfokus pada prestasi akademik, tetapi juga
                          pengembangan karakter serta keterampilan abad ke-21 yang akan mempersiapkan
                          siswa untuk sukses di masa depan. Dengan tenaga pendidik yang berdedikasi
                          dan fasilitas modern, kami bangga menjadi rumah bagi banyak generasi muda
                          yang berprestasi.
                      </p>
                      <!-- bagian prasarana dan icon yang sesuai -->
                      <div class="row pt-3 mx-0">
                          <div class="col-3 px-0">
                              <div class="bg-success text-center p-4">
                                  <h1 class="text-white" data-toggle="counter-up">
                                      <?php echo htmlspecialchars($data['jumlah_gudang']); ?></h1>
                                  <h6 class="text-uppercase text-white">
                                      Jumlah<span class="d-block">Gudang</span>
                                  </h6>
                              </div>
                          </div>
                          <div class="col-3 px-0">
                              <div class="bg-primary text-center p-4">
                                  <h1 class="text-white" data-toggle="counter-up">
                                      <?php echo htmlspecialchars($data['jumlah_ruangan']); ?></h1>
                                  <h6 class="text-uppercase text-white">
                                      Jumlah<span class="d-block">Ruangan</span>
                                  </h6>
                              </div>
                          </div>
                          <div class="col-3 px-0">
                              <div class="bg-secondary text-center p-4">
                                  <h1 class="text-white" data-toggle="counter-up">
                                      <?php echo htmlspecialchars($data['jumlah_kelas']); ?></h1>
                                  <h6 class="text-uppercase text-white">
                                      Jumlah<span class="d-block">Kelas</span>
                                  </h6>
                              </div>
                          </div>
                          <div class="col-3 px-0">
                              <div class="bg-warning text-center p-4">
                                  <h1 class="text-white" data-toggle="counter-up">
                                      <?php echo htmlspecialchars($data['jumlah_lab']); ?></h1>
                                  <h6 class="text-uppercase text-white">
                                      Jumlah<span class="d-block">Laboratorium</span>
                                  </h6>
                              </div>
                          </div>
                      </div>
                      <div class="row pt-3 mx-0">
                          <div class="col-3 px-0">
                              <div class="bg-success text-center p-4">
                                  <h1 class="text-white" data-toggle="counter-up">
                                      <?php echo htmlspecialchars($data['jumlah_lapangan']); ?></h1>
                                  <h6 class="text-uppercase text-white">
                                      Jumlah<span class="d-block">Lapangan</span>
                                  </h6>
                              </div>
                          </div>
                          <div class="col-3 px-0">
                              <div class="bg-primary text-center p-4">
                                  <h1 class="text-white" data-toggle="counter-up">
                                      <?php echo htmlspecialchars($data['jumlah_kamar_mandi']); ?></h1>
                                  <h6 class="text-uppercase text-white">
                                      Jumlah<span class="d-block">Kamar Mandi</span>
                                  </h6>
                              </div>
                          </div>
                          <div class="col-3 px-0">
                              <div class="bg-secondary text-center p-4">
                                  <h1 class="text-white" data-toggle="counter-up">
                                      <?php echo htmlspecialchars($data['jumlah_perpustakaan']); ?></h1>
                                  <h6 class="text-uppercase text-white">
                                      Jumlah<span class="d-block">Perpustakaan</span>
                                  </h6>
                              </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- About End -->


      <!-- Visi dan Misi Start -->
      <div class="container-fluid bg-image" id="vismisi" style="margin: 90px 0">
          <div class="container">
              <div class="row">
                  <div class="col-lg-7 my-5 pt-5 pb-lg-5">
                      <div class="section-title position-relative mb-4">
                          <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">
                              Visi dan Misi
                          </h6>
                          <h1 class="display-4">Visi dan Misi SMA Negeri 1 ABAD</h1>
                      </div>
                      <p class="mb-4 pb-2">
                          SMA Negeri 1 ABAD berkomitmen untuk menyediakan lingkungan belajar yang inspiratif dan
                          mendukung bagi semua siswa. Kami memiliki visi dan misi yang jelas untuk mencetak generasi
                          muda
                          yang siap menghadapi tantangan masa depan.
                      </p>

                      <?php
                        // Ambil data profile_sekolah dari database
                        include '../../keamanan/koneksi.php';

                        $query = "SELECT * FROM profile_sekolah LIMIT 1"; // Mengambil satu record untuk visi dan misi
                        $result = $koneksi->query($query);

                        if ($result->num_rows > 0) {
                            $row = $result->fetch_assoc();
                            $visi = htmlspecialchars($row['visi']);
                            $misi = htmlspecialchars($row['misi']);
                            $alamat_sekolah = htmlspecialchars($row['alamat_sekolah']);
                        ?>
                          <div class="d-flex mb-3">
                              <div class="btn-icon bg-primary mr-4">
                                  <i class="fa fa-2x fa-eye text-white"></i>
                              </div>
                              <div class="mt-n1">
                                  <h4>Visi</h4>
                                  <p><?php echo $visi; ?></p>
                              </div>
                          </div>
                          <div class="d-flex mb-3">
                              <div class="btn-icon bg-secondary mr-4">
                                  <i class="fa fa-2x fa-bullseye text-white"></i>
                              </div>
                              <div class="mt-n1">
                                  <h4>Misi</h4>
                                  <p><?php echo nl2br($misi); ?></p>
                              </div>
                          </div>
                          <div class="d-flex">
                              <div class="btn-icon bg-warning mr-4">
                                  <i class="fa fa-2x fa-map-marker-alt text-white"></i>
                              </div>
                              <div class="mt-n1">
                                  <h4>Alamat Sekolah</h4>
                                  <p class="m-0"><?php echo $alamat_sekolah; ?></p>
                              </div>
                          </div>
                      <?php
                        } else {
                            echo '<p class="text-center mt-4">Data visi dan misi tidak ditemukan.</p>';
                        }
                        ?>
                  </div>
                  <div class="col-lg-5" style="min-height: 500px">
                      <div class="position-relative h-100">
                          <img class="position-absolute w-100 h-100" src="../../assets/img/sma/bagian_depan.jpg"
                              style="object-fit: cover" />
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- Visi dan Misi End -->

      <!-- Courses Start -->
      <div class="container-fluid px-0 py-5" id="berita">
          <div class="row mx-0 justify-content-center pt-5">
              <div class="col-lg-6">
                  <div class="section-title text-center position-relative mb-4">
                      <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">
                          Berita
                      </h6>
                      <h1 class="display-4">Berita Sekolah Untuk Anda</h1>
                  </div>
              </div>
          </div>
          <div class="owl-carousel courses-carousel">
              <div class="courses-item position-relative">
                  <?php
                    include '../../keamanan/koneksi.php';

                    // Query to fetch records
                    $result = mysqli_query($koneksi, "SELECT * FROM berita LIMIT 6"); // Ambil 6 berita terbaru

                    while ($row = mysqli_fetch_assoc($result)) {
                        $id_berita = $row['id_berita'];
                        $nama = $row['nama'];
                        $gambar = $row['gambar'];
                    ?>
                      <div class="courses-item position-relative">
                          <img class="img-fluid" src="../../assets/img/berita/<?php echo $gambar; ?>"
                              alt="<?php echo $nama; ?>" />
                          <div class="courses-text">
                              <h4 class="text-center text-white px-3">
                                  <?php echo $nama; ?>
                              </h4>
                              <div class="w-100 bg-white text-center p-4">
                                  <form method="POST" action="detail_berita.php?id_berita=<?php echo $id_berita; ?>">
                                      <input type="hidden" name="id_berita" value="<?php echo $id_berita; ?>">
                                      <button class="btn btn-primary" type="submit">Detail Berita</button>
                                  </form>
                              </div>
                          </div>
                      </div>
                  <?php
                    }
                    ?>
              </div>
          </div>
      </div>
      <!-- Courses End -->


      <!-- Gallery Start -->
      <div class="container-fluid py-5" id="galery">
          <div class="container py-5">
              <div class="section-title text-center position-relative mb-5">
                  <h6 class="d-inline-block position-relative text-secondary text-uppercase pb-2">
                      Galery
                  </h6>
                  <h1 class="display-4">Galery Sekolah Kami</h1>
              </div>
              <div class="row">
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
                          <div class="col-lg-3 col-md-6 mb-4">
                              <div class="team-item">
                                  <img class="img-fluid w-100" src="../../assets/img/galery/<?php echo $gambar; ?>"
                                      alt="<?php echo $nama; ?>" />
                                  <div class="bg-light text-center p-4">
                                      <h5 class="mb-3"><?php echo $nama; ?></h5>
                                      <p class="mb-2"><?php echo $deskripsi; ?></p>
                                      <p class="text-muted"><?php echo $waktu; ?></p>
                                  </div>
                              </div>
                          </div>
                  <?php
                        }
                    } else {
                        echo "<div class='col-12'><p class='text-center'>Tidak ada data galeri 😖.</p></div>";
                    }
                    ?>
              </div>
          </div>
      </div>
      <!-- Gallery End -->

      <!-- Contact Start -->
      <div class="container-fluid py-5" id="kontak">
          <div class="container py-5">
              <div class="row align-items-center">
                  <div class="col-lg-5 mb-5 mb-*lg-0">
                      <div class="bg-light d-flex flex-column justify-content-center px-5" style="height: 450px">
                          <div class="d-flex align-items-center mb-5">
                              <div class="btn-icon bg-primary mr-4">
                                  <i class="fa fa-2x fa-map-marker-alt text-white"></i>
                              </div>
                              <div class="mt-n1">
                                  <h4>Our Location</h4>
                                  <p class="m-0">SMA Negeri 1 ABAD</p>
                                  <p class="m-0">ABAD, East Nusa Tenggara, Indonesia</p>
                              </div>
                          </div>
                          <div class="d-flex align-items-center mb-5">
                              <div class="btn-icon bg-secondary mr-4">
                                  <i class="fa fa-2x fa-phone-alt text-white"></i>
                              </div>
                              <div class="mt-n1">
                                  <h4>Call Us</h4>
                                  <p class="m-0">+62 823 456 789</p>
                              </div>
                          </div>
                          <div class="d-flex align-items-center">
                              <div class="btn-icon bg-warning mr-4">
                                  <i class="fa fa-2x fa-envelope text-white"></i>
                              </div>
                              <div class="mt-n1">
                                  <h4>Email Us</h4>
                                  <p class="m-0">sman1ABAD@gmail.com</p>
                              </div>
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-7">
                      <!-- Google Maps Embed -->
                      <iframe
                          src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.2084999283663!2d124.5289755!3d-8.2531313!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2d007f35e2602165%3A0x2a5cd8e42a65a0a4!2sSMA%20Negeri%201%20ABAD%20Barat%20Daya!5e0!3m2!1sen!2sid!4v1696417275684!5m2!1sen!2sid"
                          width="100%" height="450" style="border: 0" allowfullscreen="" loading="lazy"
                          referrerpolicy="no-referrer-when-downgrade">
                      </iframe>
                  </div>
              </div>
          </div>
      </div>
      <!-- Contact End -->

      <?php include "fitur/footer.php"; ?>


  </body>

  </html>