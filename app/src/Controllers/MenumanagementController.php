<?php

namespace App\Controllers;

use App\Core\Controller;

class MenumanagementController extends Controller
{
    public function index()
    {
        $categoryModel = new \App\Models\MenuCategory();
        $categories = $categoryModel->all();

        $menuModel = new \App\Models\MenuModel();
        $menus = $menuModel->all();

        return $this->view('dashboard/menu_management', [
            'title' => 'Manajemen Menu',
            'categories' => $categories,
            'menus' => $menus
        ]);
    }
    public function addMenu()
    {
        $categoryModel = new \App\Models\MenuCategory();
        $categories = $categoryModel->all();

        return $this->view('dashboard/form/add_menu', [
            'title' => 'Tambah Menu Baru',
            'categories' => $categories
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
            $stock = $_POST['stock'] ?? 0;
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
            if (!is_numeric($stock) || $stock < 0) {
                $errors[] = "Stok harus berupa angka dan tidak boleh kurang dari 0";
            }
            
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
                $result = $menuModel->createMenu($name, $price, $category, $description, $images, $status, $stock);

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

    public function editMenu()
    {
        $id = $_GET['id'] ?? '';
        if (empty($id)) {
            \App\Helpers\FlashMessage::error('Menu ID tidak valid');
            header('Location: ' . BASE_URL . '/dashboard/menu-management');
            exit;
        }

        $menuModel = new \App\Models\MenuModel();
        $menu = $menuModel->find($id);
        if (!$menu) {
            \App\Helpers\FlashMessage::error('Menu tidak ditemukan');
            header('Location: ' . BASE_URL . '/dashboard/menu-management');
            exit;
        }

        $categoryModel = new \App\Models\MenuCategory();
        $categories = $categoryModel->all();

        return $this->view('dashboard/form/edit_menu', [
            'title' => 'Edit Menu',
            'menu' => $menu,
            'categories' => $categories
        ]);
    }

    public function updateMenu()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $price = $_POST['price'] ?? '';
            $category = $_POST['category'] ?? '';
            $description = $_POST['description'] ?? '';
            $status = $_POST['status'] ?? '';
            $stock = $_POST['stock'] ?? 0;
            $images = $_FILES['images'] ?? null;

            if (empty($id)) {
                \App\Helpers\FlashMessage::error('ID menu tidak valid');
                header('Location: ' . BASE_URL . '/dashboard/menu-management');
                exit;
            }

            // 1. Validation
            $errors = [];
            if (empty($name)) $errors[] = "Nama menu wajib diisi";
            if (empty($price)) {
                $errors[] = "Harga wajib diisi";
            } elseif (!is_numeric($price)) {
                $errors[] = "Harga harus berupa angka";
            }
            if (empty($category)) $errors[] = "Kategori wajib diisi";
            if (!is_numeric($stock) || $stock < 0) {
                $errors[] = "Stok harus berupa angka dan tidak boleh kurang dari 0";
            }

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
                header('Location: ' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            // 3. Process Update
            try {
                $menuModel = new \App\Models\MenuModel();
                $menu = $menuModel->find($id);

                if (!$menu) {
                    \App\Helpers\FlashMessage::error('Menu tidak ditemukan');
                    header('Location: ' . BASE_URL . '/dashboard/menu-management');
                    exit;
                }

                $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name))) . '-' . time();
                $data = [
                    'name' => $name,
                    'slug' => $slug,
                    'price' => $price,
                    'category_id' => $category,
                    'description' => $description,
                    'stock' => (int)$stock,
                    'is_available' => ($status === 'available' || $status === '1' || $status === 'on') ? true : false
                ];

                $updated = $menuModel->update($id, $data);

                // Handle image uploads if any
                if ($updated && $images && !empty($images['name'][0])) {
                    $menuModel->addImagesToMenu($id, $images);
                }

                if ($updated) {
                    \App\Helpers\FlashMessage::success('Menu berhasil diperbarui');
                    header('Location: ' . BASE_URL . '/dashboard/menu-management');
                } else {
                    \App\Helpers\FlashMessage::error('Gagal memperbarui menu');
                    header('Location: ' . $_SERVER['HTTP_REFERER']);
                }
            } catch (\Exception $e) {
                \App\Helpers\FlashMessage::error('Terjadi kesalahan: ' . $e->getMessage());
                header('Location: ' . $_SERVER['HTTP_REFERER']);
            }
            exit;
        }
    }

    public function deleteMenu()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? '';
            if (!empty($id)) {
                $menuModel = new \App\Models\MenuModel();
                $menu = $menuModel->find($id);
                if ($menu) {
                    $result = $menuModel->deleteMenuWithAssets($id);
                    if ($result) {
                        \App\Helpers\FlashMessage::success('Menu berhasil dihapus');
                    } else {
                        \App\Helpers\FlashMessage::error('Gagal menghapus menu');
                    }
                } else {
                    \App\Helpers\FlashMessage::error('Menu tidak ditemukan');
                }
            }
            header('Location: ' . BASE_URL . '/dashboard/menu-management');
            exit;
        }
    }

    public function deleteMenuAsset()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $menuId = $_POST['menu_id'] ?? '';
            $assetId = $_POST['asset_id'] ?? '';

            if (!empty($menuId) && !empty($assetId)) {
                $db = \App\Core\Database::getInstance()->getConnection();
                
                // Get asset details
                $stmt = $db->prepare("SELECT file_path FROM assets WHERE id = :id");
                $stmt->execute(['id' => $assetId]);
                $asset = $stmt->fetch(\PDO::FETCH_ASSOC);

                if ($asset) {
                    // Delete physical file
                    $filePath = APP_ROOT . '/../' . ltrim($asset['file_path'], '/');
                    if (file_exists($filePath)) {
                        unlink($filePath);
                    }

                    // Delete pivot record
                    $stmtPivot = $db->prepare("DELETE FROM restaurant_menu_assets WHERE restaurant_menu_id = :menu_id AND assets_id = :asset_id");
                    $stmtPivot->execute(['menu_id' => $menuId, 'asset_id' => $assetId]);

                    // Delete asset record
                    $stmtAsset = $db->prepare("DELETE FROM assets WHERE id = :id");
                    $stmtAsset->execute(['id' => $assetId]);

                    \App\Helpers\FlashMessage::success('Gambar berhasil dihapus');
                } else {
                    \App\Helpers\FlashMessage::error('Gambar tidak ditemukan');
                }
            }
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            exit;
        }
    }
}
