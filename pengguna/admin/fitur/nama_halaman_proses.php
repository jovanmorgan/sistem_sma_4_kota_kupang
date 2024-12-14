<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page_proses = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Tentukan judul halaman berdasarkan nama file
switch ($current_page_proses) {
    case 'dashboard':
        $page_title_proses = 'dashboard';
        break;
    case 'alumni':
        $page_title_proses = 'alumni';
        break;
    case 'berita':
        $page_title_proses = 'berita';
        break;
    case 'guru':
        $page_title_proses = 'guru';
        break;
    case 'jurusan':
        $page_title_proses = 'jurusan';
        break;
    case 'kelas':
        $page_title_proses = 'kelas';
        break;
    case 'pegawai':
        $page_title_proses = 'pegawai';
        break;
    case 'pembagian_kelas':
        $page_title_proses = 'pembagian_kelas';
        break;
    case 'pendaftar':
        $page_title_proses = 'pendaftar';
        break;
    case 'sarana_prasarana':
        $page_title_proses = 'sarana_prasarana';
        break;
    case 'profile_sekolah':
        $page_title_proses = 'profile_sekolah';
        break;
    case 'pengumuman':
        $page_title_proses = 'pengumuman';
        break;
    case 'siswa':
        $page_title_proses = 'siswa';
        break;
    case 'galery':
        $page_title_proses = 'galery';
        break;
    case 'profile':
        $page_title_proses = 'Profile Saya';
        break;
    case 'log_out':
        $page_title_proses = 'Log Out';
        break;
    default:
        $page_title_proses_proses = 'Admin SMK 4 ABAD';
        break;
}
