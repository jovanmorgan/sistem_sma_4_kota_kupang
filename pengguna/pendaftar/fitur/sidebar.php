<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Fungsi untuk mendapatkan ikon yang sesuai dengan halaman
function getIconForPage($page)
{
    switch ($page) {
        case 'dashboard':
            return 'fas fa-home';
        case 'alumni':
            return 'fas fa-procedures';
        case 'berita':
            return 'fas fa-hand-holding-usd';
        case 'guru':
            return 'fas fa-id-card';
        case 'jurusan':
            return 'fas fa-id-card-alt';
        case 'kelas':
            return 'fas fa-map-marker-alt';
        case 'pegawai':
            return 'fas fa-walking';
        case 'pembagian_kelas':
            return 'fas fa-id-card';
        case 'pendaftar':
            return 'fas fa-id-card-alt';
        case 'pengumuman':
            return 'fas fa-bullhorn';
        case 'siswa':
            return 'fas fa-user-graduate';
        case 'galery':
            return 'fas fa-image';
        case 'profile':
            return 'fas fa-user';
        case 'log_out':
            return 'fas fa-sign-out-alt';
        default:
            return 'fas fa-file'; // Ikon default jika halaman tidak dikenal
    }
}
?>

<!-- Sidebar -->
<div class="sidebar" data-background-color="green">
    <div class="sidebar-logo">
        <!-- Logo Header -->
        <div class="logo-header" data-background-color="green">
            <a href="dasboard" class="logo">
                <img src="../../assets/img/sma/logo.png" alt="navbar brand" class="navbar-brand" height="40px" />
                <h5 class="text-white" style="font-size: 15px; margin-left: 10px; margin-top: 5px">SMA 1 ABAD</h5>
            </a>
            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar">
                    <i class="gg-menu-right"></i>
                </button>
                <button class="btn btn-toggle sidenav-toggler">
                    <i class="gg-menu-left"></i>
                </button>
            </div>
            <button class="topbar-toggler more">
                <i class="gg-more-vertical-alt"></i>
            </button>
        </div>
        <!-- End Logo Header -->
    </div>
    <div class="sidebar-wrapper scrollbar scrollbar-inner" data-background-color="green">
        <div class="sidebar-content">
            <ul class="nav nav-secondary">
                <li class="nav-item <?php echo ($current_page == 'dashboard') ? 'active' : ''; ?>">
                    <a href="dashboard">
                        <i class="<?php echo getIconForPage('dashboard'); ?>"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'profile') ? 'active' : ''; ?>">
                    <a href="profile">
                        <i class="<?php echo getIconForPage('profile'); ?>"></i>
                        <p>Data Pendaftar</p>
                    </a>
                </li>
                <li class="nav-item <?php echo ($current_page == 'pendaftar') ? 'active' : ''; ?>">
                    <a href="pendaftar">
                        <i class="<?php echo getIconForPage('pendaftar'); ?>"></i>
                        <p>Hasil Pendaftaran</p>
                    </a>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Profile</h4>
                </li>

                <li class="nav-item">
                    <a href="log_out">
                        <i class="<?php echo getIconForPage('log_out'); ?>"></i>
                        <p>Log Out</p>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
<!-- End Sidebar -->