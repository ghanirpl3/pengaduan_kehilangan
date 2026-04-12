<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Siswa - Pengaduan Kehilangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="login-container">
        <div class="login-card">
            <div class="login-header">
                <div class="login-logo">
                    <i class="fas fa-user-graduate"></i>
                </div>
                <h1 class="login-title">Login Siswa</h1>
                <p class="login-subtitle">Masuk untuk melihat pengaduan Anda</p>
            </div>
            
            <?php if (!empty($error)): ?>
            <div class="alert alert-error">
                <i class="fas fa-exclamation-circle"></i>
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
            
            <form action="index.php?page=login_siswa_process" method="POST">
                <div class="form-group">
                    <label class="form-label" for="nis">NIS (Nomor Induk Siswa)</label>
                    <input type="text" id="nis" name="nis" class="form-control" placeholder="Masukkan NIS Anda" required>
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Masukkan password" required>
                </div>
                
                <button type="submit" class="btn btn-primary" style="width: 100%;">
                    <i class="fas fa-sign-in-alt"></i>
                    Login
                </button>
            </form>
            
            <div class="login-footer">
                <p>Login sebagai admin? <a href="index.php?page=login_admin">Klik di sini</a></p>
                <p class="mt-2"><a href="index.php">← Kembali ke Beranda</a></p>
            </div>
        </div>
    </div>
</body>
</html>
