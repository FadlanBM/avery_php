<?php

namespace App\Middleware;

use App\Helpers\FlashMessage;

class SuperAdminMiddleware
{
    public function handle($role = null)
    {
        // 1. Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            FlashMessage::error('Silakan login terlebih dahulu');
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // 2. Check if role is superadmin
        if (($_SESSION['user_role'] ?? '') !== 'superadmin') {
            FlashMessage::error('Anda tidak memiliki akses ke halaman ini');
            header('Location: ' . BASE_URL);
            exit;
        }
    }
}
