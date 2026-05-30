<?php

namespace App\Models;

use App\Core\Model;

class MenuCategory extends Model
{
    protected $table = 'restaurant_menu_categories';

    public function createCategory($name, $description, $createdBy)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, description, created_by) VALUES (:name, :description, :created_by)");
        $stmt->execute([
            'name' => $name,
            'description' => $description,
            'created_by' => $createdBy
        ]);
    }
    public function deleteCategory($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table}  WHERE id = :id");
        $stmt->execute([
            'id' => $id,
        ]);
    }

    public function updateCategory($id, $name, $description, $createdBy)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET name = :name, description = :description, created_by = :created_by WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description,
            'created_by' => $createdBy
        ]);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch();
    }
}
