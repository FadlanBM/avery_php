<?php

namespace App\Models;

use App\Core\Model;

class MenuModel extends Model
{
    protected $table = 'restaurant_menu';

    /**
     * Create a new menu item
     */
    public function createMenu($name, $price, $category_id, $description, $images, $status)
    {
        $slug = $this->generateSlug($name);
        
        $data = [
            'name' => $name,
            'slug' => $slug,
            'price' => $price,
            'category_id' => $category_id,
            'description' => $description,
            'stock' => 0,
            'is_available' => ($status === 'available' || $status === '1' || $status === 'on') ? 1 : 0,
            'created_by' => $_SESSION['user_id'] ?? 1
        ];

        $menu = $this->create($data);
        $menuId = $menu ? $menu->id : null;

        if ($menuId && $images && !empty($images['name'][0])) {
            foreach ($images['name'] as $index => $name) {
                $file = [
                    'name' => $images['name'][$index],
                    'type' => $images['type'][$index],
                    'tmp_name' => $images['tmp_name'][$index],
                    'error' => $images['error'][$index],
                    'size' => $images['size'][$index]
                ];
                
                $imagePath = $this->handleImageUpload($file);
                if ($imagePath) {
                    $this->saveMenuAsset($menuId, $imagePath);
                }
            }
        }

        return $menuId;
    }

    protected function generateSlug($name)
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', '-', $name)));
        return $slug . '-' . time();
    }

    protected function handleImageUpload($file)
    {
        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            return null;
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $fileName = time() . '_' . uniqid() . '.' . $extension;
        $targetDir = APP_ROOT . '/../assets/images/menu/';
        
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            return 'assets/images/menu/' . $fileName;
        }

        return null;
    }

    protected function saveMenuAsset($menuId, $imagePath)
    {
        // Insert into assets table
        $assetData = [
            'file_name' => basename($imagePath),
            'file_path' => $imagePath,
            'file_type' => 'image',
            'file_size_kb' => 0, // Should calculate if needed
            'is_public' => 1
        ];
        
        // Using PDO directly or a separate model
        $db = \App\Core\Database::getInstance()->getConnection();
        $stmt = $db->prepare("INSERT INTO assets (file_name, file_path, file_type, file_size_kb, is_public) VALUES (:name, :path, :type, :size, :public)");
        $stmt->execute([
            'name' => $assetData['file_name'],
            'path' => $assetData['file_path'],
            'type' => $assetData['file_type'],
            'size' => $assetData['file_size_kb'],
            'public' => $assetData['is_public']
        ]);
        
        $assetId = $db->lastInsertId();
        
        // Link to menu via restaurant_menu_assets
        $stmt = $db->prepare("INSERT INTO restaurant_menu_assets (restaurant_menu_id, assets_id) VALUES (:menu, :asset)");
        $stmt->execute(['menu' => $menuId, 'asset' => $assetId]);
    }
}
