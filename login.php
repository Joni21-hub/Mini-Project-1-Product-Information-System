<?php
require_once 'config.php';
require_once 'functions.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$loginError = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? 'login';
    
    if ($action === 'demo_admin') {
        $_SESSION['user'] = [
            'name' => 'Budi Santoso',
            'role' => 'Admin Gudang',
            'email' => 'budi.santoso@katalogapp.id',
            'avatar' => 'assets/images/avatar-user.jpg',
            'isLoggedIn' => true
        ];
        header("Location: admin.php");
        exit;
    } elseif ($action === 'demo_customer') {
        $_SESSION['user'] = [
            'name' => 'Siti Rahma',
            'role' => 'Customer VIP',
            'email' => 'siti.rahma@gmail.com',
            'avatar' => 'assets/images/avatar-user.jpg',
            'isLoggedIn' => true
        ];
        header("Location: index.php");
        exit;
    } elseif ($action === 'standard_login') {
        $email = trim($_POST['email'] ?? '');
        $pass = trim($_POST['password'] ?? '');
        
        if (!empty($email) && !empty($pass)) {
            $_SESSION['user'] = [
                'name' => explode('@', $email)[0],
                'role' => 'Pengguna Terdaftar',
                'email' => $email,
                'avatar' => 'assets/images/avatar-user.jpg',
                'isLoggedIn' => true
            ];
            header("Location: profile.php");
            exit;
        } else {
            $loginError = 'Harap isi email dan password dengan benar.';
        }
    }
}

include 'layout_header.php';
?>

<div style="max-width: 960px; margin: 30px auto; display: grid; grid-template-columns: 1fr 1fr; background: #ffffff; border-radius: var(--radius-xl); border: 1px solid var(--slate-200); box-shadow: var(--shadow-xl); overflow: hidden;">
    
    <!-- LEFT PANEL: Brand & Feature Highlights -->
    <div style="background: var(--grad-dark); color: #ffffff; padding: 48px; display: flex; flex-direction: column; justify-content: space-between; position: relative;">
        <div style="position: relative; z-index: 2;">
            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 24px;">
                <div style="width: 44px; height: 44px; border-radius: 12px; background: var(--grad-primary); display: flex; align-items: center; justify-content: center; font-size: 1.3rem;">⚡</div>
                <div>
                    <h2 style="font-size: 1.4rem; color: #fff; margin: 0;">KatalogApp</h2>
                    <div style="font-size: 0.75rem; color: #94a3b8; text-transform: uppercase; letter-spacing: 0.05em;">Enterprise Portal</div>
                </div>
            </div>

            <h3 style="font-size: 1.8rem; line-height: 1.25; margin-bottom: 16px; color: #f8fafc;">
                Akses Terpadu <span class="gradient-text">Logistik &amp; Belanja</span>
            </h3>

            <p style="color: #94a3b8; font-size: 0.92rem; line-height: 1.6; margin-bottom: 24px;">
                Masuk untuk mengelola master data produk komoditas, audit status stok kritis, dan checkout pesanan dengan faktur pajak PPN 11% otomatis.
            </p>

            <div style="display: flex; flex-direction: column; gap: 12px;">
                <div style="display: flex; align-items: center; gap: 10px; font-size: 0.85rem; color: #cbd5e1;">
                    <span style="color: #10b981;">✓</span> Otomasi kalkulasi pajak PPN 11%
                </div>
                <div style="display: flex; align-items: center; gap: 10px; font-size: 0.85rem; color: #cbd5e1;">
                    <span style="color: #10b981;">✓</span> Deteksi ambang batas stok kritis &amp; habis
                </div>
                <div style="display: flex; align-items: center; gap: 10px; font-size: 0.85rem; color: #cbd5e1;">
                    <span style="color: #10b981;">✓</span> Integrasi keranjang &amp; simulasi faktur
                </div>
            </div>
        </div>

        <div style="margin-top: 36px; padding-top: 20px; border-top: 1px solid rgba(255,255,255,0.1); font-size: 0.78rem; color: #64748b;">
            Versi Platform 2.0 &bull; PHP Fundamental Mini Project
        </div>
    </div>

    <!-- RIGHT PANEL: Login Form & One-click Demo -->
    <div style="padding: 48px;">
        <h3 style="font-size: 1.6rem; margin-bottom: 6px;">Selamat Datang</h3>
        <p style="color: var(--slate-500); font-size: 0.88rem; margin-bottom: 24px;">
            Pilih metode login akun demo cepat atau masukkan kredensial Anda.
        </p>

        <!-- Fast Demo Buttons -->
        <div style="background: var(--slate-50); border: 1px solid var(--slate-200); border-radius: var(--radius-lg); padding: 16px; margin-bottom: 24px;">
            <div style="font-size: 0.8rem; font-weight: 700; color: var(--slate-600); margin-bottom: 10px; text-transform: uppercase;">
                ⚡ 1-Click Login Akun Demo:
            </div>
            <div style="display: flex; flex-direction: column; gap: 8px;">
                <form method="POST">
                    <input type="hidden" name="action" value="demo_admin">
                    <button type="submit" class="btn btn-secondary btn-block btn-sm" style="justify-content: flex-start; text-align: left; padding: 10px 14px;">
                        <span>👨‍💼</span>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: var(--slate-900);">Budi Santoso</div>
                            <div style="font-size: 0.72rem; color: var(--slate-500);">Akses Admin Gudang &amp; Inventaris</div>
                        </div>
                        <span style="color: var(--primary-600); font-size: 0.8rem;">Pilih ➔</span>
                    </button>
                </form>

                <form method="POST">
                    <input type="hidden" name="action" value="demo_customer">
                    <button type="submit" class="btn btn-secondary btn-block btn-sm" style="justify-content: flex-start; text-align: left; padding: 10px 14px;">
                        <span>👩‍💼</span>
                        <div style="flex: 1;">
                            <div style="font-weight: 700; color: var(--slate-900);">Siti Rahma</div>
                            <div style="font-size: 0.72rem; color: var(--slate-500);">Akses Customer VIP Marketplace</div>
                        </div>
                        <span style="color: var(--primary-600); font-size: 0.8rem;">Pilih ➔</span>
                    </button>
                </form>
            </div>
        </div>

        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 20px;">
            <div style="flex: 1; height: 1px; background: var(--slate-200);"></div>
            <span style="font-size: 0.75rem; color: var(--slate-400); text-transform: uppercase;">Atau login manual</span>
            <div style="flex: 1; height: 1px; background: var(--slate-200);"></div>
        </div>

        <?php if (!empty($loginError)): ?>
            <div style="background: #fef2f2; border: 1px solid #fecaca; color: #dc2626; padding: 10px 14px; border-radius: var(--radius-md); font-size: 0.85rem; margin-bottom: 16px;">
                <?= htmlspecialchars($loginError) ?>
            </div>
        <?php endif; ?>

        <!-- Form Login Regular -->
        <form method="POST">
            <input type="hidden" name="action" value="standard_login">
            <div class="form-group">
                <label class="form-label" for="loginEmail">Email Perusahaan / Pengguna</label>
                <input type="email" id="loginEmail" name="email" class="form-control" placeholder="nama@email.com" value="user@katalogapp.id" required>
            </div>

            <div class="form-group">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                    <label class="form-label" for="loginPassword" style="margin: 0;">Password</label>
                    <a href="#" onclick="alert('Gunakan tombol 1-Click Demo Login di atas untuk akses cepat!'); return false;" style="font-size: 0.75rem;">Lupa password?</a>
                </div>
                <input type="password" id="loginPassword" name="password" class="form-control" placeholder="••••••••" value="password123" required>
            </div>

            <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 20px;">
                <input type="checkbox" id="rememberMe" checked>
                <label for="rememberMe" style="font-size: 0.82rem; color: var(--slate-600);">Ingat saya pada perangkat ini</label>
            </div>

            <button type="submit" class="btn btn-primary btn-block btn-lg">
                <span>Masuk ke Akun</span>
                <span>➔</span>
            </button>
        </form>
    </div>
</div>

<?php
include 'layout_footer.php';
?>
