<?php

namespace App\Controllers;

use App\Core\Controller;

class MenumanagementController extends Controller
{
    public function index()
    {
        return $this->view('dashboard/menu_management', [
            'title' => 'Manajemen Menu'
        ]);
    }
    public function addMenu()
    {
        return $this->view('dashboard/form/add_menu', [
            'title' => 'Tambah Menu Baru'
        ]);
    }

    public function post()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $category = $_POST['category'] ?? '';
            $description = $_POST['description'] ?? '';
            $status = $_POST['status'] ?? '';
            $images = $_FILES['images'] ?? null;

            // 1. Validation
            $errors = [];

            if (empty($name)) $errors[] = "Nama menu wajib diisi";
            if (empty($price)) {
                $errors[] = "Harga wajib diisi";
            } elseif (!is_numeric($price)) {
                $errors[] = "Harga harus berupa angka";
            }
            if (empty($category)) $errors[] = "Kategori wajib diisi";
            
            // Image Validation (Multiple)
            if ($images && !empty($images['name'][0])) {
                $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
                
                foreach ($images['type'] as $index => $type) {
                    if (!in_array($type, $allowedTypes)) {
                        $errors[] = "File ke-" . ($index + 1) . " bukan format gambar yang didukung (JPG, PNG, WEBP)";
                    }
                    if ($images['size'][$index] > 2 * 1024 * 1024) {
                        $errors[] = "File ke-" . ($index + 1) . " melebihi ukuran maksimal 2MB";
                    }
                }
            }

            // 2. Handle Errors
            if (!empty($errors)) {
                foreach ($errors as $error) {
                    \App\Helpers\FlashMessage::error($error);
                }
                // Redirect back to the form
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            // 3. Process Creation
            try {
                $menuModel = new \App\Models\MenuModel();
                $result = $menuModel->createMenu($name, $price, $category, $description, $images, $status);

                if ($result) {
                    \App\Helpers\FlashMessage::success('Menu berhasil ditambahkan');
                    header('Location: ' . BASE_URL . '/dashboard/menu-management');
                } else {
                    \App\Helpers\FlashMessage::error('Gagal menambahkan menu');
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
            } catch (\Exception $e) {
                \App\Helpers\FlashMessage::error('Terjadi kesalahan: ' . $e->getMessage());
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            exit;
        }
    }
}
