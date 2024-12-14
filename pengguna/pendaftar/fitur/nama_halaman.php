<?php
// Dapatkan nama halaman dari URL saat ini tanpa ekstensi .php
$current_page = basename(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), ".php");

// Tentukan judul halaman berdasarkan nama file
switch ($current_page) {
    case 'dashboard':
        $page_title = 'Dashboard';
        break;
    case 'pendaftar':
        $page_title = 'Pendaftar';
        break;
    case 'profile':
        $page_title = 'Profile Saya';
        break;
    case 'log_out':
        $page_title = 'Log Out';
        break;
    default:
        $page_title = 'Admin SMA Negeri 1 ABAD';
        break;
}
