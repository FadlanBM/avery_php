<?php

namespace App\Middleware;

use App\Models\RestaurantTable;

class TableAccessMiddleware
{
    public function handle($role = null)
    {
        $tableCode = strtoupper(trim($_GET['table'] ?? ($_SESSION['table_code'] ?? ($_COOKIE['table_code'] ?? ''))));

        if ($tableCode === '') {
            $this->clearTableContext();
            header('Location: ' . BASE_URL . '/scan-qr');
            exit;
        }

        $tableModel = new RestaurantTable();
        $table = $tableModel->findByIdentityCode($tableCode);

        if (!$table || !$this->isTableActive($table)) {
            $this->clearTableContext();
            header('Location: ' . BASE_URL . '/scan-qr');
            exit;
        }

        $this->storeTableContext($table);
    }

    private function isTableActive($table)
    {
        return $table['active'] === true
            || $table['active'] == 1
            || $table['active'] === 't'
            || $table['active'] === 'true';
    }

    private function storeTableContext($table)
    {
        $_SESSION['table_id'] = $table['id'];
        $_SESSION['table_code'] = $table['identity_code'];
        $_SESSION['table_number'] = $table['nomor_meja'];

        $secure = parse_url(BASE_URL, PHP_URL_SCHEME) === 'https';
        $expires = time() + (60 * 60 * 12);

        setcookie('table_code', $table['identity_code'], [
            'expires' => $expires,
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        setcookie('table_number', $table['nomor_meja'], [
            'expires' => $expires,
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }

    private function clearTableContext()
    {
        unset($_SESSION['table_id'], $_SESSION['table_code'], $_SESSION['table_number']);

        $secure = parse_url(BASE_URL, PHP_URL_SCHEME) === 'https';
        $expired = time() - 3600;

        setcookie('table_code', '', [
            'expires' => $expired,
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        setcookie('table_number', '', [
            'expires' => $expired,
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }
}
