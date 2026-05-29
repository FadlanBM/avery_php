<?php

use App\Core\Database;

class AlterCartAddSessionId
{
    public function up()
    {
        $db = Database::getInstance()->getConnection();
        $driver = $db->getAttribute(\PDO::ATTR_DRIVER_NAME);

        // Add session_id column to cart table
        $db->exec("ALTER TABLE cart ADD COLUMN session_id VARCHAR(255) DEFAULT NULL");

        // Add unique index on session_id for fast lookups
        if ($driver === 'pgsql') {
            $db->exec("CREATE INDEX IF NOT EXISTS idx_cart_session_id ON cart(session_id)");
            // Make user_id nullable in cart (PostgreSQL syntax)
            $db->exec("ALTER TABLE cart ALTER COLUMN user_id DROP NOT NULL");
        } else {
            // Make user_id nullable in cart (MySQL syntax)
            $db->exec("ALTER TABLE cart MODIFY COLUMN user_id INT DEFAULT NULL");
            $db->exec("CREATE INDEX idx_cart_session_id ON cart(session_id)");
        }

        // Add session_id column to restaurant_menu_like table
        $db->exec("ALTER TABLE restaurant_menu_like ADD COLUMN session_id VARCHAR(255) DEFAULT NULL");

        // Make user_id nullable in restaurant_menu_like
        if ($driver === 'pgsql') {
            $db->exec("ALTER TABLE restaurant_menu_like ALTER COLUMN user_id DROP NOT NULL");
        } else {
            $db->exec("ALTER TABLE restaurant_menu_like MODIFY COLUMN user_id INT DEFAULT NULL");
        }

        // Drop the old unique constraint and add a new one based on session_id + menu_id
        if ($driver === 'pgsql') {
            $db->exec("DROP INDEX IF EXISTS restaurant_menu_like_user_id_restaurant_menu_id_unique");
            $db->exec("CREATE UNIQUE INDEX idx_like_session_menu ON restaurant_menu_like(session_id, restaurant_menu_id)");
        } else {
            $db->exec("ALTER TABLE restaurant_menu_like DROP INDEX user_id");
            $db->exec("ALTER TABLE restaurant_menu_like ADD UNIQUE INDEX idx_like_session_menu (session_id, restaurant_menu_id)");
        }

        echo "Cart and like tables altered: session_id added, user_id made nullable.\n";
    }

    public function down()
    {
        $db = Database::getInstance()->getConnection();
        $driver = $db->getAttribute(\PDO::ATTR_DRIVER_NAME);

        $db->exec("ALTER TABLE cart DROP COLUMN session_id");
        $db->exec("ALTER TABLE restaurant_menu_like DROP COLUMN session_id");

        if ($driver === 'pgsql') {
            $db->exec("ALTER TABLE cart ALTER COLUMN user_id SET NOT NULL");
            $db->exec("ALTER TABLE restaurant_menu_like ALTER COLUMN user_id SET NOT NULL");
        } else {
            $db->exec("ALTER TABLE cart MODIFY COLUMN user_id INT NOT NULL");
            $db->exec("ALTER TABLE restaurant_menu_like MODIFY COLUMN user_id INT NOT NULL");
        }

        echo "Cart and like alterations rolled back.\n";
    }
}
