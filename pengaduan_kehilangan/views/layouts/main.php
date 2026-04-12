<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $pageTitle ?? 'Sistem Pengaduan' ?> - Pengaduan Kehilangan</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="layout">
        <!-- Sidebar -->
        <aside class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-logo">
                    <div class="sidebar-logo-icon">
                        <i class="fas fa-search"></i>
                    </div>
                    <span class="sidebar-logo-text">Pengaduan</span>
                </div>
            </div>
            
            <nav class="sidebar-nav">
                <?php if ($role === 'admin'): ?>
                <div class="nav-section">
                    <div class="nav-section-title">Menu Utama</div>
                    <a href="index.php?page=admin_dashboard" class="nav-link <?= $activePage === 'dashboard' ? 'active' : '' ?>">
                        <span class="nav-link-icon"><i class="fas fa-home"></i></span>
                        <span>Dashboard</span>
                    </a>
                    <a href="index.php?page=admin_aspirasi" class="nav-link <?= $activePage === 'aspirasi' ? 'active' : '' ?>">
                        <span class="nav-link-icon"><i class="fas fa-list"></i></span>
                        <span>List Aspirasi</span>
                    </a>
                    <a href="index.php?page=admin_histori" class="nav-link <?= $activePage === 'histori' ? 'active' : '' ?>">
                        <span class="nav-link-icon"><i class="fas fa-history"></i></span>
                        <span>Histori</span>
                    </a>
                </div>
                <div class="nav-section">
                    <div class="nav-section-title">Pengaturan</div>
                    <a href="index.php?page=admin_kategori" class="nav-link <?= $activePage === 'kategori' ? 'active' : '' ?>">
                        <span class="nav-link-icon"><i class="fas fa-tags"></i></span>
                        <span>Kategori</span>
                    </a>
                </div>
                <?php else: ?>
                <div class="nav-section">
                    <div class="nav-section-title">Menu Utama</div>
                    <a href="index.php?page=siswa_dashboard" class="nav-link <?= $activePage === 'dashboard' ? 'active' : '' ?>">
                        <span class="nav-link-icon"><i class="fas fa-home"></i></span>
                        <span>Dashboard</span>
                    </a>
                    <a href="index.php?page=siswa_create" class="nav-link <?= $activePage === 'create' ? 'active' : '' ?>">
                        <span class="nav-link-icon"><i class="fas fa-plus-circle"></i></span>
                        <span>Buat Pengaduan</span>
                    </a>
                    <a href="index.php?page=siswa_histori" class="nav-link <?= $activePage === 'histori' ? 'active' : '' ?>">
                        <span class="nav-link-icon"><i class="fas fa-history"></i></span>
                        <span>Histori</span>
                    </a>
                </div>
                <?php endif; ?>
                
                <div class="nav-section">
                    <div class="nav-section-title">Akun</div>
                    <a href="index.php?page=logout" class="nav-link">
                        <span class="nav-link-icon"><i class="fas fa-sign-out-alt"></i></span>
                        <span>Logout</span>
                    </a>
                </div>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="main-content">
            <!-- Header -->
            <header class="header">
                <h1 class="header-title"><?= $pageTitle ?? 'Dashboard' ?></h1>
                <div class="header-user">
                    <div class="user-info">
                        <div class="user-name"><?= htmlspecialchars($_SESSION['username'] ?? $_SESSION['nama'] ?? 'User') ?></div>
                        <div class="user-role"><?= ucfirst($_SESSION['role'] ?? 'Guest') ?></div>
                    </div>
                    <div class="user-avatar">
                        <?= strtoupper(substr($_SESSION['username'] ?? $_SESSION['nama'] ?? 'U', 0, 1)) ?>
                    </div>
                </div>
            </header>
            
            <!-- Content -->
            <div class="content">
                <?= $content ?? '' ?>
            </div>
        </main>
    </div>
    
    <script src="assets/js/script.js"></script>
</body>
</html>
