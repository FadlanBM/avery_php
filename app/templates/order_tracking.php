<!DOCTYPE html>
<html lang="id">

<?php require_once __DIR__ . '/includes/navbar.php'; ?>

<body class="page-shell font-body">
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-wrapper">
        <div class="brand-logo">Sensory Hearth</div>
        <nav class="nav-links">
          <a class="nav-item" href="/">Menu</a>
          <a class="nav-item" href="#" class="active">Riwayat</a>
          <a class="nav-item" href="#">Bantuan</a>
        </nav>
        <div class="nav-actions">
          <a href="/cart" class="action-icon">
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
    <div class="status-icon-container">
      <div class="status-main-icon">
        <span class="material-symbols-outlined">restaurant</span>
      </div>
    </div>

    <header class="status-header">
      <h1 class="status-title">Status Pesanan</h1>
      <p class="status-subtitle">Harap tunggu sebentar, koki kami sedang menyiapkan hidangan Anda.</p>
    </header>

    <div class="order-info-card">
      <div class="info-grid">
        <div class="info-item">
          <label class="info-label">NOMOR PESANAN</label>
          <div class="info-value">ORD-240325-1021</div>
        </div>
        <div class="info-item text-right">
          <label class="info-label">NOMOR MEJA</label>
          <div class="info-value text-primary">Meja T12</div>
        </div>
      </div>
      <div class="eta-badge">
        <span class="material-symbols-outlined">schedule</span>
        <span>Estimasi Penyajian</span>
        <span class="eta-time">10 - 15 menit</span>
      </div>
    </div>

    <div class="timeline-container">
      <div class="timeline-item completed">
        <div class="timeline-status">
          <div class="status-circle">
            <span class="material-symbols-outlined">check</span>
          </div>
        </div>
        <div class="timeline-content">
          <h3 class="timeline-title">Diterima</h3>
          <p class="timeline-desc">Pesanan Anda telah kami terima dan masuk antrean.</p>
          <span class="timeline-time">12:48 PM</span>
        </div>
      </div>

      <div class="timeline-item active">
        <div class="timeline-status">
          <div class="status-circle"></div>
        </div>
        <div class="timeline-content">
          <h3 class="timeline-title">Sedang Diproses</h3>
          <p class="timeline-desc">Koki kami sedang meracik bumbu dan memasak hidangan.</p>
          <span class="active-badge">SEDANG BERLANGSUNG</span>
        </div>
      </div>

      <div class="timeline-item pending">
        <div class="timeline-status">
          <div class="status-circle">
            <span class="material-symbols-outlined">restaurant_menu</span>
          </div>
        </div>
        <div class="timeline-content">
          <h3 class="timeline-title">Diantar ke Meja</h3>
          <p class="timeline-desc">Hidangan hangat akan segera meluncur ke Meja T12.</p>
        </div>
      </div>
    </div>

    <div class="action-buttons">
      <a href="/menu" class="btn-primary inline-flex items-center justify-center gap-2 shadow-soft transition hover:-translate-y-0.5">
        <span class="material-symbols-outlined">shopping_cart</span>
        Pesan Menu Lain
      </a>
      <button class="btn-secondary">
        <span class="material-symbols-outlined">support_agent</span>
        Butuh Bantuan
      </button>
    </div>

    <p class="auto-refresh-text">Halaman ini akan diperbarui secara otomatis</p>
  </main>
  <?php require_once __DIR__ . '/includes/footer.php'; ?>
</body>

</html>