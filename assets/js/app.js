/**
 * Product Information System (KatalogApp)
 * Client-side Dynamic Engine & Micro-Interactions
 */

document.addEventListener('DOMContentLoaded', () => {
    initApp();
});

function initApp() {
    initNavbarScroll();
    initSearchAndFilters();
    initViewSwitcher();
    initCartSystem();
    initQuickViewModal();
    initCountdownTimer();
    initKeyboardShortcuts();
}

/* 1. NAVBAR SCROLL EFFECT */
function initNavbarScroll() {
    const navbar = document.querySelector('.navbar-header');
    if (!navbar) return;

    window.addEventListener('scroll', () => {
        if (window.scrollY > 20) {
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('scrolled');
        }
    }, { passive: true });
}

/* 2. SEARCH, CATEGORY, STATUS, & SORT ENGINE */
function initSearchAndFilters() {
    const searchInput = document.getElementById('catalogSearchInput') || document.querySelector('.nav-search-input');
    const categoryPills = document.querySelectorAll('.category-pill-btn');
    const statusSelect = document.getElementById('statusFilterSelect');
    const sortSelect = document.getElementById('sortSelect');
    
    let currentCategory = 'all';
    let currentStatus = 'all';
    let currentSearch = '';
    let currentSort = 'default';

    function applyFilters() {
        const gridItems = Array.from(document.querySelectorAll('.product-card'));
        const tableRows = Array.from(document.querySelectorAll('.catalog-table-body tr'));

        let visibleCount = 0;

        // Process Grid Items
        gridItems.forEach(card => {
            const name = (card.dataset.name || '').toLowerCase();
            const cat = card.dataset.category || '';
            const status = card.dataset.status || '';
            const tags = (card.dataset.tags || '').toLowerCase();
            const query = currentSearch.toLowerCase().trim();

            const matchSearch = !query || name.includes(query) || tags.includes(query);
            const matchCategory = currentCategory === 'all' || cat.toLowerCase() === currentCategory.toLowerCase();
            const matchStatus = currentStatus === 'all' || status === currentStatus;

            if (matchSearch && matchCategory && matchStatus) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Process Table Rows
        tableRows.forEach(row => {
            const name = (row.dataset.name || '').toLowerCase();
            const cat = row.dataset.category || '';
            const status = row.dataset.status || '';
            const tags = (row.dataset.tags || '').toLowerCase();
            const query = currentSearch.toLowerCase().trim();

            const matchSearch = !query || name.includes(query) || tags.includes(query);
            const matchCategory = currentCategory === 'all' || cat.toLowerCase() === currentCategory.toLowerCase();
            const matchStatus = currentStatus === 'all' || status === currentStatus;

            if (matchSearch && matchCategory && matchStatus) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });

        // Sorting Grid Items
        if (currentSort !== 'default') {
            const gridContainer = document.querySelector('.product-grid-container');
            if (gridContainer) {
                const sorted = gridItems.sort((a, b) => {
                    const priceA = parseFloat(a.dataset.price) || 0;
                    const priceB = parseFloat(b.dataset.price) || 0;
                    const ratingA = parseFloat(a.dataset.rating) || 0;
                    const ratingB = parseFloat(b.dataset.rating) || 0;
                    const stockA = parseInt(a.dataset.stock) || 0;
                    const stockB = parseInt(b.dataset.stock) || 0;
                    const nameA = a.dataset.name || '';
                    const nameB = b.dataset.name || '';

                    if (currentSort === 'price-low') return priceA - priceB;
                    if (currentSort === 'price-high') return priceB - priceA;
                    if (currentSort === 'rating-high') return ratingB - ratingA;
                    if (currentSort === 'stock-high') return stockB - stockA;
                    if (currentSort === 'name-az') return nameA.localeCompare(nameB);
                    return 0;
                });
                sorted.forEach(el => gridContainer.appendChild(el));
            }
        }

        // Handle Empty State
        const emptyState = document.getElementById('catalogEmptyState');
        if (emptyState) {
            emptyState.style.display = visibleCount === 0 ? 'block' : 'none';
        }
    }

    if (searchInput) {
        searchInput.addEventListener('input', (e) => {
            currentSearch = e.target.value;
            applyFilters();
        });
    }

    categoryPills.forEach(pill => {
        pill.addEventListener('click', () => {
            categoryPills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            currentCategory = pill.dataset.category || 'all';
            applyFilters();
        });
    });

    if (statusSelect) {
        statusSelect.addEventListener('change', (e) => {
            currentStatus = e.target.value;
            applyFilters();
        });
    }

    if (sortSelect) {
        sortSelect.addEventListener('change', (e) => {
            currentSort = e.target.value;
            applyFilters();
        });
    }
}

/* 3. VIEW SWITCHER (GRID VS AUDIT TABLE) */
function initViewSwitcher() {
    const gridBtn = document.getElementById('viewGridBtn');
    const tableBtn = document.getElementById('viewTableBtn');
    const gridView = document.getElementById('catalogGridView');
    const tableView = document.getElementById('catalogTableView');

    if (!gridBtn || !tableBtn || !gridView || !tableView) return;

    function setView(view) {
        if (view === 'table') {
            gridView.style.display = 'none';
            tableView.style.display = 'block';
            gridBtn.classList.remove('active');
            tableBtn.classList.add('active');
            localStorage.setItem('katalog_pref_view', 'table');
        } else {
            gridView.style.display = 'grid';
            tableView.style.display = 'none';
            gridBtn.classList.add('active');
            tableBtn.classList.remove('active');
            localStorage.setItem('katalog_pref_view', 'grid');
        }
    }

    gridBtn.addEventListener('click', () => setView('grid'));
    tableBtn.addEventListener('click', () => setView('table'));

    const savedView = localStorage.getItem('katalog_pref_view');
    if (savedView === 'table') {
        setView('table');
    }
}

/* 4. SHOPPING CART ENGINE */
const Cart = {
    getItems() {
        try {
            return JSON.parse(localStorage.getItem('katalog_cart')) || [];
        } catch (e) {
            return [];
        }
    },
    save(items) {
        localStorage.setItem('katalog_cart', JSON.stringify(items));
        window.dispatchEvent(new Event('cartUpdated'));
    },
    add(product, qty = 1) {
        const items = this.getItems();
        const existing = items.find(i => i.id === product.id);
        if (existing) {
            existing.qty += qty;
        } else {
            items.push({
                id: product.id,
                name: product.name,
                price: parseFloat(product.price),
                finalPrice: parseFloat(product.finalPrice || product.price),
                image: product.image || 'assets/images/prod-laptop.jpg',
                stock: parseInt(product.stock) || 10,
                qty: qty
            });
        }
        this.save(items);
        showToast(`Berhasil menambahkan <strong>${escapeHtml(product.name)}</strong> ke keranjang!`, 'success');
    },
    updateQty(id, delta) {
        let items = this.getItems();
        const item = items.find(i => i.id === id);
        if (item) {
            item.qty += delta;
            if (item.qty <= 0) {
                items = items.filter(i => i.id !== id);
                showToast(`Item dihapus dari keranjang.`, 'warning');
            }
        }
        this.save(items);
    },
    remove(id) {
        let items = this.getItems();
        items = items.filter(i => i.id !== id);
        this.save(items);
        showToast('Item berhasil dihapus dari keranjang.', 'warning');
    },
    clear() {
        this.save([]);
    }
};

function initCartSystem() {
    const cartTriggerBtns = document.querySelectorAll('.cart-btn-trigger');
    const drawerBackdrop = document.getElementById('cartDrawerBackdrop');
    const closeDrawerBtn = document.getElementById('closeCartDrawerBtn');
    const cartListContainer = document.getElementById('cartDrawerList');
    const cartBadgeCount = document.querySelectorAll('.cart-badge-count');
    const cartSubtotalEl = document.getElementById('cartSubtotalAmount');
    const cartPpnEl = document.getElementById('cartPpnAmount');
    const cartGrandTotalEl = document.getElementById('cartGrandTotalAmount');

    function renderCart() {
        const items = Cart.getItems();
        const totalItemsCount = items.reduce((sum, i) => sum + i.qty, 0);

        // Update Badges
        cartBadgeCount.forEach(badge => {
            badge.textContent = totalItemsCount;
            badge.style.display = totalItemsCount > 0 ? 'inline-block' : 'none';
        });

        if (!cartListContainer) return;

        if (items.length === 0) {
            cartListContainer.innerHTML = `
                <div style="text-align: center; padding: 48px 16px; color: #94a3b8;">
                    <div style="font-size: 3rem; margin-bottom: 12px;">🛒</div>
                    <h4 style="color: #475569; margin-bottom: 6px;">Keranjang Kosong</h4>
                    <p style="font-size: 0.85rem;">Pilih produk favorit Anda dari katalog untuk memulai pemesanan.</p>
                </div>
            `;
            if (cartSubtotalEl) cartSubtotalEl.textContent = 'Rp 0';
            if (cartPpnEl) cartPpnEl.textContent = 'Rp 0';
            if (cartGrandTotalEl) cartGrandTotalEl.textContent = 'Rp 0';
            return;
        }

        let subtotal = 0;
        let html = '';

        items.forEach(item => {
            const itemSubtotal = item.finalPrice * item.qty;
            subtotal += itemSubtotal;

            html += `
                <div class="cart-item-card">
                    <img src="${item.image}" alt="${escapeHtml(item.name)}" class="cart-item-thumb">
                    <div class="cart-item-info">
                        <div class="cart-item-name">${escapeHtml(item.name)}</div>
                        <div class="cart-item-price">Rp ${formatRupiahJs(item.finalPrice)}</div>
                        <div class="cart-qty-ctrl">
                            <button type="button" class="cart-qty-btn" onclick="Cart.updateQty('${item.id}', -1)">−</button>
                            <span class="cart-qty-num">${item.qty}</span>
                            <button type="button" class="cart-qty-btn" onclick="Cart.updateQty('${item.id}', 1)">+</button>
                        </div>
                    </div>
                    <button type="button" onclick="Cart.remove('${item.id}')" style="background: none; border: none; color: #ef4444; cursor: pointer; padding: 6px; font-size: 1.1rem;" title="Hapus">
                        &times;
                    </button>
                </div>
            `;
        });

        cartListContainer.innerHTML = html;

        // PPN 11% calculation
        const ppnRate = 0.11;
        const ppnVal = Math.round(subtotal * ppnRate);
        const grandTotal = subtotal + ppnVal;

        if (cartSubtotalEl) cartSubtotalEl.textContent = `Rp ${formatRupiahJs(subtotal)}`;
        if (cartPpnEl) cartPpnEl.textContent = `Rp ${formatRupiahJs(ppnVal)}`;
        if (cartGrandTotalEl) cartGrandTotalEl.textContent = `Rp ${formatRupiahJs(grandTotal)}`;
    }

    // Event listeners for Drawer open/close
    cartTriggerBtns.forEach(btn => {
        btn.addEventListener('click', (e) => {
            e.preventDefault();
            if (drawerBackdrop) drawerBackdrop.classList.add('active');
        });
    });

    if (closeDrawerBtn) {
        closeDrawerBtn.addEventListener('click', () => {
            if (drawerBackdrop) drawerBackdrop.classList.remove('active');
        });
    }

    if (drawerBackdrop) {
        drawerBackdrop.addEventListener('click', (e) => {
            if (e.target === drawerBackdrop) {
                drawerBackdrop.classList.remove('active');
            }
        });
    }

    // Add to cart buttons on page
    document.addEventListener('click', (e) => {
        const addBtn = e.target.closest('.js-add-to-cart');
        if (addBtn) {
            e.preventDefault();
            const product = {
                id: addBtn.dataset.id,
                name: addBtn.dataset.name,
                price: addBtn.dataset.price,
                finalPrice: addBtn.dataset.finalprice,
                image: addBtn.dataset.image,
                stock: addBtn.dataset.stock
            };
            
            // Check stock
            if (parseInt(product.stock) <= 0) {
                showToast('Maaf, produk ini sedang habis.', 'danger');
                return;
            }

            Cart.add(product, 1);
        }
    });

    window.addEventListener('cartUpdated', renderCart);
    renderCart();
}

/* 5. QUICK VIEW MODAL */
function initQuickViewModal() {
    const modalBackdrop = document.getElementById('quickViewModal');
    const closeBtn = document.getElementById('closeQuickViewBtn');

    if (!modalBackdrop) return;

    document.addEventListener('click', (e) => {
        const trigger = e.target.closest('.js-quick-view-btn');
        if (trigger) {
            e.preventDefault();
            const data = trigger.dataset;

            const modalImg = document.getElementById('qvModalImage');
            const modalTitle = document.getElementById('qvModalTitle');
            const modalCatBadge = document.getElementById('qvModalCategory');
            const modalStockPill = document.getElementById('qvModalStock');
            const modalDesc = document.getElementById('qvModalDesc');
            const modalPriceFinal = document.getElementById('qvModalPriceFinal');
            const modalPriceOri = document.getElementById('qvModalPriceOriginal');
            const modalTags = document.getElementById('qvModalTags');
            const modalWarehouseNote = document.getElementById('qvModalWarehouseNote');
            const modalAddCartBtn = document.getElementById('qvModalAddCartBtn');

            if (modalImg) modalImg.src = data.image || '';
            if (modalTitle) modalTitle.textContent = data.name || '';
            if (modalCatBadge) modalCatBadge.innerHTML = data.categorybadge || '';
            if (modalStockPill) modalStockPill.innerHTML = data.stockbadge || '';
            if (modalDesc) modalDesc.textContent = data.desc || '';
            if (modalPriceFinal) modalPriceFinal.textContent = `Rp ${formatRupiahJs(data.finalprice)}`;
            if (modalPriceOri) modalPriceOri.textContent = `Rp ${formatRupiahJs(data.price)}`;
            if (modalWarehouseNote) {
                modalWarehouseNote.textContent = data.catatan ? `Catatan Gudang: "${data.catatan}"` : 'Catatan Gudang: Kondisi standar, siap kirim.';
            }

            if (modalTags && data.tags) {
                const tagList = data.tags.split('|').map(t => t.trim());
                modalTags.innerHTML = tagList.map(t => `<span class="tag-chip">#${escapeHtml(t)}</span>`).join(' ');
            }

            if (modalAddCartBtn) {
                modalAddCartBtn.dataset.id = data.id;
                modalAddCartBtn.dataset.name = data.name;
                modalAddCartBtn.dataset.price = data.price;
                modalAddCartBtn.dataset.finalprice = data.finalprice;
                modalAddCartBtn.dataset.image = data.image;
                modalAddCartBtn.dataset.stock = data.stock;

                if (parseInt(data.stock) <= 0) {
                    modalAddCartBtn.disabled = true;
                    modalAddCartBtn.textContent = 'Stok Habis';
                } else {
                    modalAddCartBtn.disabled = false;
                    modalAddCartBtn.textContent = 'Tambah ke Keranjang';
                }
            }

            modalBackdrop.classList.add('active');
        }
    });

    if (closeBtn) {
        closeBtn.addEventListener('click', () => {
            modalBackdrop.classList.remove('active');
        });
    }

    modalBackdrop.addEventListener('click', (e) => {
        if (e.target === modalBackdrop) {
            modalBackdrop.classList.remove('active');
        }
    });
}

/* 6. COUNTDOWN TIMER */
function initCountdownTimer() {
    const hoursEl = document.getElementById('timerHours');
    const minutesEl = document.getElementById('timerMinutes');
    const secondsEl = document.getElementById('timerSeconds');

    if (!hoursEl || !minutesEl || !secondsEl) return;

    let totalSeconds = 4 * 3600 + 45 * 60 + 20; // 4 hours 45 mins 20 secs

    setInterval(() => {
        if (totalSeconds > 0) {
            totalSeconds--;
            const h = Math.floor(totalSeconds / 3600);
            const m = Math.floor((totalSeconds % 3600) / 60);
            const s = totalSeconds % 60;

            hoursEl.textContent = String(h).padStart(2, '0');
            minutesEl.textContent = String(m).padStart(2, '0');
            secondsEl.textContent = String(s).padStart(2, '0');
        }
    }, 1000);
}

/* 7. KEYBOARD SHORTCUTS */
function initKeyboardShortcuts() {
    window.addEventListener('keydown', (e) => {
        if (e.key === '/' && document.activeElement.tagName !== 'INPUT' && document.activeElement.tagName !== 'TEXTAREA') {
            e.preventDefault();
            const search = document.getElementById('catalogSearchInput') || document.querySelector('.nav-search-input');
            if (search) {
                search.focus();
                search.select();
            }
        }
        if (e.key === 'Escape') {
            const openModals = document.querySelectorAll('.modal-backdrop.active, .cart-drawer-backdrop.active');
            openModals.forEach(m => m.classList.remove('active'));
        }
    });
}

/* 8. TOAST NOTIFICATION UTILITY */
function showToast(message, type = 'success') {
    let container = document.querySelector('.toast-container');
    if (!container) {
        container = document.createElement('div');
        container.className = 'toast-container';
        document.body.appendChild(container);
    }

    const toast = document.createElement('div');
    toast.className = `toast-message toast-${type}`;
    
    let icon = '✓';
    if (type === 'warning') icon = '⚠️';
    if (type === 'danger') icon = '✕';
    if (type === 'info') icon = 'ℹ️';

    toast.innerHTML = `
        <span style="font-size: 1.15rem; font-weight: bold;">${icon}</span>
        <div style="flex: 1; font-size: 0.88rem; line-height: 1.4;">${message}</div>
    `;

    container.appendChild(toast);

    setTimeout(() => {
        toast.style.opacity = '0';
        toast.style.transform = 'translateX(100%)';
        setTimeout(() => toast.remove(), 300);
    }, 3500);
}

/* Helper formatters */
function formatRupiahJs(number) {
    return new Intl.NumberFormat('id-ID').format(number);
}

function escapeHtml(text) {
    if (!text) return '';
    return text
        .replace(/&/g, "&amp;")
        .replace(/</g, "&lt;")
        .replace(/>/g, "&gt;")
        .replace(/"/g, "&quot;")
        .replace(/'/g, "&#039;");
}
