<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Model InputAspirasi
 * Mengelola data pengaduan/aspirasi siswa
 */
class InputAspirasi {
    private $db;
    private $table = 'input_aspirasi';
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Mendapatkan semua aspirasi dengan data siswa dan kategori
     * Tidak termasuk yang sudah diarsipkan (status = Selesai)
     * @return array
     */
    public function getAll() {
        $sql = "SELECT ia.*, s.nama_siswa, k.ket_kategori, 
                       COALESCE(a.status, 'Menunggu') as status,
                       a.feedback, a.id_aspirasi
                FROM {$this->table} ia
                LEFT JOIN siswa s ON ia.nis = s.nis
                LEFT JOIN kategori k ON ia.id_kategori = k.id_kategori
                LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                WHERE a.status IS NULL OR a.status != 'Selesai'
                ORDER BY ia.tanggal DESC";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll();
    }
    
    /**
     * Mendapatkan aspirasi berdasarkan NIS siswa
     * @param int $nis
     * @return array
     */
    public function getByNis($nis) {
        $sql = "SELECT ia.*, s.nama_siswa, k.ket_kategori,
                       COALESCE(a.status, 'Menunggu') as status,
                       a.feedback, a.id_aspirasi
                FROM {$this->table} ia
                LEFT JOIN siswa s ON ia.nis = s.nis
                LEFT JOIN kategori k ON ia.id_kategori = k.id_kategori
                LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                WHERE ia.nis = :nis
                ORDER BY ia.tanggal DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['nis' => $nis]);
        return $stmt->fetchAll();
    }
    
    /**
     * Mendapatkan aspirasi berdasarkan ID
     * @param int $id
     * @return array|false
     */
    public function getById($id) {
        $sql = "SELECT ia.*, s.nama_siswa, k.ket_kategori,
                       COALESCE(a.status, 'Menunggu') as status,
                       a.feedback, a.id_aspirasi, a.id_admin
                FROM {$this->table} ia
                LEFT JOIN siswa s ON ia.nis = s.nis
                LEFT JOIN kategori k ON ia.id_kategori = k.id_kategori
                LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                WHERE ia.id_pelaporan = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Membuat aspirasi baru
     * @param array $data
     * @return int|false ID aspirasi yang dibuat atau false jika gagal
     */
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (nis, id_kategori, kelas, isi_text, isi_gambar, tanggal) 
                VALUES (:nis, :id_kategori, :kelas, :isi_text, :isi_gambar, :tanggal)";
        $stmt = $this->db->prepare($sql);
        $result = $stmt->execute([
            'nis' => $data['nis'],
            'id_kategori' => $data['id_kategori'],
            'kelas' => $data['kelas'],
            'isi_text' => $data['isi_text'],
            'isi_gambar' => $data['isi_gambar'] ?? null,
            'tanggal' => $data['tanggal'] ?? date('Y-m-d')
        ]);
        
        if ($result) {
            return $this->db->lastInsertId();
        }
        return false;
    }
    
    /**
     * Filter aspirasi berdasarkan tanggal
     * @param string $startDate
     * @param string $endDate
     * @return array
     */
    public function filterByDate($startDate, $endDate) {
        $sql = "SELECT ia.*, s.nama_siswa, k.ket_kategori,
                       COALESCE(a.status, 'Menunggu') as status,
                       a.feedback, a.id_aspirasi
                FROM {$this->table} ia
                LEFT JOIN siswa s ON ia.nis = s.nis
                LEFT JOIN kategori k ON ia.id_kategori = k.id_kategori
                LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                WHERE ia.tanggal BETWEEN :start_date AND :end_date
                AND (a.status IS NULL OR a.status != 'Selesai')
                ORDER BY ia.tanggal DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['start_date' => $startDate, 'end_date' => $endDate]);
        return $stmt->fetchAll();
    }
    
    /**
     * Filter aspirasi berdasarkan kategori
     * @param int $id_kategori
     * @return array
     */
    public function filterByKategori($id_kategori) {
        $sql = "SELECT ia.*, s.nama_siswa, k.ket_kategori,
                       COALESCE(a.status, 'Menunggu') as status,
                       a.feedback, a.id_aspirasi
                FROM {$this->table} ia
                LEFT JOIN siswa s ON ia.nis = s.nis
                LEFT JOIN kategori k ON ia.id_kategori = k.id_kategori
                LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                WHERE ia.id_kategori = :id_kategori
                AND (a.status IS NULL OR a.status != 'Selesai')
                ORDER BY ia.tanggal DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id_kategori' => $id_kategori]);
        return $stmt->fetchAll();
    }
    
    /**
     * Filter aspirasi berdasarkan status
     * @param string $status
     * @return array
     */
    public function filterByStatus($status) {
        // Jika filter Selesai, tidak tampilkan apapun karena sudah diarsip
        if ($status === 'Selesai') {
            return [];
        }
        
        $sql = "SELECT ia.*, s.nama_siswa, k.ket_kategori,
                       COALESCE(a.status, 'Menunggu') as status,
                       a.feedback, a.id_aspirasi
                FROM {$this->table} ia
                LEFT JOIN siswa s ON ia.nis = s.nis
                LEFT JOIN kategori k ON ia.id_kategori = k.id_kategori
                LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                WHERE (a.status = :status1 OR (a.status IS NULL AND :status2 = 'Menunggu'))
                AND (a.status IS NULL OR a.status != 'Selesai')
                ORDER BY ia.tanggal DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['status1' => $status, 'status2' => $status]);
        return $stmt->fetchAll();
    }
    
    /**
     * Menghitung total aspirasi
     * @return int
     */
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    /**
     * Menghitung aspirasi berdasarkan status
     * @param string $status
     * @return int
     */
    public function countByStatus($status) {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} ia
                LEFT JOIN aspirasi a ON ia.id_pelaporan = a.id_pelaporan
                WHERE a.status = :status1 OR (a.status IS NULL AND :status2 = 'Menunggu')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['status1' => $status, 'status2' => $status]);
        $result = $stmt->fetch();
        return $result['total'];
    }
}
