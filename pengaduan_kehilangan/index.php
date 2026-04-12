<?php
/**
 * Sistem Pengaduan Kehilangan Barang Siswa
 * Entry Point & Routing
 */

session_start();

// Autoload controllers
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/SiswaController.php';

// Get requested page
$page = $_GET['page'] ?? 'login';

// Initialize controllers
$authController = new AuthController();
$adminController = new AdminController();
$siswaController = new SiswaController();

// Routing
switch ($page) {
    
    // ========== Auth Routes ==========
    case 'login':
        $authController->showLogin();
        break;
    
    case 'login_process':
        $authController->login();
        break;
    
    case 'logout':
        $authController->logout();
        break;
    
    // ========== Admin Routes ==========
    case 'admin_dashboard':
        $adminController->dashboard();
        break;
    
    case 'admin_aspirasi':
        $adminController->listAspirasi();
        break;
    
    case 'admin_detail':
        $adminController->detailAspirasi();
        break;
    
    case 'admin_update_status':
        $adminController->updateStatus();
        break;
    
    case 'admin_histori':
        $adminController->histori();
        break;
    
    case 'admin_kategori':
        $adminController->manageKategori();
        break;
    
    case 'admin_add_kategori':
        $adminController->addKategori();
        break;
    
    case 'admin_delete_kategori':
        $adminController->deleteKategori();
        break;
    
    case 'admin_archive':
        $adminController->archiveAspirasi();
        break;
    
    // ========== Siswa Routes ==========
    case 'siswa_dashboard':
        $siswaController->dashboard();
        break;
    
    case 'siswa_create':
        $siswaController->createAspirasi();
        break;
    
    case 'siswa_store':
        $siswaController->storeAspirasi();
        break;
    
    case 'siswa_histori':
        $siswaController->histori();
        break;
    
    case 'siswa_detail':
        $siswaController->detail();
        break;
    
    // ========== Default ==========
    default:
        // Redirect ke halaman login sebagai default
        header('Location: index.php?page=login');
        exit;
}
