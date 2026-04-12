<?php
/**
 * Database Connection Class
 * Menggunakan PDO dengan pattern Singleton
 */

class Database {
    private static $instance = null;
    private $connection;
    
    // Konfigurasi Database
    private $host = 'sql103.infinityfree.com';
    private $db_name = 'if0_41606903_pengaduan';
    private $username = 'if0_41606903';
    private $password = 'heWvN1LDy0Zfxz';
    private $charset = 'utf8mb4';
    
    /**
     * Constructor - Private untuk mencegah instansiasi langsung
     */
    private function __construct() {
        try {
            $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            
            $this->connection = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            die("Koneksi database gagal: " . $e->getMessage());
        }
    }
    
    /**
     * Mendapatkan instance Database (Singleton)
     * @return Database
     */
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Mendapatkan koneksi PDO
     * @return PDO
     */
    public function getConnection() {
        return $this->connection;
    }
    
    /**
     * Mencegah cloning
     */
    private function __clone() {}
    
    /**
     * Mencegah unserialize
     */
    public function __wakeup() {
        throw new Exception("Cannot unserialize singleton");
    }
}
