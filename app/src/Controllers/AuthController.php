<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\User;

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

        $userModel = new User();
        $user = $userModel->firstWhere('email', $email);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            header('Location: ' . BASE_URL . '/dashboard');
            exit;
        }

        return $this->view('auth/login', [
            'title' => 'Login', 
            'error' => 'Email atau password salah'
        ]);
    }

    public function processRegister() {
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        dd($email, $password, $username);

        if (empty($username) || empty($email) || empty($password)) {
            return $this->view('auth/register', [
                'title' => 'Register',
                'error' => 'Semua kolom wajib diisi'
            ]);
        }

        $userModel = new User();
        
        // Check if email exists
        if ($userModel->firstWhere('email', $email)) {
            return $this->view('auth/register', [
                'title' => 'Register',
                'error' => 'Email sudah terdaftar'
            ]);
        }

        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        if ($userModel->create(['username' => $username, 'email' => $email, 'password' => $hashedPassword])) {
            header('Location: ' . BASE_URL . '/login?success=1');
            exit;
        }

        return $this->view('auth/register', [
            'title' => 'Register',
            'error' => 'Gagal mendaftar, coba lagi'
        ]);
    }

    public function logout() {
        session_destroy();
        header('Location: ' . BASE_URL . '/login');
        exit;
    }
}
