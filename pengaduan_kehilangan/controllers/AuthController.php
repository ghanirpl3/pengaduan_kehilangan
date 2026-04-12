<?php
require_once __DIR__ . '/../models/Admin.php';
require_once __DIR__ . '/../models/Siswa.php';

/**
 * AuthController
 * Mengelola autentikasi login dan logout
 */
class AuthController {
    private $adminModel;
    private $siswaModel;
    
    public function __construct() {
        $this->adminModel = new Admin();
        $this->siswaModel = new Siswa();
    }
    
    /**
     * Menampilkan halaman login
     */
    public function showLogin() {
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once __DIR__ . '/../views/auth/login.php';
    }
    
    /**
     * Proses login (auto-detect admin atau siswa)
     */
    public function login() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            
            if (empty($username) || empty($password)) {
                $_SESSION['error'] = 'Username/NIS dan password harus diisi!';
                header('Location: index.php?page=login');
                exit;
            }
            
            // Coba login sebagai admin dulu
            $admin = $this->adminModel->findByUsername($username);
            if ($admin && $this->adminModel->verifyPassword($password, $admin['password'])) {
                $_SESSION['user_id'] = $admin['id_admin'];
                $_SESSION['username'] = $admin['username'];
                $_SESSION['role'] = 'admin';
                
                header('Location: index.php?page=admin_dashboard');
                exit;
            }
            
            // Kalau bukan admin, coba login sebagai siswa (pakai NIS)
            $siswa = $this->siswaModel->findByNis($username);
            if ($siswa && $this->siswaModel->verifyPassword($password, $siswa['password'])) {
                $_SESSION['user_id'] = $siswa['nis'];
                $_SESSION['nama'] = $siswa['nama_siswa'];
                $_SESSION['kelas'] = $siswa['kelas'];
                $_SESSION['role'] = 'siswa';
                
                header('Location: index.php?page=siswa_dashboard');
                exit;
            }
            
            // Gagal login
            $_SESSION['error'] = 'Username/NIS atau password salah!';
            header('Location: index.php?page=login');
            exit;
        }
    }
    
    /**
     * Proses logout
     */
    public function logout() {
        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
    
    /**
     * Cek apakah user sudah login sebagai admin
     */
    public static function checkAdmin() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: index.php?page=login');
            exit;
        }
    }
    
    /**
     * Cek apakah user sudah login sebagai siswa
     */
    public static function checkSiswa() {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'siswa') {
            header('Location: index.php?page=login');
            exit;
        }
    }
}
