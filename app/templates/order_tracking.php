<?php
// Order Tracking View
$order = $order ?? null;
$orderItems = $orderItems ?? [];
$orderIdFormatted = 'ORD-' . str_pad($order['id'] ?? 0, 6, '0', STR_PAD_LEFT);
$status = $order['status'] ?? 'pending';
$tableNumber = $order['nomor_meja'] ?? 'T12';
?>
<!DOCTYPE html>
<html lang="id">

<?php require_once __DIR__ . '/includes/header.php'; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/order_tracking.css">

<body class="page-shell font-body">
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-wrapper">
        <a href="<?= BASE_URL ?>/menu" class="brand-logo">Saffron & Sage</a>
        <nav class="nav-links">
          <a class="nav-item" href="<?= BASE_URL ?>/menu">Menu</a>
          <a class="nav-item active" href="<?= BASE_URL ?>/order-tracking">Riwayat</a>
          <a class="nav-item" href="#">Bantuan</a>
        </nav>
        <div class="nav-actions">
          <div class="table-badge">
            <span class="material-symbols-outlined">table_restaurant</span>
            Meja <?= htmlspecialchars($tableNumber) ?>
          </div>
          <a href="/cart" class="action-icon">
            <span class="material-symbols-outlined">shopping_bag</span>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <main class="page-container">
    <?php if ($status === 'cancelled'): ?>
      <div class="status-icon-container">
        <div class="status-main-icon" style="background-color: var(--error-container); color: var(--error);">
          <span class="material-symbols-outlined">cancel</span>
        </div>
      </div>
      <header class="status-header">
        <h1 class="status-title">Pesanan Dibatalkan</h1>
        <p class="status-subtitle">Mohon maaf, pesanan Anda telah dibatalkan oleh restoran.</p>
      </header>
    <?php elseif ($status === 'completed'): ?>
      <div class="status-icon-container">
        <div class="status-main-icon" style="background-color: #c8e6c9; color: #2e7d32;">
          <span class="material-symbols-outlined">task_alt</span>
        </div>
      </div>
      <header class="status-header">
        <h1 class="status-title">Pesanan Selesai</h1>
        <p class="status-subtitle">Terima kasih atas pesanan Anda! Semoga Anda menikmati hidangan kami.</p>
      </header>
    <?php else: ?>
      <div class="status-icon-container">
        <div class="status-main-icon">
          <span class="material-symbols-outlined">restaurant</span>
        </div>
      </div>
      <header class="status-header">
        <h1 class="status-title">Status Pesanan</h1>
        <p class="status-subtitle">Harap tunggu sebentar, koki kami sedang menyiapkan hidangan Anda.</p>
      </header>
    <?php endif; ?>

    <div class="order-info-card">
      <div class="info-grid">
        <div class="info-item">
          <label class="info-label">NOMOR PESANAN</label>
          <div class="info-value"><?= htmlspecialchars($orderIdFormatted) ?></div>
        </div>
        <div class="info-item text-right">
          <label class="info-label">NOMOR MEJA</label>
          <div class="info-value text-primary">Meja <?= htmlspecialchars($tableNumber) ?></div>
        </div>
      </div>
      <div class="eta-badge">
        <span class="material-symbols-outlined">schedule</span>
        <span>Estimasi Penyajian</span>
        <span class="eta-time">
          <?php
          if ($status === 'pending' || $status === 'confirmed') {
              echo '15 - 20 menit';
          } elseif ($status === 'preparing') {
              echo '10 - 15 menit';
          } elseif ($status === 'ready') {
              echo 'Siap saji';
          } else {
              echo 'Selesai';
          }
          ?>
        </span>
      </div>
    </div>

    <!-- Timeline -->
    <?php if ($status !== 'cancelled'): ?>
    <div class="timeline-container">
      <!-- Step 1: Diterima -->
      <?php
      $step1Class = 'pending';
      if ($status === 'pending' || $status === 'confirmed') {
          $step1Class = 'active';
      } elseif (in_array($status, ['preparing', 'ready', 'completed'])) {
          $step1Class = 'completed';
      }
      ?>
      <div class="timeline-item <?= $step1Class ?>">
        <div class="timeline-status">
          <div class="status-circle">
            <span class="material-symbols-outlined">check</span>
          </div>
        </div>
        <div class="timeline-content">
          <h3 class="timeline-title">Pesanan Diterima</h3>
          <p class="timeline-desc">Pesanan Anda telah kami terima dan menunggu konfirmasi kasir.</p>
          <?php if ($step1Class === 'active'): ?>
            <span class="active-badge">PROSES KONFIRMASI</span>
          <?php endif; ?>
        </div>
      </div>

      <!-- Step 2: Sedang Diproses -->
      <?php
      $step2Class = 'pending';
      if ($status === 'preparing') {
          $step2Class = 'active';
      } elseif (in_array($status, ['ready', 'completed'])) {
          $step2Class = 'completed';
      }
      ?>
      <div class="timeline-item <?= $step2Class ?>">
        <div class="timeline-status">
          <div class="status-circle">
            <?php if ($step2Class === 'completed'): ?>
              <span class="material-symbols-outlined">check</span>
            <?php else: ?>
              <span class="material-symbols-outlined">soup_kitchen</span>
            <?php endif; ?>
          </div>
        </div>
        <div class="timeline-content">
          <h3 class="timeline-title">Sedang Diproses</h3>
          <p class="timeline-desc">Koki kami sedang memasak dan meracik bumbu hidangan Anda.</p>
          <?php if ($step2Class === 'active'): ?>
            <span class="active-badge">SEDANG BERLANGSUNG</span>
          <?php endif; ?>
        </div>
      </div>

      <!-- Step 3: Siap Disajikan -->
      <?php
      $step3Class = 'pending';
      if ($status === 'ready') {
          $step3Class = 'active';
      } elseif ($status === 'completed') {
          $step3Class = 'completed';
      }
      ?>
      <div class="timeline-item <?= $step3Class ?>">
        <div class="timeline-status">
          <div class="status-circle">
            <?php if ($step3Class === 'completed'): ?>
              <span class="material-symbols-outlined">check</span>
            <?php else: ?>
              <span class="material-symbols-outlined">restaurant_menu</span>
            <?php endif; ?>
          </div>
        </div>
        <div class="timeline-content">
          <h3 class="timeline-title">Siap Disajikan</h3>
          <p class="timeline-desc">Hidangan hangat siap diantar ke meja makan Anda.</p>
          <?php if ($step3Class === 'active'): ?>
            <span class="active-badge">SIAP DIANTAR</span>
          <?php endif; ?>
        </div>
      </div>

      <!-- Step 4: Selesai -->
      <?php $step4Class = ($status === 'completed') ? 'completed' : 'pending'; ?>
      <div class="timeline-item <?= $step4Class ?>">
        <div class="timeline-status">
          <div class="status-circle">
            <span class="material-symbols-outlined">sports_bar</span>
          </div>
        </div>
        <div class="timeline-content">
          <h3 class="timeline-title">Selesai</h3>
          <p class="timeline-desc">Selamat menikmati makanan! Silakan bayar ke kasir setelah bersantap.</p>
        </div>
      </div>
    </div>
    <?php endif; ?>

    <!-- Action Buttons -->
    <div class="action-buttons">
      <a href="<?= BASE_URL ?>/menu" class="btn-primary inline-flex items-center justify-center gap-2 shadow-soft transition hover:-translate-y-0.5">
        <span class="material-symbols-outlined">shopping_cart</span>
        Pesan Menu Lain
      </a>
      <button class="btn-secondary">
        <span class="material-symbols-outlined">support_agent</span>
        Butuh Bantuan
      </button>
    </div>

    <p class="auto-refresh-text">Halaman ini diperbarui secara otomatis tiap 5 detik</p>
  </main>
  <?php require_once __DIR__ . '/includes/footer.php'; ?>

  <?php if ($order && $status !== 'completed' && $status !== 'cancelled'): ?>
    <script>
      const orderId = <?= (int) $order['id'] ?>;
      const BASE_URL = '<?= BASE_URL ?>';
      const currentStatus = '<?= $status ?>';

      async function checkOrderStatus() {
        try {
          const response = await fetch(BASE_URL + '/order/status?order_id=' + orderId);
          const data = await response.json();
          
          if (data.success && data.status) {
            if (data.status !== currentStatus) {
              window.location.reload();
            }
          }
        } catch (err) {
          console.error('Error polling status:', err);
        }
      }

      // Poll status every 5 seconds
      setInterval(checkOrderStatus, 5000);
    </script>
  <?php endif; ?>
</body>

</html>