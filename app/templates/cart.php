<?php
// Cart View
$cartItemCount = $itemCount ?? 0;
$cartItems = $cartItems ?? [];
$total = $total ?? 0;
$cart = $cart ?? null;
$taxRate = 0.10; // 10% tax
$serviceCharge = 5000;
$tax = $total * $taxRate;
$grandTotal = $total + $tax + $serviceCharge;
$tableNumber = $_SESSION['table_number'] ?? null;
?>
<!DOCTYPE html>
<html lang="id">

<?php require_once __DIR__ . '/includes/header.php'; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/cart.css">

<body class="page-shell font-body">
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-wrapper">
        <div class="brand-logo">Saffron & Sage</div>
        <nav class="nav-links">
          <a class="nav-item" href="<?= BASE_URL ?>/menu">Menu</a>
          <a class="nav-item" href="#">Riwayat</a>
          <a class="nav-item" href="#">Bantuan</a>
        </nav>
        <div class="nav-actions">
          <div class="table-badge">
            <span class="material-symbols-outlined">table_restaurant</span>
            <?= $tableNumber ? 'Meja ' . htmlspecialchars($tableNumber) : 'Pilih Meja' ?>
          </div>
          <a href="<?= BASE_URL ?>/cart" class="action-icon active">
            <span class="material-symbols-outlined">shopping_bag</span>
            <?php if ($cartItemCount > 0): ?>
              <span class="cart-badge" id="cart-badge-header"><?= $cartItemCount ?></span>
            <?php endif; ?>
          </a>
          <div class="action-icon">
            <span class="material-symbols-outlined">account_circle</span>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <main class="page-container" id="cart-page">
    <header class="cart-header">
      <h1 class="cart-title">Keranjang Belanja</h1>
      <p class="cart-subtitle">Tinjau pesanan Anda sebelum kami sajikan dengan sepenuh hati.</p>
    </header>

    <div class="cart-grid">
      <!-- Cart Items -->
      <div class="cart-items-section" id="cart-items-list">
        <?php if (empty($cartItems)): ?>
          <div class="empty-cart-state" id="empty-cart-state">
            <span class="material-symbols-outlined empty-icon">shopping_cart</span>
            <h3>Keranjang Anda kosong</h3>
            <p>Belum ada item di keranjang. Yuk, mulai pilih menu favorit Anda!</p>
            <a href="<?= BASE_URL ?>/menu" class="btn-checkout" style="display:inline-block;margin-top:1rem;text-decoration:none;">
              <span class="material-symbols-outlined">restaurant_menu</span>
              Lihat Menu
            </a>
          </div>
        <?php else: ?>
          <?php foreach ($cartItems as $item): ?>
            <div class="cart-item-card" data-item-id="<?= $item['id'] ?>" data-menu-id="<?= $item['restaurant_menu_id'] ?>">
              <div class="item-visual">
                <img src="<?= BASE_URL . '/' . ltrim($item['image_path'] ?? 'assets/images/menu/quinoa_bowl.jpg', '/') ?>" alt="<?= htmlspecialchars($item['name']) ?>">
              </div>
              <div class="item-details">
                <div class="item-header">
                  <h3 class="item-name"><?= htmlspecialchars($item['name']) ?></h3>
                  <span class="item-price">Rp <?= number_format((float)$item['price'], 0, ',', '.') ?></span>
                </div>
                <p class="item-desc"><?= htmlspecialchars($item['description'] ?? '') ?></p>
                <div class="item-footer">
                  <div class="note-input-group">
                    <label class="note-label">CATATAN</label>
                    <input type="text" class="note-input" placeholder="Contoh: Tanpa bawang..." value="<?= htmlspecialchars($item['notes'] ?? '') ?>" data-item-id="<?= $item['id'] ?>">
                  </div>
                  <div class="quantity-selector">
                    <button class="qty-btn qty-decrease" data-item-id="<?= $item['id'] ?>">-</button>
                    <span class="qty-value"><?= (int)$item['quantity'] ?></span>
                    <button class="qty-btn primary qty-increase" data-item-id="<?= $item['id'] ?>">+</button>
                  </div>
                </div>
                <button class="remove-item-btn" data-item-id="<?= $item['id'] ?>">
                  <span class="material-symbols-outlined">delete</span>
                  Hapus
                </button>
              </div>
            </div>
          <?php endforeach; ?>
        <?php endif; ?>
      </div>

      <!-- Order Summary -->
      <aside class="summary-section">
        <div class="summary-card">
          <h2 class="summary-title">Ringkasan Pesanan</h2>
          <div class="summary-rows" id="summary-rows">
            <div class="summary-row">
              <span>Subtotal</span>
              <span id="summary-subtotal">Rp <?= number_format($total, 0, ',', '.') ?></span>
            </div>
            <div class="summary-row">
              <span>Pajak (10%)</span>
              <span id="summary-tax">Rp <?= number_format($tax, 0, ',', '.') ?></span>
            </div>
            <div class="summary-row">
              <span>Biaya Layanan</span>
              <span id="summary-service">Rp <?= number_format($serviceCharge, 0, ',', '.') ?></span>
            </div>
          </div>
          <div class="summary-divider"></div>
          <div class="total-row">
            <span class="total-label">Total Pembayaran</span>
            <span class="total-value" id="summary-total">Rp <?= number_format($grandTotal, 0, ',', '.') ?></span>
          </div>
          <button class="btn-checkout" id="btn-checkout">
            Buat Pesanan
            <span class="material-symbols-outlined">arrow_forward</span>
          </button>
          <div class="payment-badge">
            <span class="material-symbols-outlined">verified_user</span>
            Pembayaran Aman & Terinkripsi
          </div>
          <p class="terms-text">
            Dengan menekan tombol, Anda menyetujui <br>
            <a href="#">Syarat & Ketentuan</a> Saffron & Sage.
          </p>
        </div>
      </aside>
    </div>
  </main>

  <!-- Toast Notification -->
  <div id="toast" class="toast-notification" style="display:none;">
    <span class="material-symbols-outlined">check_circle</span>
    <span id="toast-message">Item ditambahkan</span>
  </div>

  <footer class="site-footer">
    <div class="footer-container">
      <div class="footer-brand">
        <div class="footer-logo">Saffron &amp; Sage</div>
        <div class="footer-tagline">Rasa yang Bercerita.</div>
      </div>
      <nav class="footer-links">
        <a class="f-link" href="#">Tentang Kami</a>
        <a class="f-link" href="#">Kebijakan Privasi</a>
        <a class="f-link" href="#">Kontak</a>
        <a class="f-link" href="#">Lokasi</a>
      </nav>
      <div class="footer-copyright">
        &copy; 2024 Saffron &amp; Sage Culinary Editorial. Rasa yang Bercerita.
      </div>
    </div>
  </footer>

  <script>
    (function() {
      const BASE_URL = '<?= BASE_URL ?>';
      const TAX_RATE = 0.10;
      const SERVICE_CHARGE = 5000;

      function showToast(message, duration = 2500) {
        const toast = document.getElementById('toast');
        const msgEl = document.getElementById('toast-message');
        msgEl.textContent = message;
        toast.style.display = 'flex';
        setTimeout(() => {
          toast.style.display = 'none';
        }, duration);
      }

      function formatRupiah(amount) {
        return 'Rp ' + Math.round(amount).toLocaleString('id-ID');
      }

      async function apiPost(url, data) {
        const response = await fetch(BASE_URL + url, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams(data).toString(),
        });
        return response.json();
      }

      async function refreshCart() {
        const response = await fetch(BASE_URL + '/cart/api');
        const data = await response.json();
        if (!data.success) return;

        const listEl = document.getElementById('cart-items-list');
        const emptyState = document.getElementById('empty-cart-state');

        if (data.items.length === 0) {
          listEl.innerHTML = `
        <div class="empty-cart-state" id="empty-cart-state">
          <span class="material-symbols-outlined empty-icon">shopping_cart</span>
          <h3>Keranjang Anda kosong</h3>
          <p>Belum ada item di keranjang. Yuk, mulai pilih menu favorit Anda!</p>
          <a href="${BASE_URL}/menu" class="btn-checkout" style="display:inline-block;margin-top:1rem;text-decoration:none;">
            <span class="material-symbols-outlined">restaurant_menu</span>
            Lihat Menu
          </a>
        </div>`;
        } else {
          let html = '';
          data.items.forEach(item => {
            const imgSrc = BASE_URL + '/' + (item.image_path || 'assets/images/menu/quinoa_bowl.jpg').replace(/^\/+/, '');
            html += `
        <div class="cart-item-card" data-item-id="${item.id}" data-menu-id="${item.menu_id}">
          <div class="item-visual">
            <img src="${imgSrc}" alt="${item.name}">
          </div>
          <div class="item-details">
            <div class="item-header">
              <h3 class="item-name">${item.name}</h3>
              <span class="item-price">${formatRupiah(item.price)}</span>
            </div>
            <p class="item-desc">${item.description || ''}</p>
            <div class="item-footer">
              <div class="note-input-group">
                <label class="note-label">CATATAN</label>
                <input type="text" class="note-input" placeholder="Contoh: Tanpa bawang..." value="${item.notes || ''}" data-item-id="${item.id}">
              </div>
              <div class="quantity-selector">
                <button class="qty-btn qty-decrease" data-item-id="${item.id}">-</button>
                <span class="qty-value">${item.quantity}</span>
                <button class="qty-btn primary qty-increase" data-item-id="${item.id}">+</button>
              </div>
            </div>
            <button class="remove-item-btn" data-item-id="${item.id}">
              <span class="material-symbols-outlined">delete</span>
              Hapus
            </button>
          </div>
        </div>`;
          });
          listEl.innerHTML = html;
        }

        // Update summary
        const subtotal = data.total;
        const tax = subtotal * TAX_RATE;
        const grandTotal = subtotal + tax + SERVICE_CHARGE;

        document.getElementById('summary-subtotal').textContent = formatRupiah(subtotal);
        document.getElementById('summary-tax').textContent = formatRupiah(tax);
        document.getElementById('summary-service').textContent = formatRupiah(SERVICE_CHARGE);
        document.getElementById('summary-total').textContent = formatRupiah(grandTotal);

        // Update badge
        const badge = document.getElementById('cart-badge-header');
        if (badge) {
          badge.textContent = data.itemCount;
          badge.style.display = data.itemCount > 0 ? 'inline-flex' : 'none';
        }
      }

      // Increase quantity
      document.addEventListener('click', function(e) {
        if (e.target.closest('.qty-increase')) {
          const itemId = e.target.closest('.qty-increase').dataset.itemId;
          apiPost('/cart/update', {
            item_id: itemId,
            action: 'increment'
          }).then(() => refreshCart());
        }
      });

      // Decrease quantity
      document.addEventListener('click', function(e) {
        if (e.target.closest('.qty-decrease')) {
          const itemId = e.target.closest('.qty-decrease').dataset.itemId;
          apiPost('/cart/update', {
            item_id: itemId,
            action: 'decrement'
          }).then(() => refreshCart());
        }
      });

      // Remove item
      document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-item-btn')) {
          const itemId = e.target.closest('.remove-item-btn').dataset.itemId;
          apiPost('/cart/remove', {
            item_id: itemId
          }).then(() => {
            showToast('Item dihapus dari keranjang');
            refreshCart();
          });
        }
      });

      // Note input (save on blur)
      document.addEventListener('focusout', function(e) {
        if (e.target.classList.contains('note-input') && e.target.dataset.itemId) {
          const itemId = e.target.dataset.itemId;
          const notes = e.target.value;
          apiPost('/cart/update', {
            item_id: itemId,
            quantity: 0,
            action: 'note',
            notes: notes
          });
        }
      });

      // Checkout button
      document.getElementById('btn-checkout').addEventListener('click', function() {
        showToast('Menuju ke proses pemesanan...');
        setTimeout(() => {
          window.location.href = BASE_URL + '/checkout';
        }, 500);
      });
    })();
  </script>

  <style>
    .empty-cart-state {
      text-align: center;
      padding: 3rem 1rem;
    }

    .empty-cart-state .empty-icon {
      font-size: 4rem;
      color: #c8b89a;
    }

    .empty-cart-state h3 {
      font-size: 1.25rem;
      margin: 1rem 0 0.5rem;
      color: var(--text-primary, #1d1b17);
    }

    .empty-cart-state p {
      color: var(--text-secondary, #78736c);
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }

    .remove-item-btn {
      display: inline-flex;
      align-items: center;
      gap: 4px;
      background: none;
      border: none;
      color: #d9534f;
      font-size: 0.8rem;
      cursor: pointer;
      margin-top: 0.5rem;
      padding: 4px 8px;
      border-radius: 6px;
      transition: background 0.2s;
    }

    .remove-item-btn:hover {
      background: #fde8e8;
    }

    .remove-item-btn .material-symbols-outlined {
      font-size: 1rem;
    }

    .cart-badge {
      position: absolute;
      top: -4px;
      right: -4px;
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
    }

    .action-icon {
      position: relative;
    }

    .toast-notification {
      position: fixed;
      bottom: 2rem;
      left: 50%;
      transform: translateX(-50%);
      background: #1d1b17;
      color: #fef8f1;
      padding: 0.75rem 1.5rem;
      border-radius: 12px;
      display: flex;
      align-items: center;
      gap: 0.5rem;
      font-size: 0.9rem;
      z-index: 9999;
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.3);
      animation: slideUp 0.3s ease;
    }

    @keyframes slideUp {
      from {
        transform: translateX(-50%) translateY(20px);
        opacity: 0;
      }

      to {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
      }
    }
  </style>

</body>

</html>