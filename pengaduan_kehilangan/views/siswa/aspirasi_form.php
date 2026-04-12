<?php
$pageTitle = 'Buat Pengaduan';
$activePage = 'create';
$role = 'siswa';

ob_start();
?>

<div class="mb-3">
    <a href="index.php?page=siswa_dashboard" class="btn btn-outline">
        <i class="fas fa-arrow-left"></i> Kembali
    </a>
</div>

<?php if (!empty($error)): ?>
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-plus-circle"></i> Form Pengaduan Kehilangan
        </h3>
    </div>
    <div class="card-body">
        <form action="index.php?page=siswa_store" method="POST" enctype="multipart/form-data">
            <div class="detail-grid">
                <div>
                    <div class="form-group">
                        <label class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['nama']) ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Kelas</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['kelas']) ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">NIS</label>
                        <input type="text" class="form-control" value="<?= htmlspecialchars($_SESSION['user_id']) ?>" disabled>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Kategori Barang <span class="text-danger">*</span></label>
                        <select name="id_kategori" class="form-control form-select" required>
                            <option value="">-- Pilih Kategori --</option>
                            <?php foreach ($kategoriList as $kat): ?>
                            <option value="<?= $kat['id_kategori'] ?>"><?= htmlspecialchars($kat['ket_kategori']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
                
                <div>
                    <div class="form-group">
                        <label class="form-label">Deskripsi Kehilangan <span class="text-danger">*</span></label>
                        <textarea name="isi_text" class="form-control" rows="6" placeholder="Jelaskan barang yang hilang, ciri-ciri, kapan hilang, dll..." required></textarea>
                        <small class="text-muted">Jelaskan secara detail barang yang hilang</small>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Upload Gambar (Opsional)</label>
                        <input type="file" name="isi_gambar" class="form-control" accept="image/*">
                        <small class="text-muted">Format: JPG, PNG, GIF. Maksimal 2MB</small>
                    </div>
                </div>
            </div>
            
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i>
                <div>
                    <strong>Perhatian!</strong><br>
                    Pastikan informasi yang Anda berikan akurat dan lengkap agar pengaduan dapat diproses dengan baik.
                </div>
            </div>
            
            <div class="mt-4">
                <button type="submit" class="btn btn-lg btn-success">
                    <i class="fas fa-paper-plane"></i> Kirim Pengaduan
                </button>
                <a href="index.php?page=siswa_dashboard" class="btn btn-lg btn-outline">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
