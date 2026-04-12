<?php
require_once __DIR__ . '/../models/InputAspirasi.php';
require_once __DIR__ . '/../models/Aspirasi.php';
require_once __DIR__ . '/../models/Kategori.php';
require_once __DIR__ . '/../models/Siswa.php';
require_once __DIR__ . '/AuthController.php';

/**
 * SiswaController
 * Mengelola fitur-fitur siswa
 */
class SiswaController {
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
     * Dashboard Siswa
     */
    public function dashboard() {
        AuthController::checkSiswa();
        
        $nis = $_SESSION['user_id'];
        $nama = $_SESSION['nama'];
        $kelas = $_SESSION['kelas'];
        
        // Statistik aspirasi siswa
        $aspirasiList = $this->inputAspirasiModel->getByNis($nis);
        $totalAspirasi = count($aspirasiList);
        
        $totalMenunggu = 0;
        $totalProses = 0;
        $totalSelesai = 0;
        
        foreach ($aspirasiList as $aspirasi) {
            switch ($aspirasi['status']) {
                case 'Menunggu':
                    $totalMenunggu++;
                    break;
                case 'Proses':
                    $totalProses++;
                    break;
                case 'Selesai':
                    $totalSelesai++;
                    break;
            }
        }
        
        // Aspirasi terbaru (limit 5)
        $aspirasiTerbaru = array_slice($aspirasiList, 0, 5);
        
        require_once __DIR__ . '/../views/siswa/dashboard.php';
    }
    
    /**
     * Form buat aspirasi baru
     */
    public function createAspirasi() {
        AuthController::checkSiswa();
        
        $kategoriList = $this->kategoriModel->getAll();
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        
        require_once __DIR__ . '/../views/siswa/aspirasi_form.php';
    }
    
    /**
     * Simpan aspirasi baru
     */
    public function storeAspirasi() {
        AuthController::checkSiswa();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nis = $_SESSION['user_id'];
            $kelas = $_SESSION['kelas'];
            $id_kategori = $_POST['id_kategori'] ?? 0;
            $isi_text = trim($_POST['isi_text'] ?? '');
            
            // Validasi
            if (empty($id_kategori) || empty($isi_text)) {
                $_SESSION['error'] = 'Semua field harus diisi!';
                header('Location: index.php?page=siswa_create');
                exit;
            }
            
            // Handle upload gambar
            $isi_gambar = null;
            if (isset($_FILES['isi_gambar']) && $_FILES['isi_gambar']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = __DIR__ . '/../assets/uploads/';
                
                // Buat folder jika belum ada
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }
                
                $fileName = time() . '_' . basename($_FILES['isi_gambar']['name']);
                $targetPath = $uploadDir . $fileName;
                
                // Validasi tipe file
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (in_array($_FILES['isi_gambar']['type'], $allowedTypes)) {
                    if (move_uploaded_file($_FILES['isi_gambar']['tmp_name'], $targetPath)) {
                        $isi_gambar = $fileName;
                    }
                }
            }
            
            // Simpan ke database
            $data = [
                'nis' => $nis,
                'id_kategori' => $id_kategori,
                'kelas' => $kelas,
                'isi_text' => $isi_text,
                'isi_gambar' => $isi_gambar,
                'tanggal' => date('Y-m-d')
            ];
            
            $id_pelaporan = $this->inputAspirasiModel->create($data);
            
            if ($id_pelaporan) {
                // Buat record aspirasi dengan status Menunggu
                $this->aspirasiModel->create([
                    'id_pelaporan' => $id_pelaporan,
                    'status' => 'Menunggu',
                    'tanggal' => date('Y-m-d')
                ]);
                
                $_SESSION['success'] = 'Pengaduan berhasil dikirim!';
                header('Location: index.php?page=siswa_histori');
                exit;
            } else {
                $_SESSION['error'] = 'Gagal mengirim pengaduan!';
                header('Location: index.php?page=siswa_create');
                exit;
            }
        }
    }
    
    /**
     * Histori aspirasi siswa
     */
    public function histori() {
        AuthController::checkSiswa();
        
        $nis = $_SESSION['user_id'];
        $aspirasiList = $this->inputAspirasiModel->getByNis($nis);
        
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        
        require_once __DIR__ . '/../views/siswa/histori.php';
    }
    
    /**
     * Detail aspirasi
     */
    public function detail() {
        AuthController::checkSiswa();
        
        $id = $_GET['id'] ?? 0;
        $nis = $_SESSION['user_id'];
        
        $aspirasi = $this->inputAspirasiModel->getById($id);
        
        // Pastikan aspirasi milik siswa yang login
        if (!$aspirasi || $aspirasi['nis'] != $nis) {
            $_SESSION['error'] = 'Aspirasi tidak ditemukan!';
            header('Location: index.php?page=siswa_histori');
            exit;
        }
        
        require_once __DIR__ . '/../views/siswa/detail.php';
    }
}
