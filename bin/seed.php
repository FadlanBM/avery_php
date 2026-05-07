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

class SeederRunner
{
    public function run()
    {
        $files = glob(APP_ROOT . '/database/seeders/*.php');

        if (empty($files)) {
            echo "No seeders found.\n";
            return;
        }

        foreach ($files as $file) {
            $seeder = basename($file);
            echo "Seeding: $seeder\n";
            
            require_once $file;
            
            $className = $this->getClassNameFromFile($file);
            
            if ($className) {
                $instance = new $className();
                $instance->run();
                echo "Seeded:  $seeder\n";
            } else {
                echo "Error: Could not find class in $seeder\n";
            }
        }
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

$runner = new SeederRunner();
$runner->run();
