<?php

use App\Core\Database;

class CreateOrderTables
{
    public function up()
    {
        $db = Database::getInstance()->getConnection();
        $driver = $db->getAttribute(\PDO::ATTR_DRIVER_NAME);

        $idColumn = $driver === 'pgsql'
            ? 'SERIAL PRIMARY KEY'
            : 'INT AUTO_INCREMENT PRIMARY KEY';

        $timestampColumn = 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP';
        $updatedAtColumn = $driver === 'pgsql'
            ? 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP'
            : 'TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP';

        $tableName = $driver === 'pgsql' ? '"order"' : '`order`';

        // Create order table
        $db->exec("CREATE TABLE IF NOT EXISTS {$tableName} (
            id {$idColumn},
            cart_id INT NOT NULL,
            session_id VARCHAR(255) NOT NULL,
            restaurant_table_id INT,
            payment_method_id INT,
            status VARCHAR(50) NOT NULL DEFAULT 'pending',
            notes TEXT,
            subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
            tax_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
            service_charge DECIMAL(12,2) NOT NULL DEFAULT 0,
            total_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (cart_id) REFERENCES cart(id) ON DELETE RESTRICT ON UPDATE NO ACTION,
            FOREIGN KEY (restaurant_table_id) REFERENCES restaurant_table(id) ON DELETE SET NULL ON UPDATE NO ACTION,
            FOREIGN KEY (payment_method_id) REFERENCES payment_method(id) ON DELETE SET NULL ON UPDATE NO ACTION
        )");

        // Create order_item table
        $db->exec("CREATE TABLE IF NOT EXISTS order_item (
            id {$idColumn},
            order_id INT NOT NULL,
            restaurant_menu_id INT NOT NULL,
            quantity INT NOT NULL DEFAULT 1,
            unit_price DECIMAL(12,2) NOT NULL DEFAULT 0,
            subtotal DECIMAL(12,2) NOT NULL DEFAULT 0,
            notes TEXT,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (order_id) REFERENCES {$tableName}(id) ON DELETE CASCADE ON UPDATE NO ACTION,
            FOREIGN KEY (restaurant_menu_id) REFERENCES restaurant_menu(id) ON DELETE RESTRICT ON UPDATE NO ACTION
        )");

        echo "Order and order_item tables created successfully.\n";
    }

    public function down()
    {
        $db = Database::getInstance()->getConnection();
        $driver = $db->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $tableName = $driver === 'pgsql' ? '"order"' : '`order`';

        $db->exec("DROP TABLE IF EXISTS order_item");
        $db->exec("DROP TABLE IF EXISTS {$tableName}");

        echo "Order and order_item tables dropped.\n";
    }
}
