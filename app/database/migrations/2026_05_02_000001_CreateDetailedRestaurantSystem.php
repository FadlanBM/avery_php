<?php

use App\Core\Database;

class CreateDetailedRestaurantSystem
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

        // 1. Table role
        $db->exec("CREATE TABLE IF NOT EXISTS role (
            id {$idColumn},
            name VARCHAR(255),
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn}
        )");

        // 2. Table users
        $db->exec("CREATE TABLE IF NOT EXISTS users (
            id {$idColumn},
            name VARCHAR(255) NOT NULL,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            role_id INT NOT NULL,
            status BOOLEAN NOT NULL DEFAULT true,
            remamber VARCHAR(255) NOT NULL,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (role_id) REFERENCES role(id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )");

        // 3. Table restaurant_menu_categories
        $db->exec("CREATE TABLE IF NOT EXISTS restaurant_menu_categories (
            id {$idColumn},
            created_by INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            description VARCHAR(255) NOT NULL,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )");

        // 4. Table restaurant_menu
        $db->exec("CREATE TABLE IF NOT EXISTS restaurant_menu (
            id {$idColumn},
            category_id INT NOT NULL,
            created_by INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            price DECIMAL(12,2) NOT NULL,
            stock INT NOT NULL,
            is_available BOOLEAN NOT NULL,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (category_id) REFERENCES restaurant_menu_categories(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )");

        // 5. Table assets
        $db->exec("CREATE TABLE IF NOT EXISTS assets (
            id {$idColumn},
            file_name VARCHAR(255) NOT NULL,
            file_path VARCHAR(255) NOT NULL,
            file_type VARCHAR(255) NOT NULL,
            file_size_kb INT NOT NULL,
            is_public BOOLEAN NOT NULL,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn}
        )");

        // 6. Table restaurant_menu_assets
        $db->exec("CREATE TABLE IF NOT EXISTS restaurant_menu_assets (
            id {$idColumn},
            restaurant_menu_id INT NOT NULL,
            assets_id INT NOT NULL,
            FOREIGN KEY (restaurant_menu_id) REFERENCES restaurant_menu(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            FOREIGN KEY (assets_id) REFERENCES assets(id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )");

        // 7. Table restaurant_table_area
        $db->exec("CREATE TABLE IF NOT EXISTS restaurant_table_area (
            id {$idColumn},
            created_by INT NOT NULL,
            name VARCHAR(255) NOT NULL,
            description TEXT NOT NULL,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )");

        // 8. Table restaurant_table
        $db->exec("CREATE TABLE IF NOT EXISTS restaurant_table (
            id {$idColumn},
            restaurant_table_area_id INT NOT NULL,
            created_by INT NOT NULL,
            identity_code VARCHAR(255) NOT NULL,
            nomor_meja VARCHAR(255) NOT NULL,
            kapasitas INT NOT NULL,
            active BOOLEAN NOT NULL,
            is_use BOOLEAN NOT NULL,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (restaurant_table_area_id) REFERENCES restaurant_table_area(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )");

        // 9. Table payment_method
        $db->exec("CREATE TABLE IF NOT EXISTS payment_method (
            id {$idColumn},
            name VARCHAR(255) NOT NULL,
            created_by INT NOT NULL,
            is_active BOOLEAN NOT NULL,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )");

        // 10. Table transaction
        $db->exec("CREATE TABLE IF NOT EXISTS transaction (
            id {$idColumn},
            staff_id INT NOT NULL,
            restaurant_table_id INT NOT NULL,
            payment_method_id INT NOT NULL,
            status VARCHAR(255) NOT NULL,
            transaction_date DATE NOT NULL,
            amount DECIMAL(12,2) NOT NULL,
            tax_amount DECIMAL(12,2) NOT NULL,
            status_pembayaran VARCHAR(255) NOT NULL,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (staff_id) REFERENCES users(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            FOREIGN KEY (restaurant_table_id) REFERENCES restaurant_table(id) ON DELETE NO ACTION ON UPDATE NO ACTION,
            FOREIGN KEY (payment_method_id) REFERENCES payment_method(id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )");

        // 11. Table restaurant_setting
        $db->exec("CREATE TABLE IF NOT EXISTS restaurant_setting (
            id {$idColumn},
            name VARCHAR(255) NOT NULL,
            photo_profile_restorant INT NOT NULL,
            email VARCHAR(255) NOT NULL,
            address VARCHAR(255) NOT NULL,
            phone_number VARCHAR(255) NOT NULL,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (photo_profile_restorant) REFERENCES assets(id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )");

        // 12. Table restaurant_open_setting
        $db->exec("CREATE TABLE IF NOT EXISTS restaurant_open_setting (
            id {$idColumn},
            restaurant_setting_id INT NOT NULL,
            day VARCHAR(255) NOT NULL,
            is_open VARCHAR(255) NOT NULL,
            start_time TIME NOT NULL,
            end_time TIME NOT NULL,
            created_at {$timestampColumn},
            updated_at {$updatedAtColumn},
            FOREIGN KEY (restaurant_setting_id) REFERENCES restaurant_setting(id) ON DELETE NO ACTION ON UPDATE NO ACTION
        )");

        echo "Detailed restaurant system tables created successfully.\n";
    }

    public function down()
    {
        $db = Database::getInstance()->getConnection();

        // Drop in reverse order of dependencies
        $db->exec("DROP TABLE IF EXISTS restaurant_open_setting");
        $db->exec("DROP TABLE IF EXISTS restaurant_setting");
        $db->exec("DROP TABLE IF EXISTS transaction");
        $db->exec("DROP TABLE IF EXISTS payment_method");
        $db->exec("DROP TABLE IF EXISTS restaurant_table");
        $db->exec("DROP TABLE IF EXISTS restaurant_table_area");
        $db->exec("DROP TABLE IF EXISTS restaurant_menu_assets");
        $db->exec("DROP TABLE IF EXISTS assets");
        $db->exec("DROP TABLE IF EXISTS restaurant_menu");
        $db->exec("DROP TABLE IF EXISTS restaurant_menu_categories");
        $db->exec("DROP TABLE IF EXISTS users");
        $db->exec("DROP TABLE IF EXISTS role");

        echo "Detailed restaurant system tables dropped.\n";
    }
}
