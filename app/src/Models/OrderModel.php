<?php

namespace App\Models;

use App\Core\Model;

class OrderModel extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $driver = $this->db->getAttribute(\PDO::ATTR_DRIVER_NAME);
        $this->table = $driver === 'pgsql' ? '"order"' : '`order`';
    }

    /**
     * Get orders by session_id
     */
    public function getOrdersBySession(string $sessionId)
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, rt.nomor_meja 
             FROM {$this->table} o
             LEFT JOIN restaurant_table rt ON o.restaurant_table_id = rt.id
             WHERE o.session_id = :session_id
             ORDER BY o.created_at DESC"
        );
        $stmt->execute(['session_id' => $sessionId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get detailed order with table and payment method
     */
    public function getOrderWithDetails(int $orderId)
    {
        $stmt = $this->db->prepare(
            "SELECT o.*, rt.nomor_meja, pm.name as payment_method_name
             FROM {$this->table} o
             LEFT JOIN restaurant_table rt ON o.restaurant_table_id = rt.id
             LEFT JOIN payment_method pm ON o.payment_method_id = pm.id
             WHERE o.id = :order_id
             LIMIT 1"
        );
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
