 <?php
    // Mendapatkan URL saat ini untuk menentukan halaman aktif
    $current_page = basename($_SERVER['PHP_SELF'], ".php");
    ?>

 <!-- Navbar Start -->
 <div class="container-fluid p-0">
     <nav class="navbar navbar-expand-lg bg-white navbar-light py-3 py-lg-0 px-lg-5">
         <a href="home" class="navbar-brand ml-lg-3">
             <h1 class="m-0 text-uppercase text-primary">
                 <img src="../../assets/img/sma/logo.png" alt="" width="50px" />
                 <span style="margin-left: 10px">SMA 1 ABAD</span>
             </h1>
         </a>
         <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
             <span class="navbar-toggler-icon"></span>
         </button>
         <div class="collapse navbar-collapse justify-content-between px-lg-3" id="navbarCollapse">
             <div class="navbar-nav mx-auto py-0">
                 <a href="home"
                     class="nav-item nav-link <?php echo ($current_page == 'home') ? 'active' : ''; ?>">Home</a>
                 <a href="home#tentang"
                     class="nav-item nav-link <?php echo ($current_page == 'home' && strpos($_SERVER['REQUEST_URI'], '#tentang') !== false) ? 'active' : ''; ?>">About</a>
                 <a href="home#berita"
                     class="nav-item nav-link <?php echo ($current_page == 'home' && strpos($_SERVER['REQUEST_URI'], '#berita') !== false) ? 'active' : ''; ?>">Berita</a>
                 <a href="home#galery"
                     class="nav-item nav-link <?php echo ($current_page == 'home' && strpos($_SERVER['REQUEST_URI'], '#galery') !== false) ? 'active' : ''; ?>">Galery</a>
                 <a href="home#kontak"
                     class="nav-item nav-link <?php echo ($current_page == 'home' && strpos($_SERVER['REQUEST_URI'], '#kontak') !== false) ? 'active' : ''; ?>">Kontak</a>
                 <div class="nav-item dropdown">
                     <a href="#"
                         class="nav-link dropdown-toggle <?php echo ($current_page == 'data_siswa' || $current_page == 'guru' || $current_page == 'pegawai' || $current_page == 'alumni') ? 'active' : ''; ?>"
                         data-toggle="dropdown">Data</a>
                     <div class="dropdown-menu m-0">
                         <a href="data_siswa"
                             class="dropdown-item <?php echo ($current_page == 'data_siswa') ? 'active' : ''; ?>">Siswa</a>
                         <a href="data_guru"
                             class="dropdown-item <?php echo ($current_page == 'data_guru') ? 'active' : ''; ?>">Guru</a>
                         <a href="data_pegawai"
                             class="dropdown-item <?php echo ($current_page == 'data_pegawai') ? 'active' : ''; ?>">Pegawai</a>
                         <a href="data_alumni"
                             class="dropdown-item <?php echo ($current_page == 'data_alumni') ? 'active' : ''; ?>">Alumni</a>
                     </div>
                 </div>
             </div>
             <a href="../../berlangganan/login" class="btn btn-primary py-2 px-4 d-none d-lg-block">Gabung Sekarang</a>
         </div>
     </nav>
 </div>
 <!-- Navbar End -->