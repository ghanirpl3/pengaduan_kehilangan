<?php
$pageTitle = 'Kelola Kategori';
$activePage = 'kategori';
$role = 'admin';

ob_start();
?>

<?php if (!empty($success)): ?>
<div class="alert alert-success">
    <i class="fas fa-check-circle"></i>
    <?= htmlspecialchars($success) ?>
</div>
<?php endif; ?>

<?php if (!empty($error)): ?>
<div class="alert alert-error">
    <i class="fas fa-exclamation-circle"></i>
    <?= htmlspecialchars($error) ?>
</div>
<?php endif; ?>

<div class="detail-grid">
    <!-- Form Tambah Kategori -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-plus-circle"></i> Tambah Kategori
            </h3>
        </div>
        <div class="card-body">
            <form action="index.php?page=admin_add_kategori" method="POST">
                <div class="form-group">
                    <label class="form-label">Nama Kategori</label>
                    <input type="text" name="ket_kategori" class="form-control" placeholder="Contoh: Elektronik" required>
                </div>
                
                <button type="submit" class="btn btn-success" style="width: 100%;">
                    <i class="fas fa-save"></i> Simpan
                </button>
            </form>
        </div>
    </div>
    
    <!-- Daftar Kategori -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-tags"></i> Daftar Kategori
                <span class="text-muted text-sm">(<?= count($kategoriList) ?> data)</span>
            </h3>
        </div>
        <div class="card-body">
            <?php if (empty($kategoriList)): ?>
            <div class="empty-state">
                <div class="empty-state-icon"><i class="fas fa-tags"></i></div>
                <div class="empty-state-title">Belum Ada Kategori</div>
                <div class="empty-state-desc">Tambahkan kategori pertama.</div>
            </div>
            <?php else: ?>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Kategori</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $no = 1; foreach ($kategoriList as $kat): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><strong><?= htmlspecialchars($kat['ket_kategori']) ?></strong></td>
                            <td>
                                <a href="index.php?page=admin_delete_kategori&id=<?= $kat['id_kategori'] ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/main.php';
?>
