<?php

use App\Core\Database;

class CreateUsersTable
{
    public function up()
    {
        $db = Database::getInstance()->getConnection();
        $db->exec("CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        )");
        
        echo "Table 'users' created successfully.\n";
    }

    public function down()
    {
        $db = Database::getInstance()->getConnection();
        $db->exec("DROP TABLE IF EXISTS users");
        
        echo "Table 'users' dropped.\n";
    }
}
