<?php

namespace App\Core;

class Env
{
    /**
     * Load .env file
     *
     * @param string $path Path to .env file
     * @return void
     */
    public static function load($path)
    {
        if (!file_exists($path)) {
            // Optional: Throw exception or just return if .env is optional
            return;
        }

        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        foreach ($lines as $line) {
            // Ignore comments
            if (strpos(trim($line), '#') === 0) {
                continue;
            }

            // Parse line
            if (strpos($line, '=') !== false) {
                list($name, $value) = explode('=', $line, 2);
                $name = trim($name);
                $value = trim($value);

                // Set environment variable if not already set
                if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
                    putenv(sprintf('%s=%s', $name, $value));
                    $_ENV[$name] = $value;
                    $_SERVER[$name] = $value;
                }
            }
        }
    }

    /**
     * Get environment variable
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    public static function get($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        return $value;
    }
}
