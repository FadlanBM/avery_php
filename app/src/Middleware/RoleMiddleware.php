<?php

namespace App\Middleware;

use App\Helpers\FlashMessage;

class RoleMiddleware
{
    /**
     * Handle role validation
     * 
     * @param string|null $requiredRole The role required to access the route
     */
    public function handle($requiredRole = null)
    {
        // 1. Ensure user is logged in
        if (!isset($_SESSION['user_id'])) {
            FlashMessage::error('Silakan login terlebih dahulu');
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        // 2. Check role if specified
        if ($requiredRole) {
            $userRole = $_SESSION['user_role'] ?? '';
            
            // Allow superadmin to bypass most role checks, or check for exact match
            if ($userRole !== 'superadmin' && $userRole !== $requiredRole) {
                FlashMessage::error('Anda tidak memiliki izin untuk mengakses halaman ini');
                
                // Redirect based on role
                if ($userRole === 'cashier') {
                    header('Location: ' . BASE_URL . '/cashier');
                } else {
                    header('Location: ' . BASE_URL);
                }
                exit;
            }
        }
    }
}
