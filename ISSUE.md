# ISSUE: Tambah Kolom `payment_code` pada Tabel `order` untuk Pembayaran Tunai via QR

## Ringkasan

Ketika pelanggan memilih metode pembayaran **tunai (cash)**, sistem harus otomatis menghasilkan **kode unik** yang dikonversi menjadi **QR Code**. QR code ini kemudian ditunjukkan oleh pelanggan ke kasir sebagai bukti dan referensi pesanan, sehingga kasir bisa langsung scan dan memproses pembayaran tanpa perlu input manual nomor pesanan.

---

## Latar Belakang Masalah

Saat ini tabel `order` belum memiliki kolom untuk menyimpan kode unik pembayaran. Alur pembayaran tunai masih manual — kasir harus mencari pesanan berdasarkan nomor meja atau ID pesanan, yang rawan human error.

Dengan adanya `payment_code`, alur menjadi:
```
Pelanggan checkout (pilih tunai) → Sistem generate kode unik → QR ditampilkan di halaman order-tracking → Kasir scan QR → Langsung ketemu pesanan yang tepat
```

---

## Tujuan

1. Tambah kolom `payment_code` di tabel `order` (migrasi ALTER TABLE)
2. Generate kode unik otomatis saat checkout dengan metode tunai
3. Tampilkan QR code dari `payment_code` di halaman **order-tracking** pelanggan
4. Sediakan endpoint kasir untuk lookup pesanan berdasarkan `payment_code`

---

## Spesifikasi Teknis

### 1. Struktur Kolom Baru

| Kolom | Tipe | Keterangan |
|-------|------|------------|
| `payment_code` | `VARCHAR(32)` | Kode unik alphanumerik, NULL jika bukan tunai, UNIQUE |

**Format kode:** `PAY-{YYYYMMDD}-{8 karakter acak}` → contoh: `PAY-20260530-A3F9K2X1`

**Aturan:**
- Hanya diisi jika `payment_method` adalah tunai/cash
- `NULL` untuk metode transfer, QRIS, atau non-cash lainnya
- Kolom `UNIQUE` agar tidak ada duplikat
- Tidak bisa diubah setelah dibuat

---

### 2. File yang Perlu Dibuat / Dimodifikasi

#### A. Migrasi Baru `[BUAT BARU]`
**File:** `app/database/migrations/2026_05_30_000004_AddPaymentCodeToOrder.php`

```php
<?php
use App\Core\Database;

class AddPaymentCodeToOrder
{
    public function up()
    {
        $db = Database::getInstance()->getConnection();
        $driver = $db->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $tableName = $driver === 'pgsql' ? '"order"' : '`order`';

        // ALTER TABLE untuk menambah kolom payment_code
        $db->exec("ALTER TABLE {$tableName}
            ADD COLUMN IF NOT EXISTS payment_code VARCHAR(32) UNIQUE DEFAULT NULL
        ");

        echo "Kolom payment_code berhasil ditambahkan ke tabel order.\n";
    }

    public function down()
    {
        $db = Database::getInstance()->getConnection();
        $driver = $db->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $tableName = $driver === 'pgsql' ? '"order"' : '`order`';

        $db->exec("ALTER TABLE {$tableName} DROP COLUMN IF EXISTS payment_code");
        echo "Kolom payment_code berhasil dihapus.\n";
    }
}
```

**Cara jalankan:**
```bash
docker exec devilbox-php-1 php /shared/httpd/avery_php/htdocs/bin/migrate.php
```

---

#### B. Helper untuk Generate Kode `[BUAT BARU]`
**File:** `app/src/Helpers/PaymentCodeHelper.php`

```php
<?php
namespace App\Helpers;

class PaymentCodeHelper
{
    /**
     * Generate kode unik pembayaran tunai
     * Format: PAY-YYYYMMDD-XXXXXXXX (8 karakter acak huruf besar + angka)
     */
    public static function generate(): string
    {
        $date = date('Ymd');
        $random = strtoupper(substr(bin2hex(random_bytes(4)), 0, 8));
        return "PAY-{$date}-{$random}";
    }

    /**
     * Cek apakah nama payment method termasuk tunai/cash
     */
    public static function isCash(string $paymentMethodName): bool
    {
        $cashKeywords = ['tunai', 'cash'];
        $lowerName = strtolower($paymentMethodName);
        foreach ($cashKeywords as $keyword) {
            if (str_contains($lowerName, $keyword)) {
                return true;
            }
        }
        return false;
    }
}
```

---

#### C. Modifikasi `CheckoutController.php` `[MODIFIKASI]`
**File:** `app/src/Controllers/CheckoutController.php`

Di method `process()`, tambahkan logika generate `payment_code`:

```php
// Di dalam method process(), setelah validasi payment_method_id:

// Ambil nama payment method untuk cek apakah tunai
$paymentMethod = $paymentMethodModel->find($paymentMethodId);
$paymentMethodName = $paymentMethod->name ?? '';

// Generate payment_code hanya untuk pembayaran tunai
$paymentCode = null;
if (\App\Helpers\PaymentCodeHelper::isCash($paymentMethodName)) {
    // Generate dengan retry jika kode sudah ada (sangat jarang terjadi)
    do {
        $paymentCode = \App\Helpers\PaymentCodeHelper::generate();
        $existing = $orderModel->firstWhere('payment_code', $paymentCode);
    } while ($existing !== null);
}

// Sertakan payment_code saat membuat order:
$orderId = $orderModel->create([
    'cart_id'              => $cart['id'],
    'session_id'           => $sessionId,
    'restaurant_table_id'  => $_SESSION['table_id'] ?? null,
    'payment_method_id'    => $paymentMethodId,
    'status'               => 'pending',
    'notes'                => $notes,
    'subtotal'             => $subtotal,
    'tax_amount'           => $tax,
    'service_charge'       => $serviceCharge,
    'total_amount'         => $total,
    'payment_code'         => $paymentCode,  // NULL jika bukan tunai
]);
```

---

#### D. Modifikasi `order_tracking.php` `[MODIFIKASI]`
**File:** `app/templates/order_tracking.php`

Tambahkan section QR code di bawah order info card, **hanya tampil jika `payment_code` ada**:

```php
<?php if (!empty($order['payment_code'])): ?>
  <div class="payment-qr-section">
    <h2 class="section-label">Kode Pembayaran Tunai</h2>
    <p class="qr-desc">Tunjukkan QR Code ini ke kasir untuk melakukan pembayaran</p>

    <!-- QR Code dari Google Charts API atau library PHP -->
    <div class="qr-wrapper">
      <img
        src="https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=<?= urlencode($order['payment_code']) ?>"
        alt="QR Code Pembayaran"
        class="qr-image"
        width="200"
        height="200"
      >
    </div>

    <div class="payment-code-display">
      <span class="code-label">KODE REFERENSI</span>
      <span class="code-value"><?= htmlspecialchars($order['payment_code']) ?></span>
    </div>
  </div>
<?php endif; ?>
```

---

#### E. Endpoint Kasir untuk Lookup by `payment_code` `[BUAT BARU]`
**File:** `app/src/Controllers/OrderController.php`

Tambahkan method `lookupByCode()`:

```php
/**
 * API: Kasir lookup order berdasarkan payment_code (hasil scan QR)
 * GET /order/lookup?code=PAY-20260530-A3F9K2X1
 */
public function lookupByCode()
{
    header('Content-Type: application/json');

    // TODO: Tambahkan middleware auth kasir di index.php

    $code = $_GET['code'] ?? null;
    if (!$code) {
        echo json_encode(['success' => false, 'message' => 'Kode tidak ditemukan']);
        return;
    }

    $orderModel = new OrderModel();
    $order = $orderModel->getOrderWithDetails_byCode($code);

    if (!$order) {
        echo json_encode(['success' => false, 'message' => 'Pesanan tidak ditemukan untuk kode ini']);
        return;
    }

    $orderItemModel = new OrderItemModel();
    $items = $orderItemModel->getItemsWithMenuDetails($order['id']);

    echo json_encode([
        'success' => true,
        'order'   => $order,
        'items'   => $items,
    ]);
}
```

Tambahkan juga method `getOrderWithDetails_byCode()` di `OrderModel.php`:

```php
public function getOrderWithDetails_byCode(string $code)
{
    $stmt = $this->db->prepare(
        "SELECT o.*, rt.nomor_meja, pm.name as payment_method_name
         FROM {$this->table} o
         LEFT JOIN restaurant_table rt ON o.restaurant_table_id = rt.id
         LEFT JOIN payment_method pm ON o.payment_method_id = pm.id
         WHERE o.payment_code = :code
         LIMIT 1"
    );
    $stmt->execute(['code' => $code]);
    return $stmt->fetch(\PDO::FETCH_ASSOC);
}
```

---

#### F. Tambah Route `[MODIFIKASI]`
**File:** `index.php`

```php
// Lookup pesanan berdasarkan payment_code (dipakai kasir saat scan QR)
$router->get('/order/lookup', [\App\Controllers\OrderController::class, 'lookupByCode']);
```

---

### 3. CSS untuk Tampilan QR Code

Tambahkan di `assets/css/order_tracking.css`:

```css
/* QR Code Payment Section */
.payment-qr-section {
  background: var(--surface-container-lowest);
  border-radius: var(--radius-2xl);
  padding: 2rem;
  margin-bottom: 2rem;
  box-shadow: 0 4px 20px rgba(0,0,0,0.03);
  text-align: center;
}

.section-label {
  font-size: 1.125rem;
  font-weight: 800;
  margin-bottom: 0.5rem;
}

.qr-desc {
  font-size: 0.875rem;
  color: var(--on-surface-variant);
  margin-bottom: 1.5rem;
}

.qr-wrapper {
  display: flex;
  justify-content: center;
  margin-bottom: 1.5rem;
}

.qr-image {
  border-radius: var(--radius-xl);
  border: 4px solid var(--surface-container-high);
}

.payment-code-display {
  display: flex;
  flex-direction: column;
  gap: 0.25rem;
  background: var(--surface-container-low);
  padding: 1rem;
  border-radius: var(--radius-lg);
}

.code-label {
  font-size: 0.625rem;
  font-weight: 800;
  color: var(--outline);
  letter-spacing: 0.1em;
}

.code-value {
  font-size: 1.25rem;
  font-weight: 800;
  color: var(--primary);
  font-family: 'Plus Jakarta Sans', monospace;
  letter-spacing: 0.05em;
}
```

---

## Alur Lengkap (Setelah Implementasi)

```
1. Pelanggan checkout → pilih "Tunai"
2. CheckoutController::process() generate payment_code (PAY-20260530-A3F9K2X1)
3. payment_code disimpan di tabel order
4. Redirect ke /order-tracking
5. Halaman order-tracking tampilkan QR code dari payment_code
6. Pelanggan tunjukkan QR ke kasir
7. Kasir scan QR → request GET /order/lookup?code=PAY-...
8. Kasir lihat detail pesanan dan proses pembayaran
```

---

## Urutan Implementasi (Step-by-Step)

- [ ] **Step 1** — Jalankan migrasi `AddPaymentCodeToOrder` (ALTER TABLE)
- [ ] **Step 2** — Buat `PaymentCodeHelper.php`
- [ ] **Step 3** — Update `CheckoutController::process()` untuk generate dan simpan `payment_code`
- [ ] **Step 4** — Update `order_tracking.php` untuk tampilkan QR jika `payment_code` ada
- [ ] **Step 5** — Update `order_tracking.css` tambahkan style QR section
- [ ] **Step 6** — Tambah `getOrderWithDetails_byCode()` di `OrderModel.php`
- [ ] **Step 7** — Tambah `lookupByCode()` di `OrderController.php`
- [ ] **Step 8** — Daftarkan route `/order/lookup` di `index.php`
- [ ] **Step 9** — Test end-to-end: checkout tunai → QR muncul → lookup berhasil

---

## Catatan Penting

> **QR Library:** Menggunakan [goqr.me API](https://api.qrserver.com) yang gratis, tidak perlu install library PHP. Format URL: `https://api.qrserver.com/v1/create-qr-code/?size=200x200&data=KODE`

> **Keamanan:** Endpoint `/order/lookup` sebaiknya dilindungi middleware autentikasi kasir agar tidak bisa diakses sembarangan orang.

> **Tabel sudah ada:** Tabel `order` sudah dibuat oleh migration sebelumnya (`2026_05_30_000003`). Migrasi baru ini hanya ALTER TABLE untuk menambah kolom, bukan membuat ulang.

---

## Referensi File Terkait

| File | Relevansi |
|------|-----------|
| `app/database/migrations/2026_05_30_000003_CreateOrderTables.php` | Migration asli tabel order |
| `app/src/Controllers/CheckoutController.php` | Perlu dimodifikasi di method `process()` |
| `app/src/Controllers/OrderController.php` | Perlu ditambah method `lookupByCode()` |
| `app/src/Models/OrderModel.php` | Perlu ditambah method `getOrderWithDetails_byCode()` |
| `app/templates/order_tracking.php` | Perlu ditambah section QR code |
| `assets/css/order_tracking.css` | Perlu ditambah CSS untuk QR section |
| `index.php` | Perlu ditambah route `/order/lookup` |
