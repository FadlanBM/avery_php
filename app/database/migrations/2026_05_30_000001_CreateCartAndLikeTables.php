<?php

use App\Core\Database;

class CreateCartAndLikeTables
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

        // 13. Table cart
        $db->exec("CREATE TABLE IF NOT EXISTS cart (
            id {$idColumn},
            user_id INT NOT NULL,
            restaurant_table_id INT,
            status VARCHAR(50) NOT NULL DEFAULT 'active',
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION,
            FOREIGN KEY (restaurant_table_id) REFERENCES restaurant_table(id) ON DELETE SET NULL ON UPDATE NO ACTION
        )");

        // 14. Table cart_item
        $db->exec("CREATE TABLE IF NOT EXISTS cart_item (
            id {$idColumn},
            cart_id INT NOT NULL,
            restaurant_menu_id INT NOT NULL,
            quantity INT NOT NULL DEFAULT 1,
            notes TEXT,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (cart_id) REFERENCES cart(id) ON DELETE CASCADE ON UPDATE NO ACTION,
            FOREIGN KEY (restaurant_menu_id) REFERENCES restaurant_menu(id) ON DELETE CASCADE ON UPDATE NO ACTION
        )");

        // 15. Table restaurant_menu_like
        $db->exec("CREATE TABLE IF NOT EXISTS restaurant_menu_like (
            id {$idColumn},
            user_id INT NOT NULL,
            restaurant_menu_id INT NOT NULL,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE ON UPDATE NO ACTION,
            FOREIGN KEY (restaurant_menu_id) REFERENCES restaurant_menu(id) ON DELETE CASCADE ON UPDATE NO ACTION,
            UNIQUE (user_id, restaurant_menu_id)
        )");

        echo "Cart and like tables created successfully.\n";
    }

    public function down()
    {
        $db = Database::getInstance()->getConnection();

        // Drop in reverse order of dependencies
        $db->exec("DROP TABLE IF EXISTS restaurant_menu_like");
        $db->exec("DROP TABLE IF EXISTS cart_item");
        $db->exec("DROP TABLE IF EXISTS cart");

        echo "Cart and like tables dropped.\n";
    }
}
