<?php

namespace App\Middleware;

use App\Helpers\FlashMessage;

class SuperAdminMiddleware
{
    public function handle($role = null)
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        if (($_SESSION['user_role'] ?? '') !== 'superadmin') {
            FlashMessage::error('Anda tidak memiliki akses ke halaman ini');
            header('Location: ' . BASE_URL);
            exit;
        }
    }
}
