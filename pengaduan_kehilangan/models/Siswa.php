<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Model Siswa
 * Mengelola data siswa
 */
class Siswa {
    private $db;
    private $table = 'siswa';
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Mencari siswa berdasarkan NIS
     * @param int $nis
     * @return array|false
     */
    public function findByNis($nis) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE nis = :nis");
        $stmt->execute(['nis' => $nis]);
        return $stmt->fetch();
    }
    
    /**
     * Verifikasi password
     * @param string $password
     * @param string $hash
     * @return bool
     */
    public function verifyPassword($password, $storedPassword) {
        return $password === $storedPassword;
    }
    
    /**
     * Mendapatkan semua siswa
     * @return array
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT nis, nama_siswa, kelas FROM {$this->table} ORDER BY nama_siswa ASC");
        return $stmt->fetchAll();
    }
    
    /**
     * Menambah siswa baru
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (nis, nama_siswa, kelas, password) VALUES (:nis, :nama_siswa, :kelas, :password)");
        return $stmt->execute([
            'nis' => $data['nis'],
            'nama_siswa' => $data['nama_siswa'],
            'kelas' => $data['kelas'],
            'password' => $data['password']
        ]);
    }
    
    /**
     * Menghitung total siswa
     * @return int
     */
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $stmt->fetch();
        return $result['total'];
    }
}
