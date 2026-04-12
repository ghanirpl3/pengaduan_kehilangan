<?php
/**
 * Fix database - password disimpan plain text sesuai verifyPassword di model
 * HAPUS FILE INI SETELAH SELESAI!
 */

$host = 'sql103.infinityfree.com';
$db_name = 'if0_41606903_pengaduan';
$username = 'if0_41606903';
$password = 'heWvN1LDy0Zfxz';

echo "<h2>Fix Database</h2>";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db_name;charset=utf8mb4", $username, $password, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    ]);
    echo "<p style='color:green'>✅ Koneksi database berhasil!</p>";

    // Drop and recreate
    $pdo->exec("DROP TABLE IF EXISTS aspirasi");
    $pdo->exec("DROP TABLE IF EXISTS input_aspirasi");
    $pdo->exec("DROP TABLE IF EXISTS siswa");
    $pdo->exec("DROP TABLE IF EXISTS kategori");
    $pdo->exec("DROP TABLE IF EXISTS admin");

    $pdo->exec("CREATE TABLE admin (
        id_admin INT PRIMARY KEY AUTO_INCREMENT,
        username VARCHAR(50) NOT NULL UNIQUE,
        password VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE kategori (
        id_kategori INT PRIMARY KEY AUTO_INCREMENT,
        ket_kategori VARCHAR(50) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE siswa (
        nis INT PRIMARY KEY,
        nama_siswa VARCHAR(50) NOT NULL,
        kelas VARCHAR(10) NOT NULL,
        password VARCHAR(255) NOT NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE input_aspirasi (
        id_pelaporan INT PRIMARY KEY AUTO_INCREMENT,
        nis INT NOT NULL,
        id_kategori INT NOT NULL,
        kelas VARCHAR(100) NOT NULL,
        isi_text TEXT NOT NULL,
        isi_gambar VARCHAR(255),
        tanggal DATE NOT NULL,
        FOREIGN KEY (nis) REFERENCES siswa(nis) ON DELETE CASCADE,
        FOREIGN KEY (id_kategori) REFERENCES kategori(id_kategori) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $pdo->exec("CREATE TABLE aspirasi (
        id_aspirasi INT PRIMARY KEY AUTO_INCREMENT,
        id_pelaporan INT NOT NULL,
        status ENUM('Menunggu', 'Proses', 'Selesai') DEFAULT 'Menunggu',
        tanggal DATE NOT NULL,
        id_admin INT,
        feedback TEXT,
        FOREIGN KEY (id_pelaporan) REFERENCES input_aspirasi(id_pelaporan) ON DELETE CASCADE,
        FOREIGN KEY (id_admin) REFERENCES admin(id_admin) ON DELETE SET NULL
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    echo "<p style='color:green'>✅ Tabel berhasil dibuat!</p>";

    // PASSWORD PLAIN TEXT karena verifyPassword pakai === bukan password_verify
    $pdo->exec("INSERT INTO admin (username, password) VALUES ('admin', 'admin123')");
    echo "<p style='color:green'>✅ Admin: username=admin, password=admin123</p>";

    $pdo->exec("INSERT INTO kategori (ket_kategori) VALUES ('Elektronik'), ('Buku/Alat Tulis'), ('Pakaian'), ('Tas/Dompet'), ('Aksesoris'), ('Lainnya')");
    echo "<p style='color:green'>✅ Kategori berhasil!</p>";

    $pdo->exec("INSERT INTO siswa (nis, nama_siswa, kelas, password) VALUES 
        (12001, 'Ahmad Fauzi', 'XII-IPA-1', '12001'),
        (12002, 'Siti Nurhaliza', 'XII-IPA-2', '12002'),
        (12003, 'Budi Santoso', 'XI-IPS-1', '12003')");
    echo "<p style='color:green'>✅ Siswa berhasil!</p>";

    echo "<hr>";
    echo "<h3>🎉 Selesai!</h3>";
    echo "<table border='1' cellpadding='8'>";
    echo "<tr><th>Role</th><th>Username/NIS</th><th>Password</th></tr>";
    echo "<tr><td>Admin</td><td>admin</td><td>admin123</td></tr>";
    echo "<tr><td>Siswa</td><td>12001</td><td>12001</td></tr>";
    echo "<tr><td>Siswa</td><td>12002</td><td>12002</td></tr>";
    echo "<tr><td>Siswa</td><td>12003</td><td>12003</td></tr>";
    echo "</table>";

} catch (PDOException $e) {
    echo "<p style='color:red'>❌ Error: " . $e->getMessage() . "</p>";
}
?>
