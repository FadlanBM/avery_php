    <?php

use App\Core\Database;

class CreateBookingTables
{
    public function up()
    {
        $db = Database::getInstance()->getConnection();

        // 1. Table Rooms (Ruangan)
        // Menyimpan data ruangan yang bisa dipesan
        $db->exec("CREATE TABLE IF NOT EXISTS rooms (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            description TEXT,
            capacity INT NOT NULL DEFAULT 1,
            price_per_hour DECIMAL(10, 2) NOT NULL, -- Harga per jam
            image_url VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");

        // 2. Table Bookings (Pemesanan)
        // Inti dari sistem reservasi
        $db->exec("CREATE TABLE IF NOT EXISTS bookings (
            id INT AUTO_INCREMENT PRIMARY KEY,
            user_id INT NOT NULL,
            room_id INT NOT NULL,
            start_time DATETIME NOT NULL, -- Waktu mulai booking
            end_time DATETIME NOT NULL,   -- Waktu selesai booking
            total_price DECIMAL(10, 2) NOT NULL,
            
            -- Status Booking:
            -- pending: Baru dibuat, slot dikunci sementara (Fase B)
            -- confirmed: Pembayaran sukses (Fase C)
            -- cancelled: Dibatalkan user/sistem
            -- completed: Selesai digunakan
            -- expired: Gagal bayar dalam waktu yang ditentukan
            status ENUM('pending', 'confirmed', 'cancelled', 'completed', 'expired') DEFAULT 'pending',
            
            booking_code VARCHAR(50) UNIQUE, -- Kode unik untuk QR Code (Fase C)
            checked_in_at DATETIME NULL,     -- Waktu scan QR asli (Fase D)
            expires_at DATETIME NULL,        -- Batas waktu pembayaran (lock 15 menit)
            
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
            FOREIGN KEY (room_id) REFERENCES rooms(id) ON DELETE CASCADE,
            
            -- Index untuk mempercepat pencarian availability (Fase A)
            INDEX idx_booking_period (start_time, end_time),
            INDEX idx_status (status)
        )");
        
        // 3. Table Payments (Pembayaran)
        // Mencatat transaksi pembayaran (Fase C)
        $db->exec("CREATE TABLE IF NOT EXISTS payments (
            id INT AUTO_INCREMENT PRIMARY KEY,
            booking_id INT NOT NULL,
            amount DECIMAL(10, 2) NOT NULL,
            payment_method VARCHAR(50),      -- e.g., 'credit_card', 'gopay'
            transaction_id VARCHAR(100),     -- ID referensi dari Payment Gateway
            status ENUM('pending', 'paid', 'failed', 'refunded') DEFAULT 'pending',
            paid_at DATETIME NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (booking_id) REFERENCES bookings(id) ON DELETE CASCADE
        )");

        echo "Tables 'rooms', 'bookings', 'payments' created successfully.\n";
    }

    public function down()
    {
        $db = Database::getInstance()->getConnection();
        $db->exec("DROP TABLE IF EXISTS payments");
        $db->exec("DROP TABLE IF EXISTS bookings");
        $db->exec("DROP TABLE IF EXISTS rooms");
        
        echo "Tables 'rooms', 'bookings', 'payments' dropped.\n";
    }
}
