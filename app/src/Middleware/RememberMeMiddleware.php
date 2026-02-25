<?php

namespace App\Middleware;

use App\Models\User;

class RememberMeMiddleware
{
    public function handle()
    {
        // Remember Me Auto-Login
        if (!isset($_SESSION['user_id']) && isset($_COOKIE['remember_me'])) {
            $cookieVal = $_COOKIE['remember_me'];
            if (strpos($cookieVal, '|') !== false) {
                list($uid, $token) = explode('|', $cookieVal, 2);
                if ($uid && $token) {
                    try {
                        $userModel = new User();
                        $user = $userModel->find($uid);
                        if ($user && !empty($user['remember_token']) && !empty($user['remember_expires_at'])) {
                            $validHash = hash('sha256', $token);
                            $notExpired = (strtotime($user['remember_expires_at']) >= time());
                            if (hash_equals($user['remember_token'], $validHash) && $notExpired) {
                                $_SESSION['user_id'] = $user['id'];
                                $_SESSION['user_name'] = $user['name'];
                            }
                        }
                    } catch (\Throwable $e) {
                        // Silently ignore remember-me failures
                    }
                }
            }
        }
    }
}
