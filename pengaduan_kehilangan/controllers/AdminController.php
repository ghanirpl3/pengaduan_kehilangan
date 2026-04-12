<?php
require_once __DIR__ . '/../models/InputAspirasi.php';
require_once __DIR__ . '/../models/Aspirasi.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/Siswa.php';
require_once __DIR__ . '/AuthController.php';

/**
 * AdminController
 * Mengelola fitur-fitur admin
 */
class AdminController {
    private $inputAspirasiModel;
    private $aspirasiModel;
    private $kategoriModel;
    private $siswaModel;
    
    public function __construct() {
        $this->inputAspirasiModel = new InputAspirasi();
        $this->aspirasiModel = new Aspirasi();
        $this->kategoriModel = new Kategori();
        $this->siswaModel = new Siswa();
    }
    
    /**
     * Dashboard Admin
     */
    public function dashboard() {
        AuthController::checkAdmin();
        
        $totalAspirasi = $this->inputAspirasiModel->count();
        $totalMenunggu = $this->inputAspirasiModel->countByStatus('Menunggu');
        $totalProses = $this->inputAspirasiModel->countByStatus('Proses');
        $totalSelesai = $this->inputAspirasiModel->countByStatus('Selesai');
        $totalSiswa = $this->siswaModel->count();
        $totalKategori = $this->kategoriModel->count();
        
        // Aspirasi terbaru (limit 5)
        $aspirasiTerbaru = array_slice($this->inputAspirasiModel->getAll(), 0, 5);
        
        require_once __DIR__ . '/../views/admin/dashboard.php';
    }
    
    /**
     * List semua aspirasi dengan filter
     */
    public function listAspirasi() {
        AuthController::checkAdmin();
        
        $kategoriList = $this->kategoriModel->getAll();
        $siswaList = $this->siswaModel->getAll();
        
        // Flash messages
        $success = $_SESSION['success'] ?? null;
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['success'], $_SESSION['error']);
        
        // Filter
        $filter = $_GET['filter'] ?? '';
        $value = $_GET['value'] ?? '';
        $startDate = $_GET['start_date'] ?? '';
        $endDate = $_GET['end_date'] ?? '';
        
        if ($filter === 'kategori' && !empty($value)) {
            $aspirasiList = $this->inputAspirasiModel->filterByKategori($value);
        } elseif ($filter === 'status' && !empty($value)) {
            $aspirasiList = $this->inputAspirasiModel->filterByStatus($value);
        } elseif ($filter === 'tanggal' && !empty($startDate) && !empty($endDate)) {
            $aspirasiList = $this->inputAspirasiModel->filterByDate($startDate, $endDate);
        } else {
            $aspirasiList = $this->inputAspirasiModel->getAll();
        }
        
        require_once __DIR__ . '/../views/admin/aspirasi.php';
    }
    
    /**
     * Detail aspirasi
     */
    public function detailAspirasi() {
        AuthController::checkAdmin();
        
        $id = $_GET['id'] ?? 0;
        $aspirasi = $this->inputAspirasiModel->getById($id);
        
        if (!$aspirasi) {
            $_SESSION['error'] = 'Aspirasi tidak ditemukan!';
            header('Location: index.php?page=admin_aspirasi');
            exit;
        }
        
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        
        require_once __DIR__ . '/../views/admin/detail_aspirasi.php';
    }
    
    /**
     * Update status dan feedback
     */
    public function updateStatus() {
        AuthController::checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_pelaporan = $_POST['id_pelaporan'] ?? 0;
            $status = $_POST['status'] ?? 'Menunggu';
            $feedback = $_POST['feedback'] ?? '';
            $id_admin = $_SESSION['user_id'];
            
            // Cek apakah status sudah Selesai, jika iya tidak bisa diubah lagi
            $existing = $this->inputAspirasiModel->getById($id_pelaporan);
            if ($existing && $existing['status'] === 'Selesai') {
                $_SESSION['error'] = 'Pengaduan yang sudah selesai tidak dapat diubah lagi!';
                header("Location: index.php?page=admin_detail&id=$id_pelaporan");
                exit;
            }
            
            $result = $this->aspirasiModel->updateStatus($id_pelaporan, $status, $feedback, $id_admin);
            
            if ($result) {
                $_SESSION['success'] = 'Status berhasil diperbarui!';
            } else {
                $_SESSION['error'] = 'Gagal memperbarui status!';
            }
            
            header("Location: index.php?page=admin_detail&id=$id_pelaporan");
            exit;
        }
    }
    
    /**
     * Histori aspirasi
     */
    public function histori() {
        AuthController::checkAdmin();
        
        $filters = [];
        if (!empty($_GET['status'])) {
            $filters['status'] = $_GET['status'];
        }
        if (!empty($_GET['start_date']) && !empty($_GET['end_date'])) {
            $filters['start_date'] = $_GET['start_date'];
            $filters['end_date'] = $_GET['end_date'];
        }
        
        $historiList = $this->aspirasiModel->getHistori($filters);
        
        require_once __DIR__ . '/../views/admin/histori.php';
    }
    
    /**
     * Kelola kategori
     */
    public function manageKategori() {
        AuthController::checkAdmin();
        
        $kategoriList = $this->kategoriModel->getAll();
        $success = $_SESSION['success'] ?? null;
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['success'], $_SESSION['error']);
        
        require_once __DIR__ . '/../views/admin/kategori.php';
    }
    
    /**
     * Tambah kategori
     */
    public function addKategori() {
        AuthController::checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $ket_kategori = trim($_POST['ket_kategori'] ?? '');
            
            if (empty($ket_kategori)) {
                $_SESSION['error'] = 'Nama kategori harus diisi!';
            } else {
                $result = $this->kategoriModel->create(['ket_kategori' => $ket_kategori]);
                if ($result) {
                    $_SESSION['success'] = 'Kategori berhasil ditambahkan!';
                } else {
                    $_SESSION['error'] = 'Gagal menambahkan kategori!';
                }
            }
            
            header('Location: index.php?page=admin_kategori');
            exit;
        }
    }
    
    /**
     * Hapus kategori
     */
    public function deleteKategori() {
        AuthController::checkAdmin();
        
        $id = $_GET['id'] ?? 0;
        
        if ($id) {
            $result = $this->kategoriModel->delete($id);
            if ($result) {
                $_SESSION['success'] = 'Kategori berhasil dihapus!';
            } else {
                $_SESSION['error'] = 'Gagal menghapus kategori!';
            }
        }
        
        header('Location: index.php?page=admin_kategori');
        exit;
    }
    
    /**
     * Arsipkan aspirasi ke histori
     */
    public function archiveAspirasi() {
        AuthController::checkAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_pelaporan = $_POST['id_pelaporan'] ?? 0;
            $id_admin = $_SESSION['user_id'];
            
            if ($id_pelaporan) {
                $result = $this->aspirasiModel->archive($id_pelaporan, $id_admin);
                if ($result) {
                    $_SESSION['success'] = 'Aspirasi berhasil diarsipkan!';
                } else {
                    $_SESSION['error'] = 'Gagal mengarsipkan aspirasi!';
                }
            }
        }
        
        header('Location: index.php?page=admin_aspirasi');
        exit;
    }
}
