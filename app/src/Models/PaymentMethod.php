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
}
