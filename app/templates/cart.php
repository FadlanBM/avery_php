<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8" />
  <meta content="width=device-width, initial-scale=1.0" name="viewport" />
  <title>Keranjang Belanja | Saffron &amp; Sage</title>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&family=Be+Vietnam+Pro:wght@300;400;500;600&display=swap" rel="stylesheet" />
  <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
  <link rel="stylesheet" href="/assets/css/tailwind.css">
  <link rel="stylesheet" href="/assets/css/cart.css">
</head>

<body class="page-shell font-body">
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-wrapper">
        <div class="brand-logo">Sensory Hearth</div>
        <nav class="nav-links">
          <a class="nav-item" href="/">Menu</a>
          <a class="nav-item" href="#">Riwayat</a>
          <a class="nav-item" href="#">Bantuan</a>
        </nav>
        <div class="nav-actions">
          <div class="table-badge">
            <span class="material-symbols-outlined">table_restaurant</span>
            Meja 112
          </div>
          <a href="/cart" class="action-icon active">
            <span class="material-symbols-outlined">shopping_bag</span>
          </a>
          <div class="action-icon">
            <span class="material-symbols-outlined">account_circle</span>
          </div>
        </div>
      </div>
    </div>
  </nav>

  <main class="page-container">
    <header class="cart-header">
      <h1 class="cart-title">Keranjang Belanja</h1>
      <p class="cart-subtitle">Tinjau pesanan Anda sebelum kami sajikan dengan sepenuh hati.</p>
    </header>

    <div class="cart-grid">
      <!-- Cart Items -->
      <div class="cart-items-section">
        <div class="cart-item-card">
          <div class="item-visual">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuA3SJ3UQH9L-9QO_DZC5-e-eRGLh6XbUJslIM0LI_kSVAMpb90Yn4pwY5f-Vdkf5CZgQeh50JbceGhsDbuOhWwJ0A1BIcXsSaQRnf5nTSImtFhAQaBOeUMVI-zpvvc6JstuJHtIg0_HQU9pn_PKRilTv5u74Wfk3Rp7qFGrVIPfzl3EQf8C1HJVNd36YPPmtRE8E5PpJ_7FX5fExgJdEHSuJ-iem2LlEEPc8E-ZWeKFfZAwkFQrPjC-iN30ztmNjbbkFJ3aQBFr5KdQ" alt="Salmon Zen Bowl">
          </div>
          <div class="item-details">
            <div class="item-header">
              <h3 class="item-name">Salmon Zen Bowl</h3>
              <span class="item-price">Rp 85.000</span>
            </div>
            <p class="item-desc">Nasi organik, salmon segar, saus wijen sangrai.</p>
            <div class="item-footer">
              <div class="note-input-group">
                <label class="note-label">CATATAN</label>
                <input type="text" class="note-input" placeholder="Contoh: Tanpa bawang...">
              </div>
              <div class="quantity-selector">
                <button class="qty-btn">-</button>
                <span class="qty-value">1</span>
                <button class="qty-btn primary">+</button>
              </div>
            </div>
          </div>
        </div>

        <div class="cart-item-card">
          <div class="item-visual">
            <img src="https://lh3.googleusercontent.com/aida-public/AB6AXuDwXy-x3vaP4w6WxEPpQgKoHF6Xbw-trgKAkzMLP-REdcbC8LkOWUPYL-u5sVyi7Yv0Vxj7dR5bIznow__hsrfVTF3GApFokb5xVKxd9OUgBV7sMvt5kmdJ9qgnwfqVm06UnTQBp3y6Nq2w_kRdsUixsAtPiZyFzu09vz_wtG97Uy7GCWX_MQIFGeYO8BY1KNKMnyZmiMR_QDrHrA5eDHXISUAfPlwxZeCp0ktWIlpRo4eVYwC8b3EeNnyoF54kH6M0hg212wuJ8k1h" alt="Spiced Saffron Latte">
          </div>
          <div class="item-details">
            <div class="item-header">
              <h3 class="item-name">Spiced Saffron Latte</h3>
              <span class="item-price">Rp 42.000</span>
            </div>
            <p class="item-desc">Espresso arabika dengan sentuhan saffron premium.</p>
            <div class="item-footer">
              <div class="note-input-group">
                <label class="note-label">CATATAN</label>
                <input type="text" class="note-input" value="Less sugar" placeholder="Contoh: Tanpa bawang...">
              </div>
              <div class="quantity-selector">
                <button class="qty-btn">-</button>
                <span class="qty-value">2</span>
                <button class="qty-btn primary">+</button>
              </div>
            </div>
          </div>
        </div>

        <!-- Upsell Banner -->
        <div class="upsell-banner">
          <div class="upsell-content">
            <h3 class="upsell-title">Lengkapi santapan Anda?</h3>
            <p class="upsell-desc">Nikmati kelembutan Pistachio Baklava kami yang baru saja keluar dari oven.</p>
            <button class="btn-upsell">
              <span class="material-symbols-outlined">add_circle</span>
              Tambah ke Keranjang
            </button>
          </div>
          <div class="upsell-visual">
            <span class="material-symbols-outlined ice-cream">icecream</span>
          </div>
        </div>
      </div>

      <!-- Order Summary -->
      <aside class="summary-section">
        <div class="summary-card">
          <h2 class="summary-title">Ringkasan Pesanan</h2>
          <div class="summary-rows">
            <div class="summary-row">
              <span>Subtotal</span>
              <span>Rp 169.000</span>
            </div>
            <div class="summary-row">
              <span>Pajak (10%)</span>
              <span>Rp 16.900</span>
            </div>
            <div class="summary-row">
              <span>Biaya Layanan</span>
              <span>Rp 5.000</span>
            </div>
          </div>
          <div class="summary-divider"></div>
          <div class="total-row">
            <span class="total-label">Total Pembayaran</span>
            <span class="total-value">Rp 190.900</span>
          </div>
          <button class="btn-checkout inline-flex items-center justify-center gap-2 shadow-soft transition hover:-translate-y-0.5">
            Buat Pesanan
            <span class="material-symbols-outlined">arrow_forward</span>
          </button>
          <div class="payment-badge">
            <span class="material-symbols-outlined">verified_user</span>
            Pembayaran Aman &amp; Terinkripsi
          </div>
          <p class="terms-text">
            Dengan menekan tombol, Anda menyetujui <br>
            <a href="#">Syarat &amp; Ketentuan</a> Saffron &amp; Sage.
          </p>
        </div>

        <div class="promo-card">
          <div class="promo-content">
            <span class="material-symbols-outlined">loyalty</span>
            <span>Gunakan Promo</span>
          </div>
          <span class="material-symbols-outlined">chevron_right</span>
        </div>
      </aside>
    </div>
  </main>

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
        © 2024 Saffron &amp; Sage Culinary Editorial. Rasa yang Bercerita.
      </div>
    </div>
  </footer>
</body>

</html>
