<?php
require_once __DIR__ . '/../config/Database.php';

/**
 * Model Admin
 * Mengelola data admin
 */
class Admin {
    private $db;
    private $table = 'admin';
    
    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }
    
    /**
     * Mencari admin berdasarkan username
     * @param string $username
     * @return array|false
     */
    public function findByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch();
    }
    
    /**
     * Mencari admin berdasarkan ID
     * @param int $id
     * @return array|false
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id_admin = :id");
        $stmt->execute(['id' => $id]);
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
     * Mendapatkan semua admin
     * @return array
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT id_admin, username FROM {$this->table}");
        return $stmt->fetchAll();
    }
}
