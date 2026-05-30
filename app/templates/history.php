<?php
// History View
$ordersWithItems = $ordersWithItems ?? [];
$tableNumber = $tableNumber ?? 'T12';
?>
<!DOCTYPE html>
<html lang="id">

<?php require_once __DIR__ . '/includes/header.php'; ?>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/history.css">

<body class="page-shell font-body">
  <nav class="navbar">
    <div class="nav-container">
      <div class="nav-wrapper">
        <a href="<?= BASE_URL ?>/menu" class="brand-logo">Saffron & Sage</a>
        <nav class="nav-links">
          <a class="nav-item" href="<?= BASE_URL ?>/menu">Menu</a>
          <a class="nav-item active" href="<?= BASE_URL ?>/history">Riwayat</a>
          <a class="nav-item" href="#">Bantuan</a>
        </nav>
        <div class="nav-actions">
          <div class="table-badge">
            <span class="material-symbols-outlined">table_restaurant</span>
            Meja <?= htmlspecialchars($tableNumber) ?>
          </div>
          <a href="<?= BASE_URL ?>/cart" class="action-icon">
            <span class="material-symbols-outlined">shopping_bag</span>
          </a>
        </div>
      </div>
    </div>
  </nav>

  <main class="page-container">
    <header class="page-header">
      <h1 class="page-title font-headline">Riwayat Pesanan Saya</h1>
      <p class="page-subtitle">Daftar semua pesanan Anda selama sesi kunjungan ini</p>
    </header>

    <?php if (empty($ordersWithItems)): ?>
      <div class="empty-state">
        <span class="material-symbols-outlined empty-icon">receipt_long</span>
        <h3 class="empty-title font-headline">Belum Ada Pesanan</h3>
        <p class="empty-desc">Anda belum melakukan pemesanan dalam sesi kunjungan ini.</p>
        <a href="<?= BASE_URL ?>/menu" class="btn-primary-custom">
          <span class="material-symbols-outlined">restaurant_menu</span> Mulai Pesan
        </a>
      </div>
    <?php else: ?>
      <div class="orders-list">
        <?php foreach ($ordersWithItems as $entry): ?>
          <?php 
            $order = $entry['order']; 
            $items = $entry['items'];
            $status = $order['status'] ?? 'pending';
            $orderIdFormatted = 'ORD-' . str_pad($order['id'] ?? 0, 6, '0', STR_PAD_LEFT);
            
            // Map status and colors
            $statusLabel = 'Menunggu Konfirmasi';
            $statusClass = 'status-pending';
            if ($status === 'confirmed') {
                $statusLabel = 'Dikonfirmasi';
                $statusClass = 'status-confirmed';
            } elseif ($status === 'preparing') {
                $statusLabel = 'Sedang Dimasak';
                $statusClass = 'status-preparing';
            } elseif ($status === 'ready') {
                $statusLabel = 'Siap Disajikan';
                $statusClass = 'status-ready';
            } elseif ($status === 'completed') {
                $statusLabel = 'Selesai';
                $statusClass = 'status-completed';
            } elseif ($status === 'cancelled') {
                $statusLabel = 'Dibatalkan';
                $statusClass = 'status-cancelled';
            }
          ?>
          <div class="order-card <?= $status === 'completed' ? 'order-card-completed' : '' ?>" id="order-card-<?= $order['id'] ?>">
            <div class="order-card-header">
              <div class="header-left">
                <h3 class="order-id font-headline"><?= $orderIdFormatted ?></h3>
                <span class="status-badge <?= $statusClass ?>"><?= $statusLabel ?></span>
              </div>
              <div class="header-right">
                <span class="order-time"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></span>
                <span class="order-table-badge">
                  <span class="material-symbols-outlined text-sm">table_restaurant</span> Meja <?= htmlspecialchars($order['nomor_meja'] ?? $tableNumber) ?>
                </span>
              </div>
            </div>

            <div class="order-card-body">
              <div class="items-summary-list">
                <?php foreach ($items as $item): ?>
                  <div class="item-row">
                    <div class="item-info">
                      <div class="item-image-wrapper">
                        <?php if (!empty($item['image_path'])): ?>
                          <img src="<?= BASE_URL . htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['name']) ?>" class="item-image">
                        <?php else: ?>
                          <div class="item-image-placeholder">
                            <span class="material-symbols-outlined">restaurant</span>
                          </div>
                        <?php endif; ?>
                      </div>
                      <div class="item-text">
                        <p class="item-name font-headline"><?= htmlspecialchars($item['quantity']) ?>x <?= htmlspecialchars($item['name']) ?></p>
                        <?php if (!empty($item['description'])): ?>
                          <p class="item-desc"><?= htmlspecialchars($item['description']) ?></p>
                        <?php endif; ?>
                      </div>
                    </div>
                  </div>
                <?php endforeach; ?>
              </div>

              <div class="order-payment-info">
                <span class="payment-label">Metode Pembayaran</span>
                <span class="payment-value">
                  <?php 
                    $paymentName = $order['payment_method_name'] ?? 'Tunai';
                    $isCash = stripos($paymentName, 'tunai') !== false || stripos($paymentName, 'cash') !== false;
                    $paymentIcon = 'credit_card';
                    if ($isCash) {
                        $paymentIcon = 'payments';
                    } elseif (stripos($paymentName, 'qris') !== false) {
                        $paymentIcon = 'qr_code_2';
                    }
                  ?>
                  <span class="material-symbols-outlined text-sm"><?= $paymentIcon ?></span> <?= htmlspecialchars($paymentName) ?>
                </span>
                <?php if (!empty($order['payment_code'])): ?>
                  <span class="payment-code-badge">Kode: <?= htmlspecialchars($order['payment_code']) ?></span>
                <?php endif; ?>
              </div>
            </div>

            <div class="order-card-footer">
              <div class="total-section">
                <span class="total-label">Total Tagihan</span>
                <span class="total-value font-headline">Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></span>
              </div>
              <div class="action-buttons">
                <?php if ($status === 'pending'): ?>
                  <button class="btn-cancel font-headline" onclick="cancelOrder(<?= $order['id'] ?>)">Batalkan</button>
                <?php endif; ?>
                
                <?php if (in_array($status, ['pending', 'confirmed', 'preparing', 'ready'])): ?>
                  <a href="<?= BASE_URL ?>/order-tracking?order_id=<?= $order['id'] ?>" class="btn-track font-headline">
                    <span class="material-symbols-outlined">monitoring</span> Pantau Pesanan
                  </a>
                <?php else: ?>
                  <a href="<?= BASE_URL ?>/order-tracking?order_id=<?= $order['id'] ?>" class="btn-detail font-headline">Lihat Detail</a>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </main>

  <!-- Floating Toast Notification -->
  <div class="toast-notification" id="toast">
    <span class="material-symbols-outlined toast-icon">check_circle</span>
    <span class="toast-message" id="toast-message">Data riwayat berhasil diperbarui.</span>
  </div>

  <script>
    function showToast(message, isSuccess = true) {
      const toast = document.getElementById('toast');
      const toastMsg = document.getElementById('toast-message');
      const toastIcon = toast.querySelector('.toast-icon');
      
      toastMsg.textContent = message;
      if (isSuccess) {
        toastIcon.textContent = 'check_circle';
        toastIcon.style.color = 'var(--secondary)';
      } else {
        toastIcon.textContent = 'error';
        toastIcon.style.color = 'var(--error)';
      }
      
      toast.classList.add('show');
      setTimeout(() => {
        toast.classList.remove('show');
      }, 3000);
    }

    function cancelOrder(orderId) {
      if (!confirm('Apakah Anda yakin ingin membatalkan pesanan ini?')) {
        return;
      }
      
      const formData = new FormData();
      formData.append('order_id', orderId);

      fetch('<?= BASE_URL ?>/order/cancel', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        if (data.success) {
          showToast(data.message || 'Pesanan berhasil dibatalkan.', true);
          // Reload page after a short delay
          setTimeout(() => {
            window.location.reload();
          }, 1500);
        } else {
          showToast(data.message || 'Gagal membatalkan pesanan.', false);
        }
      })
      .catch(error => {
        console.error('Error:', error);
        showToast('Terjadi kesalahan koneksi.', false);
      });
    }

    // Auto show updated toast if refreshed or loaded
    window.addEventListener('load', () => {
      setTimeout(() => {
        showToast('Data riwayat berhasil diperbarui.', true);
      }, 500);
    });
  </script>
</body>
</html>
