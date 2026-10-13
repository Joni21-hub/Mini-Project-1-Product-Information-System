        </div> <!-- End of .app-container -->
    </main> <!-- End of .main-content -->

    <!-- World-Class Marketplace Footer -->
    <footer class="site-footer">
        <div class="app-container">
            <div class="footer-top-grid">
                <!-- Col 1: Brand & Overview -->
                <div>
                    <div style="display: flex; align-items: center; gap: 10px; margin-bottom: 16px;">
                        <div style="width: 36px; height: 36px; border-radius: 10px; background: var(--grad-primary); display: flex; align-items: center; justify-content: center; color: #fff; font-size: 1.1rem; font-weight: bold;">⚡</div>
                        <span style="color: #fff; font-size: 1.2rem; font-weight: 800;"><?= defined('APP_NAME') ? APP_NAME : 'KatalogApp' ?></span>
                    </div>
                    <p style="font-size: 0.88rem; line-height: 1.6; margin-bottom: 18px; color: #94a3b8;">
                        Sistem manajemen informasi produk, inventaris gudang komoditas, dan etalase marketplace komersial generasi masa depan dengan kalkulasi otomatis PPN 11% & diskon dinamis.
                    </p>
                    <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                        <span class="tag-chip" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); color: #cbd5e1;">PHP 8.2 Native</span>
                        <span class="tag-chip" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); color: #cbd5e1;">SoC Architecture</span>
                        <span class="tag-chip" style="background: rgba(255,255,255,0.08); border-color: rgba(255,255,255,0.15); color: #cbd5e1;">PPN 11% Compliant</span>
                    </div>
                </div>

                <!-- Col 2: Navigation Links -->
                <div>
                    <h4 class="footer-col-title">Navigasi Utama</h4>
                    <ul class="footer-links-list">
                        <li><a href="index.php">🛍️ Etalase Produk</a></li>
                        <li><a href="admin.php">📊 Manajemen Inventaris</a></li>
                        <li><a href="checkout.php">💳 Checkout & Faktur</a></li>
                        <li><a href="profile.php">👤 Profil & Akun Pengguna</a></li>
                        <li><a href="index.php?debug=1">🛠️ Mode Inspeksi Debug (var_dump)</a></li>
                    </ul>
                </div>

                <!-- Col 3: Categories -->
                <div>
                    <h4 class="footer-col-title">Kategori Unggulan</h4>
                    <ul class="footer-links-list">
                        <li><a href="index.php#tech">💻 Komputer & Gadget (Tech)</a></li>
                        <li><a href="index.php#apparel">👕 Pakaian & Busana (Apparel)</a></li>
                        <li><a href="index.php#home">🏠 Perlengkapan Rumah (Home)</a></li>
                        <li><a href="index.php#accessories">⌚ Jam Tangan & Aksesoris</a></li>
                    </ul>
                </div>

                <!-- Col 4: Keamanan & Garansi -->
                <div>
                    <h4 class="footer-col-title">Jaminan Belanja</h4>
                    <ul class="footer-links-list">
                        <li><span style="color: #cbd5e1;">🔒 Pembayaran Aman & Terverifikasi</span></li>
                        <li><span style="color: #cbd5e1;">📦 100% Produk Original Bergaransi</span></li>
                        <li><span style="color: #cbd5e1;">⚡ Pengiriman Ekspres Seluruh Indonesia</span></li>
                        <li><span style="color: #cbd5e1;">📄 Faktur Pajak Resmi Terbit Otomatis</span></li>
                    </ul>
                </div>
            </div>

            <!-- Footer Bottom Note -->
            <div class="footer-bottom-bar">
                <div>
                    &copy; <?= date("Y") ?> <strong><?= defined('APP_NAME') ? APP_NAME : 'Product Information System' ?></strong>. Hak Cipta Dilindungi Undang-Undang.
                </div>
                <div style="color: #64748b; font-size: 0.82rem;">
                    Dibuat untuk <em>Pemrograman Web Pertemuan 2: PHP Fundamental & Data Structure - Mini Project 1</em>.
                </div>
            </div>
        </div>
    </footer>

    <!-- SLIDE-OVER SHOPPING CART DRAWER -->
    <div class="cart-drawer-backdrop" id="cartDrawerBackdrop">
        <aside class="cart-drawer-panel" aria-label="Keranjang Belanja">
            <div class="cart-drawer-header">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span style="font-size: 1.3rem;">🛒</span>
                    <h3 style="font-size: 1.15rem; font-weight: 800; margin: 0;">Keranjang Belanja</h3>
                </div>
                <button type="button" id="closeCartDrawerBtn" class="modal-close-btn" style="position: static;" aria-label="Tutup Keranjang">&times;</button>
            </div>
            
            <div class="cart-drawer-body" id="cartDrawerList">
                <!-- Dynamically populated by app.js -->
            </div>

            <div class="cart-drawer-footer">
                <div class="cart-subtotal-row">
                    <span>Subtotal Produk:</span>
                    <strong id="cartSubtotalAmount">Rp 0</strong>
                </div>
                <div class="cart-subtotal-row">
                    <span>PPN (11%):</span>
                    <strong id="cartPpnAmount">Rp 0</strong>
                </div>
                <div class="cart-total-row">
                    <span>Total Pembayaran:</span>
                    <strong id="cartGrandTotalAmount" style="color: var(--primary-600);">Rp 0</strong>
                </div>
                <a href="checkout.php" class="btn btn-primary btn-block btn-lg" style="margin-top: 10px;">
                    <span>Lanjut ke Pembayaran</span>
                    <span>➔</span>
                </a>
            </div>
        </aside>
    </div>

    <!-- QUICK VIEW MODAL -->
    <div class="modal-backdrop" id="quickViewModal">
        <div class="modal-dialog">
            <button type="button" class="modal-close-btn" id="closeQuickViewBtn">&times;</button>
            <div class="modal-body">
                <div style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 28px; align-items: start;">
                    <!-- Modal Product Image -->
                    <div style="border-radius: var(--radius-lg); overflow: hidden; background: var(--slate-100); border: 1px solid var(--slate-200);">
                        <img id="qvModalImage" src="" alt="Pratinjau Produk" style="width: 100%; height: 320px; object-fit: cover;">
                    </div>
                    <!-- Modal Details -->
                    <div>
                        <div style="display: flex; gap: 8px; margin-bottom: 12px; align-items: center;">
                            <span id="qvModalCategory"></span>
                            <span id="qvModalStock"></span>
                        </div>
                        <h2 id="qvModalTitle" style="font-size: 1.5rem; margin-bottom: 12px; line-height: 1.3;"></h2>
                        
                        <div style="background: var(--slate-50); border: 1px solid var(--slate-200); padding: 14px 18px; border-radius: var(--radius-md); margin-bottom: 16px;">
                            <div style="font-size: 0.82rem; color: var(--slate-400); text-decoration: line-through; margin-bottom: 2px;">
                                Harga Normal: <span id="qvModalPriceOriginal"></span>
                            </div>
                            <div style="display: flex; align-items: baseline; gap: 10px;">
                                <div id="qvModalPriceFinal" style="font-size: 1.7rem; font-weight: 800; color: var(--primary-700);"></div>
                                <span class="discount-badge-tag">Diskon 5% + PPN 11%</span>
                            </div>
                        </div>

                        <p id="qvModalDesc" style="color: var(--slate-600); font-size: 0.92rem; line-height: 1.6; margin-bottom: 16px;"></p>
                        
                        <div style="margin-bottom: 14px;">
                            <div style="font-size: 0.78rem; font-weight: 700; color: var(--slate-400); text-transform: uppercase; margin-bottom: 6px;">Tags Terkait</div>
                            <div id="qvModalTags"></div>
                        </div>

                        <div id="qvModalWarehouseNote" style="font-size: 0.82rem; background: #fffbeb; border: 1px solid #fde68a; color: #92400e; padding: 10px 14px; border-radius: var(--radius-md); margin-bottom: 20px;"></div>

                        <div style="display: flex; gap: 12px;">
                            <button type="button" id="qvModalAddCartBtn" class="btn btn-primary btn-lg js-add-to-cart" style="flex: 1;">
                                <span>🛒 Tambah ke Keranjang</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Interactive Toast Container -->
    <div class="toast-container"></div>

    <!-- Client-side Application Scripts -->
    <script src="assets/js/app.js"></script>
</body>
</html>
