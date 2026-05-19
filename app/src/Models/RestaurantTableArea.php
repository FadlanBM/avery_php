<?php

namespace App\Models;

use App\Core\Model;

class RestaurantTableArea extends Model
{
    protected $table = 'restaurant_table_area';

    public function createArea($name, $description, $createdBy)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, description, created_by) VALUES (:name, :description, :created_by)");
        return $stmt->execute([
            'name' => $name,
            'description' => $description,
            'created_by' => $createdBy
        ]);
    }

    public function updateArea($id, $name, $description, $updatedBy = null)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET name = :name, description = :description, updated_at = CURRENT_TIMESTAMP WHERE id = :id");
        return $stmt->execute([
            'id' => $id,
            'name' => $name,
            'description' => $description
        ]);
    }

    public function deleteArea($id)
    {
        try {
            $this->db->beginTransaction();

            // 1. Hapus semua meja yang berasosiasi dengan area ini
            $stmtTable = $this->db->prepare("DELETE FROM restaurant_table WHERE restaurant_table_area_id = :area_id");
            $stmtTable->execute(['area_id' => $id]);

            // 2. Hapus area itu sendiri
            $stmtArea = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
            $result = $stmtArea->execute(['id' => $id]);

            $this->db->commit();
            return $result;
        } catch (\Exception $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            throw $e;
        }
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
