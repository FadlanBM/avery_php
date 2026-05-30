<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\MenuCategory;
use App\Models\MenuModel;
use App\Models\RestaurantTable;

class MenuController extends Controller
{
    public function index()
    {
        $categoryModel = new MenuCategory();
        $categories = $categoryModel->all();
        $selectedCategoryId = isset($_GET['category']) && is_numeric($_GET['category']) ? (int) $_GET['category'] : null;
        $menuModel = new MenuModel();
        $menus = $this->getAvailableMenus($menuModel->all(), $selectedCategoryId);
        $tableCode = strtoupper(trim($_GET['table'] ?? ($_SESSION['table_code'] ?? ($_COOKIE['table_code'] ?? ''))));
        $currentTable = null;
        $error = null;

        if ($tableCode !== '') {
            $tableModel = new RestaurantTable();
            $currentTable = $tableModel->findByIdentityCode($tableCode);

            if (!$currentTable) {
                unset($_SESSION['table_code'], $_SESSION['table_id'], $_SESSION['table_number']);
                $error = 'Kode meja tidak valid. Silakan scan QR atau masukkan kode meja kembali.';
            } elseif (!$this->isTableActive($currentTable)) {
                unset($_SESSION['table_code'], $_SESSION['table_id'], $_SESSION['table_number']);
                $currentTable = null;
                $error = 'Meja ini sedang tidak aktif. Silakan hubungi staf restoran.';
            } else {
                $_SESSION['table_code'] = $currentTable['identity_code'];
                $_SESSION['table_id'] = $currentTable['id'];
                $_SESSION['table_number'] = $currentTable['nomor_meja'];
            }
        }

        return $this->view('menu', [
            'title' => 'Menu',
            'currentTable' => $currentTable,
            'tableError' => $error,
            'categories' => $categories,
            'menus' => $menus,
            'selectedCategoryId' => $selectedCategoryId
        ]);
    }

    private function getAvailableMenus($menus, $selectedCategoryId = null)
    {
        $availableMenus = [];

        foreach ($menus as $menu) {
            if (!$this->isMenuAvailable($menu)) {
                continue;
            }

            if ($selectedCategoryId !== null && (int) $menu->category_id !== $selectedCategoryId) {
                continue;
            }

            $assets = $menu->getAssets();
            $primaryImage = !empty($assets) ? $assets[0]['file_path'] : 'assets/images/menu/quinoa_bowl.jpg';

            $availableMenus[] = [
                'id' => $menu->id,
                'name' => $menu->name,
                'price' => $menu->price,
                'description' => $menu->description,
                'category_id' => $menu->category_id,
                'category_name' => $menu->getCategoryName(),
                'image_path' => $primaryImage
            ];
        }

        return $availableMenus;
    }

    private function isMenuAvailable($menu)
    {
        return $menu->is_available === true
            || $menu->is_available == 1
            || $menu->is_available === 't'
            || $menu->is_available === 'true';
    }

    private function isTableActive($table)
    {
        return $table['active'] === true
            || $table['active'] == 1
            || $table['active'] === 't'
            || $table['active'] === 'true';
    }
}
