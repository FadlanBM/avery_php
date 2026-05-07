<?php

namespace App\Middleware;

use App\Helpers\FlashMessage;

class CashierMiddleware
{
    public function handle($role = null)
    {
        // 1. Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            FlashMessage::error('Silakan login terlebih dahulu');
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // 2. Check if role is cashier or superadmin (superadmin usually has access to everything)
        $role = $_SESSION['user_role'] ?? '';
        if ($role !== 'cashier' && $role !== 'superadmin') {
            FlashMessage::error('Hanya kasir yang dapat mengakses halaman ini');
            header('Location: ' . BASE_URL);
            exit;
        }
    }
}
