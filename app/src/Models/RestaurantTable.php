<?php

namespace App\Models;

use App\Core\Model;

class RestaurantTable extends Model
{
    protected $table = 'restaurant_table';

    public function createTable($areaId, $nomorMeja, $kapasitas, $active, $createdBy)
    {
        $prefix = strtoupper(str_replace(' ', '-', $nomorMeja));
        $randomSuffix = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789"), 0, 5);
        $identityCode = $prefix . '-' . $randomSuffix;
        
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (restaurant_table_area_id, nomor_meja, kapasitas, active, is_use, identity_code, created_by) VALUES (:area_id, :nomor_meja, :kapasitas, :active, FALSE, :identity_code, :created_by)");
        return $stmt->execute([
            'area_id' => $areaId,
            'nomor_meja' => $nomorMeja,
            'kapasitas' => $kapasitas,
            'active' => $active ? true : false,
            'identity_code' => $identityCode,
            'created_by' => $createdBy
        ]);
    }

    public function getTablesByArea($areaId)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE restaurant_table_area_id = :area_id ORDER BY nomor_meja ASC");
        $stmt->execute(['area_id' => $areaId]);
        return $stmt->fetchAll();
    }

    public function deleteTable($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute(['id' => $id]);
    }

    public function findById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function countTablesByArea($areaId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM {$this->table} WHERE restaurant_table_area_id = :area_id");
        $stmt->execute(['area_id' => $areaId]);
        $row = $stmt->fetch();
        return $row ? ((int)($row['count'] ?? 0)) : 0;
    }

    public function countAvailableTablesByArea($areaId)
    {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM {$this->table} WHERE restaurant_table_area_id = :area_id AND active = TRUE AND is_use = FALSE");
        $stmt->execute(['area_id' => $areaId]);
        $row = $stmt->fetch();
        return $row ? ((int)($row['count'] ?? 0)) : 0;
    }
}
