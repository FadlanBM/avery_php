<?php

use App\Core\Database;

class AddPaymentCodeToOrder
{
    public function up()
    {
        $db = Database::getInstance()->getConnection();
        $driver = $db->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $tableName = $driver === 'pgsql' ? '"order"' : '`order`';

        // Check if column already exists
        $stmt = $db->prepare("
            SELECT column_name 
            FROM information_schema.columns 
            WHERE table_name = 'order' AND column_name = 'payment_code'
        ");
        $stmt->execute();
        $check = $stmt->fetch();

        if (!$check) {
            $db->exec("ALTER TABLE {$tableName} ADD COLUMN payment_code VARCHAR(32) UNIQUE DEFAULT NULL");
            echo "Kolom payment_code berhasil ditambahkan ke tabel order.\n";
        } else {
            echo "Kolom payment_code sudah ada di tabel order.\n";
        }
    }

    public function down()
    {
        $db = Database::getInstance()->getConnection();
        $driver = $db->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $tableName = $driver === 'pgsql' ? '"order"' : '`order`';

        $db->exec("ALTER TABLE {$tableName} DROP COLUMN IF EXISTS payment_code");
        echo "Kolom payment_code berhasil dihapus dari tabel order.\n";
    }
}
