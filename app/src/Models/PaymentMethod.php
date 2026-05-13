<?php

namespace App\Models;

use App\Core\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_method';

    public function createPaymentMethod($name, $isActive, $createdBy)
    {
        $stmt = $this->db->prepare("INSERT INTO {$this->table} (name, is_active, created_by) VALUES (:name, :is_active, :created_by)");
        $stmt->execute([
            'name' => $name,
            'is_active' => $isActive,
            'created_by' => $createdBy
        ]);
    }

    public function deletePaymentMethod($id)
    {
        $stmt = $this->db->prepare("DELETE FROM {$this->table}  WHERE id = :id");
        $stmt->execute([
            'id' => $id,
        ]);
    }

    public function updatePaymentMethod($id, $name, $isActive, $createdBy)
    {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET name = :name, is_active = :is_active, created_by = :created_by WHERE id = :id");
        $stmt->execute([
            'id' => $id,
            'name' => $name,
            'is_active' => $isActive,
            'created_by' => $createdBy
        ]);
    }

    public function findPaymentMethodById($id)
    {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE id = :id");
        $stmt->execute([
            'id' => $id
        ]);
        return $stmt->fetch();
    }
}
