<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Default user demo jika belum login
if (!isset($_SESSION['user'])) {
    $_SESSION['user'] = [
        'name' => 'Budi Santoso',
        'role' => 'Admin Gudang',
        'email' => 'budi.santoso@katalogapp.id',
        'avatar' => 'assets/images/avatar-user.jpg',
        'isLoggedIn' => true
    ];
}
$currentUser = $_SESSION['user'];
$currentPage = basename($_SERVER['PHP_SELF']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= defined('APP_NAME') ? APP_NAME : 'Product Information System' ?></title>
    <!-- Google Fonts: Plus Jakarta Sans -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Fira+Code:wght@400;500&display=swap" rel="stylesheet">
    <!-- Main Design System Stylesheet -->
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Top Modern Sticky Navigation Bar -->
    <header class="navbar-header">
        <div class="app-container">
            <div class="nav-inner">
                <!-- Brand Identity -->
                <a href="index.php" class="brand-logo" title="KatalogApp Home">
                    <div class="brand-icon">⚡</div>
                    <div class="brand-text-wrap">
                        <span class="brand-title">KatalogApp</span>
                        <span class="brand-subtitle">Product Information System</span>
                    </div>
                </a>

                <!-- Global Quick Search -->
                <div class="nav-search-bar">
                    <span class="nav-search-icon">🔍</span>
                    <input type="text" id="catalogSearchInput" class="nav-search-input" placeholder="Cari laptop, kemeja, sofa, headphone..." autocomplete="off">
                    <span class="nav-search-shortcut">/</span>
                </div>

                <!-- Navigation Links -->
                <nav>
                    <ul class="nav-links">
                        <li>
                            <a href="index.php" class="nav-link-item <?= ($currentPage === 'index.php') ? 'active' : '' ?>">
                                <span>🛍️</span> Katalog
                            </a>
                        </li>
                        <li>
                            <a href="admin.php" class="nav-link-item <?= ($currentPage === 'admin.php') ? 'active' : '' ?>">
                                <span>📊</span> Inventaris Gudang
                            </a>
                        </li>
                        <li>
                            <a href="checkout.php" class="nav-link-item <?= ($currentPage === 'checkout.php') ? 'active' : '' ?>">
                                <span>💳</span> Checkout
                            </a>
                        </li>
                    </ul>
                </nav>

                <!-- Actions: Cart & Profile -->
                <div class="nav-actions">
                    <!-- Cart Button with Counter -->
                    <button type="button" class="cart-btn-trigger" id="cartOpenTrigger" aria-label="Buka Keranjang">
                        <span>🛒</span>
                        <span class="cart-badge-count" style="display: none;">0</span>
                    </button>

                    <!-- User Account / Profile -->
                    <?php if (!empty($currentUser['isLoggedIn'])): ?>
                        <a href="profile.php" class="user-profile-btn" title="Profil Pengguna">
                            <img src="<?= htmlspecialchars($currentUser['avatar']) ?>" alt="Avatar" class="user-avatar-img">
                            <span class="user-name-text"><?= htmlspecialchars($currentUser['name']) ?></span>
                        </a>
                    <?php else: ?>
                        <a href="login.php" class="btn btn-primary btn-sm">Masuk</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content Container -->
    <main class="main-content">
        <div class="app-container">
