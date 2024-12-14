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
            return 'fas fa-wheelchair';
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
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Sistem</h4>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#charts">
                        <i class="fas fa-graduation-cap"></i>
                        <p>Sistem Akademik</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?= in_array($current_page, ['alumni', 'guru', 'jurusan', 'kelas', 'pegawai', 'pembagian_kelas', 'pendaftar', 'siswa',]) ? 'show' : ''; ?>"
                        id="charts">
                        <ul class="nav nav-collapse">
                            <li class="<?php echo ($current_page == 'pendaftar') ? 'active' : ''; ?>">
                                <a href="pendaftar">
                                    <span class="sub-item">Pendaftar</span>
                                </a>
                            </li>
                            <li class="<?php echo ($current_page == 'siswa') ? 'active' : ''; ?>">
                                <a href="siswa">
                                    <span class="sub-item">Siswa</span>
                                </a>
                            </li>
                            <li class="<?php echo ($current_page == 'alumni') ? 'active' : ''; ?>">
                                <a href="alumni">
                                    <span class="sub-item">Alumni</span>
                                </a>
                            </li>
                            <li class="<?php echo ($current_page == 'guru') ? 'active' : ''; ?>">
                                <a href="guru">
                                    <span class="sub-item">Guru</span>
                                </a>
                            </li>
                            <li class="<?php echo ($current_page == 'jurusan') ? 'active' : ''; ?>">
                                <a href="jurusan">
                                    <span class="sub-item">Jurusan</span>
                                </a>
                            </li>
                            <li class="<?php echo ($current_page == 'pegawai') ? 'active' : ''; ?>">
                                <a href="pegawai">
                                    <span class="sub-item">Pegawai</span>
                                </a>
                            </li>
                            <li class="<?php echo ($current_page == 'kelas') ? 'active' : ''; ?>">
                                <a href="kelas">
                                    <span class="sub-item">Kelas</span>
                                </a>
                            </li>
                            <li class="<?php echo ($current_page == 'pembagian_kelas') ? 'active' : ''; ?>">
                                <a href="pembagian_kelas">
                                    <span class="sub-item">Pembagian Kelas</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-item">
                    <a data-bs-toggle="collapse" href="#chartspengguna">
                        <i class="far fa-user"></i>
                        <p>Profile Sekolah</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse <?= in_array($current_page, ['berita', 'galery', 'pengumuman', 'profile_sekolah', 'sarana_prasarana']) ? 'show' : ''; ?>"
                        id="chartspengguna">
                        <ul class="nav nav-collapse">
                            <li class="<?php echo ($current_page == 'berita') ? 'active' : ''; ?>">
                                <a href="berita">
                                    <span class="sub-item">Berita</span>
                                </a>
                            </li>
                            <li class="<?php echo ($current_page == 'profile_sekolah') ? 'active' : ''; ?>">
                                <a href="profile_sekolah">
                                    <span class="sub-item">Profile Sekolah</span>
                                </a>
                            </li>
                            <li class="<?php echo ($current_page == 'galery') ? 'active' : ''; ?>">
                                <a href="galery">
                                    <span class="sub-item">Galery</span>
                                </a>
                            </li>
                            <li class="<?php echo ($current_page == 'sarana_prasarana') ? 'active' : ''; ?>">
                                <a href="sarana_prasarana">
                                    <rana class="sub-item">Sarana Prasarana</rana>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fa fa-ellipsis-h"></i>
                    </span>
                    <h4 class="text-section">Profile</h4>
                </li>
                <li class="nav-item <?php echo ($current_page == 'profile') ? 'active' : ''; ?>">
                    <a href="profile">
                        <i class="<?php echo getIconForPage('profile'); ?>"></i>
                        <p>Profile Saya</p>
                    </a>
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