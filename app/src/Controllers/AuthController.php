<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\RoleModel;
use App\Models\User;
use App\Helpers\FlashMessage;

class AuthController extends Controller
{

    public function login()
    {
        return $this->view('auth/login', ['title' => 'Login']);
    }

    public function processLogin()
    {
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']) && $_POST['remember'] ? true : false;

        $userModel = new User();
        $user = $userModel->firstWhere('username', $username);

        if (!$user) {
            return $this->view('auth/login', [
                'title' => 'Login',
                'error' => 'Username tidak terdaftar'
            ]);
        }

        if ($user && password_verify($password, $user['password'])) {
            if ($user['status'] != 1) {
                FlashMessage::error('Akun belum diaktifkan');
                return $this->view('auth/login', [
                    'title' => 'Login'
                ]);
            }
            $role = $user->role();
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['user_role'] = $role['name'];

            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $tokenHash = hash('sha256', $token);
                $expiresTs = time() + (60 * 60 * 24 * 30);
                $expiresAt = date('Y-m-d H:i:s', $expiresTs);

                // Simpan hash token di database
                $userModel->update($user['id'], [
                    'remember_token' => $tokenHash,
                    'remember_expires_at' => $expiresAt
                ]);

                // Set cookie aman
                $secure = (parse_url(BASE_URL, PHP_URL_SCHEME) === 'https');
                $cookieVal = $user['id'] . '|' . $token;
                setcookie('remember_me', $cookieVal, [
                    'expires' => $expiresTs,
                    'path' => '/',
                    'secure' => $secure,
                    'httponly' => true,
                    'samesite' => 'Lax'
                ]);
            }

            if ($role["name"] == "superadmin") {
                header('Location: ' . BASE_URL . '/dashboard');
            } else if ($role["name"] == "cashier") {
                header('Location: ' . BASE_URL . '/cashier');
            } else {
                header('Location: ' . BASE_URL);
            }
            exit;
        }

        return $this->view('auth/login', [
            'title' => 'Login',
            'error' => 'password salah'
        ]);
    }

    public function logout()
    {
        // Hapus remember me jika ada
        $userId = $_SESSION['user_id'] ?? null;
        if (isset($_COOKIE['remember_me'])) {
            // Hapus cookie di browser
            setcookie('remember_me', '', time() - 3600, '/');

            // Kosongkan token pada database
            if ($userId) {
                $userModel = new User();
                $userModel->update($userId, [
                    'remember_token' => null,
                    'remember_expires_at' => null
                ]);
            }
        }

        // Hancurkan sesi
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
