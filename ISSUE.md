# ISSUE: Halaman Riwayat Transaksi Berdasarkan Session Pelanggan

## Ringkasan

Setiap pelanggan yang scan QR meja akan memiliki **session unik** (`cart_session_id`) yang tersimpan di browser mereka. Fitur ini menambahkan halaman `/history` yang menampilkan **semua pesanan yang dibuat oleh session tersebut** — lengkap dengan status, total harga, daftar menu yang dipesan, dan tanggal transaksi. Dengan fitur ini, pelanggan bisa memantau riwayat semua pesanannya selama satu sesi kunjungan ke restoran.

---

## Latar Belakang Masalah

Saat ini, halaman `/order-tracking` hanya menampilkan **satu pesanan aktif** berdasarkan `order_id` yang dikirim via URL query string (`?order_id=X`). Tidak ada halaman yang memungkinkan pelanggan melihat **semua transaksi** yang sudah mereka buat dalam satu sesi kunjungan.

Contoh skenario: pelanggan memesan minuman dahulu, lalu beberapa menit kemudian memesan makanan. Keduanya tercatat sebagai order terpisah, dan saat ini tidak ada halaman yang menampilkan keduanya sekaligus.

---

## Tujuan Fitur

1. Buat halaman `/history` yang menampilkan daftar semua order milik `$_SESSION['cart_session_id']`
2. Setiap order menampilkan: nomor pesanan, status, metode pembayaran, total, dan item yang dipesan
3. Navigasi dari navbar dan tombol di halaman `order-tracking` menuju halaman riwayat
4. Tampilan yang responsif dan konsisten dengan design system yang sudah ada

---

## Spesifikasi Teknis

### 1. Data yang Ditampilkan per Order

| Field | Sumber | Keterangan |
|-------|--------|------------|
| Nomor Pesanan | `order.id` | Format `ORD-000001` |
| Waktu Pesan | `order.created_at` | Format tanggal + jam |
| Nomor Meja | `restaurant_table.nomor_meja` | JOIN dengan `restaurant_table` |
| Metode Bayar | `payment_method.name` | JOIN dengan `payment_method` |
| Status | `order.status` | Badge berwarna sesuai status |
| Total Tagihan | `order.total_amount` | Format Rupiah |
| Daftar Item | `order_item` JOIN `restaurant_menu` | Nama menu + qty + harga satuan |
| Kode Bayar | `order.payment_code` | Tampil jika tidak NULL (tunai) |

### 2. Status Badge & Warna

| Status | Label | Warna |
|--------|-------|-------|
| `pending` | Menunggu Konfirmasi | Kuning / Warning |
| `confirmed` | Dikonfirmasi | Biru / Info |
| `preparing` | Sedang Dimasak | Orange |
| `ready` | Siap Disajikan | Hijau muda |
| `completed` | Selesai | Hijau |
| `cancelled` | Dibatalkan | Merah |

---

## File yang Perlu Dibuat / Dimodifikasi

### A. Controller Baru `[BUAT BARU]`
**File:** `app/src/Controllers/HistoryController.php`

Controller ini menerima GET request ke `/history`, memastikan session ID ada, mengambil semua order milik session tersebut beserta item-itemnya, lalu merender template.

```php
<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class HistoryController extends Controller
{
    public function index()
    {
        // 1. Ambil session ID (dibuat di CartController/CheckoutController)
        $sessionId = $_SESSION['cart_session_id'] ?? null;

        if (!$sessionId) {
            // Tidak ada session, redirect ke menu
            header('Location: ' . BASE_URL . '/menu');
            return;
        }

        // 2. Ambil semua order milik session ini (urut dari terbaru)
        $orderModel = new OrderModel();
        $orders = $orderModel->getOrdersBySession($sessionId);

        // 3. Untuk setiap order, ambil juga item-itemnya
        $orderItemModel = new OrderItemModel();
        $ordersWithItems = [];
        foreach ($orders as $order) {
            $items = $orderItemModel->getItemsWithMenuDetails($order['id']);
            $ordersWithItems[] = [
                'order' => $order,
                'items' => $items,
            ];
        }

        // 4. Render template
        return $this->view('history', [
            'title'          => 'Riwayat Pesanan',
            'ordersWithItems' => $ordersWithItems,
            'sessionId'      => $sessionId,
        ]);
    }
}
```

**Penjelasan:**
- Method `getOrdersBySession()` sudah ada di `OrderModel.php` — tinggal dipakai
- Method `getItemsWithMenuDetails()` sudah ada di `OrderItemModel.php` — tinggal dipakai
- Tidak ada logika baru yang kompleks, hanya merakit data dari model yang ada

---

### B. Template Halaman `[BUAT BARU]`
**File:** `app/templates/history.php`

Struktur template:
1. **Navbar** — sama dengan halaman lain (`order-tracking`, `cart`)
2. **Header Halaman** — judul "Riwayat Pesanan Saya" + info meja
3. **Jika tidak ada order** — tampilkan pesan kosong dengan tombol kembali ke menu
4. **Daftar Order Card** — untuk setiap order, tampilkan:
   - Header card: nomor pesanan, waktu, status badge
   - Info meja + metode pembayaran
   - Daftar item yang dipesan (nama, qty, harga satuan)
   - Footer card: subtotal, pajak, service charge, **total tagihan**
   - Tombol "Lihat Detail" → menuju `/order-tracking?order_id=X`
   - Jika `payment_code` ada: tampilkan tombol/link "Tampilkan QR Bayar" → menuju `/order-tracking?order_id=X` (karena QR ada di halaman tracking)

Gambaran struktur HTML:
```html
<main class="history-container">
  <header class="history-header">
    <h1>Riwayat Pesanan</h1>
    <p>Semua pesanan Anda selama kunjungan ini</p>
  </header>

  <?php if (empty($ordersWithItems)): ?>
    <!-- Tampilan kosong -->
    <div class="empty-state">
      <span class="material-symbols-outlined">receipt_long</span>
      <p>Belum ada pesanan dalam sesi ini</p>
      <a href="<?= BASE_URL ?>/menu" class="btn-primary">Lihat Menu</a>
    </div>

  <?php else: ?>
    <?php foreach ($ordersWithItems as $entry): ?>
      <?php $order = $entry['order']; $items = $entry['items']; ?>
      <div class="order-card">

        <!-- Header Card -->
        <div class="order-card-header">
          <div>
            <span class="order-number">ORD-<?= str_pad($order['id'], 6, '0', STR_PAD_LEFT) ?></span>
            <span class="order-date"><?= date('d M Y, H:i', strtotime($order['created_at'])) ?></span>
          </div>
          <span class="status-badge status-<?= $order['status'] ?>">
            <!-- Label status (lihat tabel status di atas) -->
          </span>
        </div>

        <!-- Info Meja & Pembayaran -->
        <div class="order-meta">
          <span>Meja <?= $order['nomor_meja'] ?></span>
          <span><?= $order['payment_method_name'] ?></span>
        </div>

        <!-- Daftar Item -->
        <ul class="item-list">
          <?php foreach ($items as $item): ?>
            <li class="item-row">
              <span class="item-name"><?= $item['name'] ?></span>
              <span class="item-qty">x<?= $item['quantity'] ?></span>
              <span class="item-price">Rp <?= number_format($item['unit_price'], 0, ',', '.') ?></span>
            </li>
          <?php endforeach; ?>
        </ul>

        <!-- Footer Card: Total -->
        <div class="order-card-footer">
          <div class="price-breakdown">
            <div>Subtotal: Rp <?= number_format($order['subtotal'], 0, ',', '.') ?></div>
            <div>Pajak 10%: Rp <?= number_format($order['tax_amount'], 0, ',', '.') ?></div>
            <div>Service: Rp <?= number_format($order['service_charge'], 0, ',', '.') ?></div>
            <div class="grand-total">Total: Rp <?= number_format($order['total_amount'], 0, ',', '.') ?></div>
          </div>
          <a href="<?= BASE_URL ?>/order-tracking?order_id=<?= $order['id'] ?>" class="btn-detail">
            Lihat Detail & Tracking
          </a>
        </div>

      </div>
    <?php endforeach; ?>
  <?php endif; ?>
</main>
```

---

### C. CSS Baru `[BUAT BARU]`
**File:** `assets/css/history.css`

Gaya yang dibutuhkan:
- `.history-container` — max-width, padding, margin auto
- `.history-header` — judul besar + deskripsi kecil
- `.empty-state` — centered, icon besar, teks kosong, tombol CTA
- `.order-card` — card dengan shadow, border-radius, margin-bottom
- `.order-card-header` — flex row antara nomor pesanan dan badge status
- `.status-badge` — pill label dengan warna berbeda per status
  - `.status-pending` → kuning
  - `.status-confirmed` → biru
  - `.status-preparing` → orange
  - `.status-ready` → hijau muda
  - `.status-completed` → hijau gelap
  - `.status-cancelled` → merah
- `.order-meta` — flex row info meja + metode bayar, ukuran kecil
- `.item-list` — list tanpa bullet, dengan gap
- `.item-row` — flex row antara nama, qty, harga
- `.order-card-footer` — flex antara breakdown harga dan tombol
- `.grand-total` — teks besar, bold, warna primary
- `.btn-detail` — tombol sekunder (outline/ghost style)

Semua token warna dan radius menggunakan CSS custom properties yang sudah ada di `style.css` dan `cart.css` (contoh: `var(--primary)`, `var(--radius-2xl)`, `var(--surface-container-lowest)`).

---

### D. Route Baru `[MODIFIKASI]`
**File:** `index.php`

```php
// History Routes
$router->get('/history', [\App\Controllers\HistoryController::class, 'index']);
```

Letakkan bersama route pelanggan lainnya (dekat `/cart`, `/checkout`, `/order-tracking`).

---

### E. Link Navigasi `[MODIFIKASI]`
Tambahkan link "Riwayat" di navbar pada halaman-halaman pelanggan:

**File:** `app/templates/order_tracking.php` (dan `cart.php`, `checkout.php`)

```html
<!-- Di dalam <nav class="nav-links"> -->
<a class="nav-item" href="<?= BASE_URL ?>/history">Riwayat</a>
```

---

## Urutan Implementasi (Step-by-Step)

- [ ] **Step 1** — Buat `HistoryController.php`
- [ ] **Step 2** — Buat `history.php` template
- [ ] **Step 3** — Buat `history.css` stylesheet
- [ ] **Step 4** — Tambah route `/history` di `index.php`
- [ ] **Step 5** — Tambah link navigasi "Riwayat" di navbar `order_tracking.php`, `cart.php`, dan `checkout.php`
- [ ] **Step 6** — Uji coba: buat pesanan → cek `/history` → verifikasi semua order muncul

---

## Alur Lengkap (Setelah Implementasi)

```
1. Pelanggan scan QR → session dibuat otomatis
2. Pelanggan memesan (bisa berkali-kali dalam satu sesi)
3. Pelanggan klik "Riwayat" di navbar
4. Sistem baca $_SESSION['cart_session_id'] → ambil semua order
5. Halaman /history tampil: daftar semua order + item + total + status
6. Pelanggan klik "Lihat Detail" → diarahkan ke /order-tracking?order_id=X
```

---

## Catatan Penting

> **Tidak butuh login:** Identitas pelanggan dikenali dari `$_SESSION['cart_session_id']` yang sudah ada di sistem. Tidak ada perubahan pada sistem autentikasi.

> **Model sudah siap:** `OrderModel::getOrdersBySession()` dan `OrderItemModel::getItemsWithMenuDetails()` sudah tersedia — tidak perlu menambah method baru di model manapun.

> **Keamanan:** Setiap request ke `/history` hanya menampilkan order yang session_id-nya sesuai dengan session browser pelanggan saat ini. Pelanggan tidak bisa melihat pesanan orang lain.

---

## Referensi File Terkait

| File | Relevansi |
|------|-----------|
| `app/src/Models/OrderModel.php` | `getOrdersBySession()` sudah ada |
| `app/src/Models/OrderItemModel.php` | `getItemsWithMenuDetails()` sudah ada |
| `app/templates/order_tracking.php` | Referensi desain navbar dan card |
| `app/templates/cart.php` | Referensi desain navbar |
| `assets/css/order_tracking.css` | Referensi token warna dan komponen |
| `assets/css/cart.css` | Referensi card style |
| `index.php` | Tempat mendaftarkan route baru |
