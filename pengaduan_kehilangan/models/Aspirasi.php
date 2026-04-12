<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Model Aspirasi
 * Mengelola status dan feedback aspirasi
 */
class Aspirasi {
    private $db;
    private $table = 'aspirasi';
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Mendapatkan status berdasarkan id_pelaporan
     * @param int $id_pelaporan
     * @return array|false
     */
    public function getByPelaporan($id_pelaporan) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_pelaporan = :id_pelaporan");
        $stmt->execute(['id_pelaporan' => $id_pelaporan]);
        return $stmt->fetch();
    }
    
    /**
     * Mendapatkan aspirasi berdasarkan ID
     * @param int $id
     * @return array|false
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_aspirasi = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Membuat status aspirasi baru
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (id_pelaporan, status, tanggal, id_admin, feedback) 
                VALUES (:id_pelaporan, :status, :tanggal, :id_admin, :feedback)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id_pelaporan' => $data['id_pelaporan'],
            'status' => $data['status'] ?? 'Menunggu',
            'tanggal' => $data['tanggal'] ?? date('Y-m-d'),
            'id_admin' => $data['id_admin'] ?? null,
            'feedback' => $data['feedback'] ?? null
        ]);
    }
    
    /**
     * Update status dan feedback
     * @param int $id_pelaporan
     * @param string $status
     * @param string $feedback
     * @param int $id_admin
     * @return bool
     */
    public function updateStatus($id_pelaporan, $status, $feedback, $id_admin) {
        // Cek apakah sudah ada record
        $existing = $this->getByPelaporan($id_pelaporan);
        
        if ($existing) {
            // Update existing record
            $sql = "UPDATE {$this->table} SET status = :status, feedback = :feedback, 
                    id_admin = :id_admin, tanggal = :tanggal WHERE id_pelaporan = :id_pelaporan";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'id_pelaporan' => $id_pelaporan,
                'status' => $status,
                'feedback' => $feedback,
                'id_admin' => $id_admin,
                'tanggal' => date('Y-m-d')
            ]);
        } else {
            // Create new record
            return $this->create([
                'id_pelaporan' => $id_pelaporan,
                'status' => $status,
                'feedback' => $feedback,
                'id_admin' => $id_admin
            ]);
        }
    }
    
    /**
     * Mendapatkan histori aspirasi dengan filter
     * @param array $filters
     * @return array
     */
    public function getHistori($filters = []) {
        $sql = "SELECT a.*, ia.isi_text, ia.tanggal as tanggal_lapor, 
                       s.nama_siswa, s.kelas, k.ket_kategori, adm.username as admin_name
                FROM {$this->table} a
                LEFT JOIN input_aspirasi ia ON a.id_pelaporan = ia.id_pelaporan
                LEFT JOIN siswa s ON ia.nis = s.nis
                LEFT JOIN kategori k ON ia.id_kategori = k.id_kategori
                LEFT JOIN admin adm ON a.id_admin = adm.id_admin
                WHERE 1=1";
        
        $params = [];
        
        if (!empty($filters['status'])) {
            $sql .= " AND a.status = :status";
            $params['status'] = $filters['status'];
        }
        
        if (!empty($filters['start_date']) && !empty($filters['end_date'])) {
            $sql .= " AND a.tanggal BETWEEN :start_date AND :end_date";
            $params['start_date'] = $filters['start_date'];
            $params['end_date'] = $filters['end_date'];
        }
        
        $sql .= " ORDER BY a.tanggal DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
    
    /**
     * Menghitung berdasarkan status
     * @param string $status
     * @return int
     */
    public function countByStatus($status) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as total FROM {$this->table} WHERE status = :status");
        $stmt->execute(['status' => $status]);
        $result = $stmt->fetch();
        return $result['total'];
    }
    
    /**
     * Arsipkan aspirasi ke histori
     * @param int $id_pelaporan
     * @param int $id_admin
     * @return bool
     */
    public function archive($id_pelaporan, $id_admin) {
        // Cek apakah sudah ada record
        $existing = $this->getByPelaporan($id_pelaporan);
        
        if ($existing) {
            // Update status menjadi Selesai
            $sql = "UPDATE {$this->table} SET status = 'Selesai', id_admin = :id_admin, tanggal = :tanggal WHERE id_pelaporan = :id_pelaporan";
            $stmt = $this->db->prepare($sql);
            return $stmt->execute([
                'id_pelaporan' => $id_pelaporan,
                'id_admin' => $id_admin,
                'tanggal' => date('Y-m-d')
            ]);
        } else {
            // Create new record dengan status Selesai
            return $this->create([
                'id_pelaporan' => $id_pelaporan,
                'status' => 'Selesai',
                'id_admin' => $id_admin,
                'feedback' => 'Diarsipkan oleh admin'
            ]);
        }
    }
}
