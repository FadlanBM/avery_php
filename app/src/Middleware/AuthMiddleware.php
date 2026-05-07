<?php

namespace App\Middleware;

use App\Helpers\FlashMessage;

class AuthMiddleware {
    public function handle($role = null) {
        // Cek apakah session user_id ada
        if (!isset($_SESSION['user_id'])) {
            // Tampilkan pesan error
            FlashMessage::error('Silakan login terlebih dahulu untuk mengakses halaman ini');
            
            // Jika tidak ada, redirect ke halaman login
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
}
