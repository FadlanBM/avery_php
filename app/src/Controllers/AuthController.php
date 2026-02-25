<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\RoleModel;
use App\Models\User;
use App\Helpers\FlashMessage;

class AuthController extends Controller {
    
    public function login() {
        return $this->view('auth/login', ['title' => 'Login']);
    }

    public function register() {
        return $this->view('auth/register', ['title' => 'Register']);
    }

    public function processLogin() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']) && $_POST['remember'] ? true : false;

        $userModel = new User();
        $user = $userModel->firstWhere('email', $email);

        if (!$user) {
            return $this->view('auth/login', [
                'title' => 'Login',
                'error' => 'Email tidak terdaftar'
            ]);
        }

        if ($user && password_verify($password, $user['password'])) {

            if ($user['status'] != 1) {
                FlashMessage::error('Akun belum diaktifkan');
                return $this->view('auth/login', [
                    'title' => 'Login'
                ]);
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            
            
            if ($remember) {
                $token = bin2hex(random_bytes(32));
                $tokenHash = hash('sha256', $token);
                $expiresTs = time() + (60 * 60 * 24 * 30); // 30 hari
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

            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        return $this->view('auth/login', [
            'title' => 'Login',
            'error' => 'password salah'
        ]);
    }

    public function processRegister() {
        $name = $_POST['name'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';

        if (empty($name) || empty($email) || empty($password)) {
            FlashMessage::error('Semua kolom wajib diisi');
            return $this->view('auth/register', [
                'title' => 'Register'
            ]);
        }

        $userModel = new User();
        $roleModel = new RoleModel();
        // Get default role
        $role = $roleModel->firstWhere('name', 'cashier');
        if (!$role) {
            FlashMessage::error('Role default tidak ditemukan');
            return $this->view('auth/register', [
                'title' => 'Register'
            ]);
        }
        
        // Check if email exists
        if ($userModel->firstWhere('email', $email)) {
            FlashMessage::error('Email sudah terdaftar');
            return $this->view('auth/register', [
                'title' => 'Register'
            ]);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        if ($userModel->create(['name' => $name, 'email' => $email, 'password' => $hashedPassword,'role_id'=>$role['id']])) {
            FlashMessage::success('Registrasi berhasil, silakan login');
            header('Location: ' . BASE_URL . '/login');
            exit;
        }

        FlashMessage::error('Gagal mendaftar, coba lagi');
        return $this->view('auth/register', [
            'title' => 'Register'
        ]);
    }

    public function logout() {
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
