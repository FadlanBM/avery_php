<?php

namespace App\Models;

use App\Core\Model;

class MenuModel extends Model
{
    protected $table = 'restaurant_menu';

    /**
     * Create a new menu item
     */
    public function createMenu($name, $price, $category_id, $description, $images, $status, $stock = 0)
    {
        $slug = $this->generateSlug($name);
        
        $data = [
            'name' => $name,
            'slug' => $slug,
            'price' => $price,
            'category_id' => $category_id,
            'description' => $description,
            'stock' => (int)$stock,
            'is_available' => ($status === 'available' || $status === '1' || $status === 'on') ? true : false,
            'created_by' => $_SESSION['user_id'] ?? 1
        ];

        $menu = $this->create($data);
        $menuId = $menu ? $menu->id : null;

        if ($menuId && $images && !empty($images['name'][0])) {
            $this->addImagesToMenu($menuId, $images);
        }

        return $menuId;
    }

    /**
     * Add images to a menu
     */
    public function addImagesToMenu($menuId, $images)
    {
        if ($images && !empty($images['name'][0])) {
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
            return true;
        }
        return false;
    }

    /**
     * Delete a menu item and its associated assets
     */
    public function deleteMenuWithAssets($id)
    {
        $db = \App\Core\Database::getInstance()->getConnection();
        
        // Get assets linked to this menu
        $stmt = $db->prepare("
            SELECT a.id, a.file_path 
            FROM assets a 
            JOIN restaurant_menu_assets rma ON a.id = rma.assets_id 
            WHERE rma.restaurant_menu_id = :menu_id
        ");
        $stmt->execute(['menu_id' => $id]);
        $assets = $stmt->fetchAll(\PDO::FETCH_ASSOC);

        // Delete files & asset database entries
        foreach ($assets as $asset) {
            $filePath = APP_ROOT . '/../' . ltrim($asset['file_path'], '/');
            if (file_exists($filePath)) {
                unlink($filePath);
            }
            
            // Delete link in pivot table
            $stmtLink = $db->prepare("DELETE FROM restaurant_menu_assets WHERE restaurant_menu_id = :menu_id AND assets_id = :asset_id");
            $stmtLink->execute(['menu_id' => $id, 'asset_id' => $asset['id']]);

            // Delete asset in assets table
            $stmtAsset = $db->prepare("DELETE FROM assets WHERE id = :id");
            $stmtAsset->execute(['id' => $asset['id']]);
        }

        // Finally delete the menu item itself
        return $this->delete($id);
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
        $driver = $db->getAttribute(\PDO::ATTR_DRIVER_NAME);
        
        $sql = "INSERT INTO assets (file_name, file_path, file_type, file_size_kb, is_public) VALUES (:name, :path, :type, :size, :public)";
        if ($driver === 'pgsql') {
            $sql .= " RETURNING id";
        }
        
        $stmt = $db->prepare($sql);
        $stmt->execute([
            'name' => $assetData['file_name'],
            'path' => $assetData['file_path'],
            'type' => $assetData['file_type'],
            'size' => $assetData['file_size_kb'],
            'public' => $assetData['is_public'] ? true : false
        ]);
        
        $assetId = $driver === 'pgsql' ? $stmt->fetchColumn() : $db->lastInsertId();
        
        // Link to menu via restaurant_menu_assets
        $stmt = $db->prepare("INSERT INTO restaurant_menu_assets (restaurant_menu_id, assets_id) VALUES (:menu, :asset)");
        $stmt->execute(['menu' => $menuId, 'asset' => $assetId]);
    }

    public function getCategoryName()
    {
        if (empty($this->category_id)) return '';
        $stmt = $this->db->prepare("SELECT name FROM restaurant_menu_categories WHERE id = :id");
        $stmt->execute(['id' => $this->category_id]);
        $res = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $res ? $res['name'] : '';
    }

    public function getAssets()
    {
        $stmt = $this->db->prepare("
            SELECT a.* 
            FROM assets a 
            JOIN restaurant_menu_assets rma ON a.id = rma.assets_id 
            WHERE rma.restaurant_menu_id = :menu_id
        ");
        $stmt->execute(['menu_id' => $this->id]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
