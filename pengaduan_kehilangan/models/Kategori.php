<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Model Kategori
 * Mengelola data kategori barang
 */
class Kategori {
    private $db;
    private $table = 'kategori';
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Mendapatkan semua kategori
     * @return array
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM {$this->table} ORDER BY ket_kategori ASC");
        return $stmt->fetchAll();
    }
    
    /**
     * Mendapatkan kategori berdasarkan ID
     * @param int $id
     * @return array|false
     */
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_kategori = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
    
    /**
     * Menambah kategori baru
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (ket_kategori) VALUES (:ket_kategori)");
        return $stmt->execute(['ket_kategori' => $data['ket_kategori']]);
    }
    
    /**
     * Update kategori
     * @param int $id
     * @param array $data
     * @return bool
     */
    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET ket_kategori = :ket_kategori WHERE id_kategori = :id");
        return $stmt->execute([
            'id' => $id,
            'ket_kategori' => $data['ket_kategori']
        ]);
    }
    
    /**
     * Hapus kategori
     * @param int $id
     * @return bool
     */
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id_kategori = :id");
        return $stmt->execute(['id' => $id]);
    }
    
    /**
     * Menghitung total kategori
     * @return int
     */
    public function count() {
        $stmt = $this->db->query("SELECT COUNT(*) as total FROM {$this->table}");
        $result = $stmt->fetch();
        return $result['total'];
    }
}
