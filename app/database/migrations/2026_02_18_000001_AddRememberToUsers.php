<?php

use App\Core\Database;

class AddRememberToUsers
{
    private function tableExists(\PDO $db, string $driver, string $table): bool
    {
        if ($driver === 'pgsql') {
            $stmt = $db->prepare("SELECT 1 FROM information_schema.tables WHERE table_schema = 'public' AND table_name = :table LIMIT 1");
            $stmt->execute(['table' => $table]);
            return (bool) $stmt->fetchColumn();
        }

        $dbName = $db->query('SELECT DATABASE()')->fetchColumn();
        $stmt = $db->prepare("SELECT COUNT(*) FROM information_schema.tables WHERE table_schema = :db AND table_name = :table");
        $stmt->execute(['db' => $dbName, 'table' => $table]);

        return (int) $stmt->fetchColumn() > 0;
    }

    public function up()
    {
        $db = Database::getInstance()->getConnection();
        $driver = $db->getAttribute(\PDO::ATTR_DRIVER_NAME);

        if (!$this->tableExists($db, $driver, 'users')) {
            echo "Skipping 'AddRememberToUsers' because table 'users' does not exist yet.\n";
            return;
        }

        if ($driver === 'pgsql') {
            // Check and add remember_token
            $stmt = $db->prepare("SELECT 1 FROM information_schema.columns WHERE table_name = 'users' AND column_name = 'remember_token'");
            $stmt->execute();
            if (!$stmt->fetch()) {
                $db->exec("ALTER TABLE users ADD COLUMN remember_token VARCHAR(255) NULL");
            }
            // Check and add remember_expires_at
            $stmt = $db->prepare("SELECT 1 FROM information_schema.columns WHERE table_name = 'users' AND column_name = 'remember_expires_at'");
            $stmt->execute();
            if (!$stmt->fetch()) {
                $db->exec("ALTER TABLE users ADD COLUMN remember_expires_at TIMESTAMP NULL");
            }
        } else {
            // MySQL / MariaDB
            $dbName = $db->query('SELECT DATABASE()')->fetchColumn();
            $checkCol = $db->prepare("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = :db AND table_name = 'users' AND column_name = :col");
            
            $checkCol->execute(['db' => $dbName, 'col' => 'remember_token']);
            if ($checkCol->fetchColumn() == 0) {
                $db->exec("ALTER TABLE users ADD COLUMN remember_token VARCHAR(255) NULL");
            }
            $checkCol->execute(['db' => $dbName, 'col' => 'remember_expires_at']);
            if ($checkCol->fetchColumn() == 0) {
                $db->exec("ALTER TABLE users ADD COLUMN remember_expires_at TIMESTAMP NULL");
            }
        }

        echo "Migration 'AddRememberToUsers' applied successfully.\n";
    }

    public function down()
    {
        $db = Database::getInstance()->getConnection();
        $driver = $db->getAttribute(\PDO::ATTR_DRIVER_NAME);

        if (!$this->tableExists($db, $driver, 'users')) {
            echo "Skipping revert for 'AddRememberToUsers' because table 'users' does not exist.\n";
            return;
        }

        if ($driver === 'pgsql') {
            // Drop columns if exist
            $db->exec("ALTER TABLE users DROP COLUMN IF EXISTS remember_expires_at");
            $db->exec("ALTER TABLE users DROP COLUMN IF EXISTS remember_token");
        } else {
            // MySQL / MariaDB
            $dbName = $db->query('SELECT DATABASE()')->fetchColumn();
            $checkCol = $db->prepare("SELECT COUNT(*) FROM information_schema.columns WHERE table_schema = :db AND table_name = 'users' AND column_name = :col");
            
            $checkCol->execute(['db' => $dbName, 'col' => 'remember_expires_at']);
            if ($checkCol->fetchColumn() > 0) {
                $db->exec("ALTER TABLE users DROP COLUMN remember_expires_at");
            }
            $checkCol->execute(['db' => $dbName, 'col' => 'remember_token']);
            if ($checkCol->fetchColumn() > 0) {
                $db->exec("ALTER TABLE users DROP COLUMN remember_token");
            }
        }

        echo "Migration 'AddRememberToUsers' reverted successfully.\n";
    }
}
