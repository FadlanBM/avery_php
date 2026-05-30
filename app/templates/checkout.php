<?php
// Checkout View
$cartItemCount = count($cartItems ?? []);
$tableNumber = $tableNumber ?? $_SESSION['table_number'] ?? null;
?>
<!DOCTYPE html>
<html lang="id">

<?php require_once __DIR__ . '/includes/header.php'; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/checkout.css">

<body class="page-shell font-body">
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-wrapper">
        <a href="<?= BASE_URL ?>/menu" class="brand-logo">Saffron & Sage</a>
        <nav class="nav-links">
          <a class="nav-link" href="<?= BASE_URL ?>/menu">Menu</a>
          <a class="nav-link" href="<?= BASE_URL ?>/history">Riwayat</a>
          <a class="nav-link" href="#">Bantuan</a>
        </nav>
        <div class="nav-actions">
          <div class="table-badge">
            <span class="material-symbols-outlined">table_restaurant</span>
            <?= $tableNumber ? 'Meja ' . htmlspecialchars($tableNumber) : 'Pilih Meja' ?>
          </div>
          <a href="<?= BASE_URL ?>/cart" class="action-icon">
            <span class="material-symbols-outlined">shopping_bag</span>
            <?php if ($cartItemCount > 0): ?>
              <span class="cart-badge"><?= $cartItemCount ?></span>
            <?php endif; ?>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <main class="page-container">
    <div class="checkout-wrapper">
      <div class="checkout-main">
        <header class="checkout-header">
          <a href="<?= BASE_URL ?>/cart" class="back-link">
            <span class="material-symbols-outlined">arrow_back</span>
            Kembali ke Keranjang
          </a>
          <h1 class="checkout-title">Konfirmasi Pesanan</h1>
        </header>

        <!-- Flash Messages -->
        <?php if (\App\Helpers\FlashMessage::has()): ?>
          <div class="flash-messages">
            <?php foreach (\App\Helpers\FlashMessage::get() as $msg): ?>
              <div class="alert alert-<?= htmlspecialchars($msg['type']) ?>">
                <span class="material-symbols-outlined">
                  <?= $msg['type'] === 'error' ? 'error' : 'check_circle' ?>
                </span>
                <span><?= htmlspecialchars($msg['message']) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if (isset($_SESSION['error'])): ?>
          <div class="flash-messages">
            <div class="alert alert-error">
              <span class="material-symbols-outlined">error</span>
              <span><?= htmlspecialchars($_SESSION['error']) ?></span>
            </div>
          </div>
          <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

        <form action="<?= BASE_URL ?>/checkout/process" method="POST" id="checkout-form">
          <!-- Item Summary Section -->
          <div class="section-card">
            <h2 class="section-title">
              <span class="material-symbols-outlined">restaurant_menu</span>
              Rincian Hidangan
            </h2>
            <div class="items-list">
              <?php foreach ($cartItems as $item): ?>
                <div class="checkout-item-row">
                  <div class="item-img">
                    <img src="<?= BASE_URL ?>/<?= htmlspecialchars(ltrim($item['image_path'] ?? 'assets/images/menu/quinoa_bowl.jpg', '/')) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
                  </div>
                  <div class="item-meta">
                    <h3 class="item-name"><?= htmlspecialchars($item['name']) ?></h3>
                    <?php if (!empty($item['notes'])): ?>
                      <p class="item-notes">Catatan: "<?= htmlspecialchars($item['notes']) ?>"</p>
                    <?php endif; ?>
                    <div class="item-qty-price">
                      <span class="item-qty"><?= $item['quantity'] ?>x</span>
                      <span class="item-price">Rp <?= number_format($item['price'], 0, ',', '.') ?></span>
                    </div>
                  </div>
                  <div class="item-subtotal">
                    Rp <?= number_format($item['price'] * $item['quantity'], 0, ',', '.') ?>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>

          <!-- Notes for Kitchen -->
          <div class="section-card">
            <h2 class="section-title">
              <span class="material-symbols-outlined">description</span>
              Catatan Pesanan
            </h2>
            <div class="form-group">
              <label for="notes" class="input-label">Catatan Tambahan untuk Koki (Opsional)</label>
              <textarea id="notes" name="notes" class="textarea-input" placeholder="Contoh: Sendok dipisah, alergi udang, tingkat kepedasan sedang..."></textarea>
            </div>
          </div>

          <!-- Payment Method -->
          <div class="section-card">
            <h2 class="section-title">
              <span class="material-symbols-outlined">payments</span>
              Metode Pembayaran
            </h2>
            <p class="section-desc">Pilih metode pembayaran. Anda dapat melakukan pembayaran langsung ke kasir setelah pesanan dibuat.</p>
            <div class="payment-methods-grid">
              <?php foreach ($paymentMethods as $pm): ?>
                <label class="payment-card">
                  <input type="radio" name="payment_method_id" value="<?= $pm->id ?>" required>
                  <div class="payment-card-content">
                    <span class="material-symbols-outlined payment-icon">
                      <?= strtolower($pm->name) === 'tunai' || strtolower($pm->name) === 'cash' ? 'payments' : 'account_balance_wallet' ?>
                    </span>
                    <span class="payment-name"><?= htmlspecialchars($pm->name) ?></span>
                    <span class="select-indicator"></span>
                  </div>
                </label>
              <?php endforeach; ?>
            </div>
          </div>
        </form>
      </div>

      <!-- Sidebar Order Summary -->
      <aside class="checkout-sidebar">
        <div class="summary-card">
          <h2 class="summary-title">Ringkasan Biaya</h2>
          
          <div class="summary-details">
            <div class="summary-row">
              <span>Subtotal</span>
              <span>Rp <?= number_format($subtotal, 0, ',', '.') ?></span>
            </div>
            <div class="summary-row">
              <span>Pajak (PPN 10%)</span>
              <span>Rp <?= number_format($tax, 0, ',', '.') ?></span>
            </div>
            <div class="summary-row">
              <span>Biaya Layanan</span>
              <span>Rp <?= number_format($serviceCharge, 0, ',', '.') ?></span>
            </div>
            <div class="divider"></div>
            <div class="summary-row total-row">
              <span>Total Pembayaran</span>
              <span class="total-price">Rp <?= number_format($total, 0, ',', '.') ?></span>
            </div>
          </div>

          <button type="submit" form="checkout-form" class="btn-submit-order">
            <span class="material-symbols-outlined">check_circle</span>
            Konfirmasi &amp; Buat Pesanan
          </button>
          
          <div class="guarantee-badge">
            <span class="material-symbols-outlined">shield</span>
            Pesanan langsung diteruskan ke dapur setelah dikonfirmasi kasir.
          </div>
        </div>
      </aside>
    </div>
  </main>

  <?php require_once __DIR__ . '/includes/footer.php'; ?>
</body>
</html>
