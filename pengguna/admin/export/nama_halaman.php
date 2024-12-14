<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Tentukan judul halaman berdasarkan nama file
switch ($current_page) {
    case 'dashboard':
        $page_title = 'Dashboard';
        break;
    case 'alumni':
        $page_title = 'Alumni';
        break;
    case 'berita':
        $page_title = 'Berita';
        break;
    case 'guru':
        $page_title = 'Guru';
        break;
    case 'jurusan':
        $page_title = 'Jurusan';
        break;
    case 'kelas':
        $page_title = 'Kelas';
        break;
    case 'pegawai':
        $page_title = 'Pegawai';
        break;
    case 'pembagian_kelas':
        $page_title = 'Pembagian Kelas';
        break;
    case 'pendaftar':
        $page_title = 'Pendaftar';
        break;
    case 'pengumuman':
        $page_title = 'Pengumuman';
        break;
    case 'siswa':
        $page_title = 'Siswa';
        break;
    case 'galery':
        $page_title = 'Galery';
        break;
    case 'sarana_prasarana':
        $page_title = 'Sarana Prasarana';
        break;
    case 'profile':
        $page_title = 'Profile Saya';
        break;
    case 'profile_sekolah':
        $page_title = 'Profile Sekolah';
        break;
    case 'log_out':
        $page_title = 'Log Out';
        break;
    default:
        $page_title = 'Admin SMA Negeri 1 ABAD';
        break;
}
