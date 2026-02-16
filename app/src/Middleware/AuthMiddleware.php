<?php

namespace App\Middleware;

class AuthMiddleware {
    public function handle() {
        // Cek apakah session user_id ada
        if (!isset($_SESSION['user_id'])) {
            // Jika tidak ada, redirect ke halaman login
            header('Location: ' . BASE_URL . '/login');
            exit;
        }
    }
}
