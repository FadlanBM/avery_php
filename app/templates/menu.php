<?php
// Menu Catalog View
?>
<!DOCTYPE html>
<html lang="id">

<?php require_once __DIR__ . '/includes/header.php'; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/menu_catalog.css">

<body class="page-shell font-body">
    <!-- TopAppBar -->
    <header class="top-header">
        <div class="header-container">
            <div class="logo">
                <span>Saffron & Sage</span>
            </div>
            <nav class="main-nav">
                <a href="<?= BASE_URL ?>/menu" class="active">Menu</a>
                <a href="<?= BASE_URL ?>/history">Riwayat</a>
                <a href="#">Bantuan</a>
            </nav>
            <div class="header-actions">
                <div class="table-info">
                    <span class="material-symbols-outlined icon">table_restaurant</span>
                    <span><?= htmlspecialchars(isset($currentTable) && $currentTable ? 'Meja ' . $currentTable['nomor_meja'] : 'Pilih Meja') ?></span>
                </div>
                <a href="<?= BASE_URL ?>/menu/logout" class="logout-btn" title="Keluar dari meja" aria-label="Keluar dari meja">
                    <span class="material-symbols-outlined">logout</span>
                </a>
            </div>
        </div>
        <div class="header-divider"></div>
    </header>

    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-header">
            <h2>Selamat Datang</h2>
            <p>Nikmati hidangan premium kami</p>
        </div>
        <nav class="sidebar-nav">
            <?php
            $selectedCategoryId = $selectedCategoryId ?? null;
            $categoryIcons = [
                'menu' => 'restaurant_menu',
                'makanan' => 'restaurant_menu',
                'makanan utama' => 'restaurant',
                'minuman' => 'local_bar',
                'drink' => 'local_bar',
                'dessert' => 'icecream',
                'hidangan penutup' => 'icecream',
                'promo' => 'loyalty',
            ];
            ?>
            <a href="<?= BASE_URL ?>/menu" class="<?= $selectedCategoryId === null ? 'active ' : '' ?>list-item">
                <span class="material-symbols-outlined">restaurant_menu</span>
                <span>Semua Menu</span>
            </a>
            <?php if (!empty($categories)): ?>
                <?php foreach ($categories as $index => $category): ?>
                    <?php
                    $categoryName = $category->name ?? '';
                    $iconKey = strtolower(trim($categoryName));
                    $icon = $categoryIcons[$iconKey] ?? 'category';
                    $categoryId = (int) ($category->id ?? 0);
                    ?>
                    <a href="<?= BASE_URL ?>/menu?category=<?= $categoryId ?>" class="<?= $selectedCategoryId === $categoryId ? 'active ' : '' ?>list-item">
                        <span class="material-symbols-outlined"><?= htmlspecialchars($icon) ?></span>
                        <span><?= htmlspecialchars($categoryName) ?></span>
                    </a>
                <?php endforeach; ?>
            <?php endif; ?>
        </nav>
        <div class="sidebar-footer">
            <a href="<?= BASE_URL ?>/cart" class="cart-btn" id="sidebar-cart-btn">
                <span class="material-symbols-outlined" style="font-variation-settings: 'FILL' 1;">shopping_cart</span>
                <span>Keranjang Saya</span>
                <span class="cart-count-badge" id="cart-count-badge" style="display:none;">0</span>
            </a>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <?php if (!empty($tableError)): ?>
            <div class="mx-6 mt-6 rounded-xl bg-red-50 px-5 py-4 text-sm font-semibold text-red-700">
                <?= htmlspecialchars($tableError) ?>
            </div>
        <?php endif; ?>

        <!-- Menu Grid -->
        <section class="menu-grid">
            <?php if (!empty($menus)): ?>
                <?php foreach ($menus as $menu): ?>
                    <div class="menu-card group">
                        <div class="image-wrapper">
                            <img alt="<?= htmlspecialchars($menu['name']) ?>" src="<?= BASE_URL . '/' . ltrim($menu['image_path'], '/') ?>">
                            <button class="fav-btn" data-menu-id="<?= htmlspecialchars((string) $menu['id']) ?>"><span class="material-symbols-outlined">favorite</span></button>
                            <?php if (!empty($menu['category_name'])): ?>
                                <span class="left-badge badge-fav"><?= htmlspecialchars($menu['category_name']) ?></span>
                            <?php endif; ?>
                        </div>
                        <div class="menu-info">
                            <div class="title-price">
                                <h4><?= htmlspecialchars($menu['name']) ?></h4>
                                <span class="price">Rp <?= htmlspecialchars(number_format((float) $menu['price'], 0, ',', '.')) ?></span>
                            </div>
                            <p class="desc"><?= htmlspecialchars($menu['description'] ?? '') ?></p>
                            <div class="add-row">
                                <button class="add-btn" type="button" data-menu-id="<?= htmlspecialchars((string) $menu['id']) ?>">
                                    <span class="material-symbols-outlined">add</span>
                                    Tambah
                                </button>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-menu-state">
                    <span class="material-symbols-outlined">restaurant_menu</span>
                    <h3>Menu belum tersedia</h3>
                    <p>Belum ada produk aktif untuk kategori ini.</p>
                </div>
            <?php endif; ?>
        </section>
    </main>

    <!-- Toast Notification -->
    <div id="toast" class="toast-notification" style="display:none;position:fixed;bottom:2rem;left:50%;transform:translateX(-50%);background:#1d1b17;color:#fef8f1;padding:0.75rem 1.5rem;border-radius:12px;display:none;align-items:center;gap:0.5rem;font-size:0.9rem;z-index:9999;box-shadow:0 8px 24px rgba(0,0,0,0.3);">
        <span class="material-symbols-outlined">check_circle</span>
        <span id="toast-message">Item ditambahkan</span>
    </div>

    <?php require_once __DIR__ . '/includes/footer.php'; ?>

<script>
(function() {
    const BASE_URL = '<?= BASE_URL ?>';
    let cartItemCount = 0;

    function showToast(message, duration) {
        duration = duration || 2500;
        var toast = document.getElementById('toast');
        var msgEl = document.getElementById('toast-message');
        msgEl.textContent = message;
        toast.style.display = 'flex';
        setTimeout(function() { toast.style.display = 'none'; }, duration);
    }

    function updateCartBadge(count) {
        var badge = document.getElementById('cart-count-badge');
        if (!badge) return;
        cartItemCount = count;
        badge.textContent = count;
        badge.style.display = count > 0 ? 'inline-flex' : 'none';
    }

    // Load initial cart count
    fetch(BASE_URL + '/cart/api')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                updateCartBadge(data.itemCount || 0);
            }
        })
        .catch(function() { /* silently fail */ });

    // Add to cart
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.add-btn');
        if (!btn) return;

        var menuId = btn.getAttribute('data-menu-id');
        if (!menuId) return;

        // Visual feedback: temporarily change button text
        var originalHTML = btn.innerHTML;
        btn.innerHTML = '<span class="material-symbols-outlined" style="animation:spin 0.5s linear infinite;">sync</span> Menambah...';
        btn.disabled = true;

        var formData = new FormData();
        formData.append('menu_id', menuId);
        formData.append('quantity', '1');

        fetch(BASE_URL + '/cart/add', {
            method: 'POST',
            body: formData
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                showToast(data.message || 'Item ditambahkan ke keranjang');
                updateCartBadge(data.cartItemCount || 0);
                btn.innerHTML = '<span class="material-symbols-outlined">check</span> Ditambahkan';
                setTimeout(function() {
                    btn.innerHTML = originalHTML;
                    btn.disabled = false;
                }, 1200);
            } else {
                showToast(data.message || 'Gagal menambahkan item', 3000);
                btn.innerHTML = originalHTML;
                btn.disabled = false;
            }
        })
        .catch(function() {
            showToast('Terjadi kesalahan. Coba lagi.', 3000);
            btn.innerHTML = originalHTML;
            btn.disabled = false;
        });
    });

    // Like toggle
    document.addEventListener('click', function(e) {
        var btn = e.target.closest('.fav-btn');
        if (!btn) return;

        var menuId = btn.getAttribute('data-menu-id');
        if (!menuId) return;

        var formData = new FormData();
        formData.append('menu_id', menuId);

        fetch(BASE_URL + '/like/toggle', {
            method: 'POST',
            body: formData
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                var icon = btn.querySelector('.material-symbols-outlined');
                if (data.liked) {
                    icon.style.fontVariationSettings = "'FILL' 1";
                    icon.style.color = '#e74c3c';
                } else {
                    icon.style.fontVariationSettings = "'FILL' 0";
                    icon.style.color = '';
                }
            }
        })
        .catch(function() { /* silently fail */ });
    });
})();
</script>

<style>
    .cart-count-badge {
        background: #9c3800;
        color: #fef8f1;
        font-size: 0.65rem;
        font-weight: 700;
        min-width: 18px;
        height: 18px;
        border-radius: 9px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        margin-left: 6px;
    }
    .sidebar-footer .cart-btn {
        display: flex;
        align-items: center;
        gap: 0.5rem;
        text-decoration: none;
        color: inherit;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }
</style>

</body>
</html>
