<?php

// Define paths
define('APP_ROOT', __DIR__ . '/../app');
define('SRC_ROOT', APP_ROOT . '/src');

// Load Autoloader
require_once SRC_ROOT . '/Core/Autoloader.php';
\App\Core\Autoloader::register();

// Load Environment
\App\Core\Env::load(__DIR__ . '/../.env');

// Load Config
require_once APP_ROOT . '/config/config.php';

// Load Helpers
require_once SRC_ROOT . '/Helpers/functions.php';

use App\Core\Database;

class Migrator
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::getInstance()->getConnection();
        $this->initTable();
    }

    protected function initTable()
    {
        $this->db->exec("CREATE TABLE IF NOT EXISTS migrations (
            id INT AUTO_INCREMENT PRIMARY KEY,
            migration VARCHAR(255),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
    }

    public function run()
    {
        $files = glob(APP_ROOT . '/database/migrations/*.php');
        $applied = $this->getAppliedMigrations();

        $newMigrations = [];
        foreach ($files as $file) {
            $migration = basename($file);
            if (!in_array($migration, $applied)) {
                $newMigrations[] = $file;
            }
        }

        if (empty($newMigrations)) {
            echo "Nothing to migrate.\n";
            return;
        }

        foreach ($newMigrations as $file) {
            $migration = basename($file);
            echo "Migrating: $migration\n";
            
            require_once $file;
            
            // Assume class name is filename without timestamp and extension, converted to PascalCase
            // Or simpler: just expect the class name to be defined in the file and match a convention
            // For simplicity, let's parse the class name from file content or use a fixed convention
            // Let's assume file: 2023_01_01_000000_CreateUsersTable.php -> class CreateUsersTable
            
            $className = $this->getClassNameFromFile($file);
            
            if ($className) {
                $instance = new $className();
                $instance->up();
                
                $stmt = $this->db->prepare("INSERT INTO migrations (migration) VALUES (:migration)");
                $stmt->execute(['migration' => $migration]);
                
                echo "Migrated:  $migration\n";
            } else {
                echo "Error: Could not find class in $migration\n";
            }
        }
    }

    protected function getAppliedMigrations()
    {
        $stmt = $this->db->query("SELECT migration FROM migrations");
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
    
    protected function getClassNameFromFile($file)
    {
        $content = file_get_contents($file);
        if (preg_match('/class\s+(\w+)/', $content, $matches)) {
            return $matches[1];
        }
        return null;
    }
}

$migrator = new Migrator();
$migrator->run();
