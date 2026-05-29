<?php

namespace App\Models;

use App\Core\Model;

class OrderItemModel extends Model
{
    protected $table = 'order_item';

    /**
     * Get all items for an order with menu details
     */
    public function getItemsWithMenuDetails(int $orderId)
    {
        $stmt = $this->db->prepare(
            "SELECT oi.*, rm.name, rm.description,
                    (SELECT a.file_path 
                     FROM restaurant_menu_assets rma 
                     INNER JOIN assets a ON a.id = rma.assets_id 
                     WHERE rma.restaurant_menu_id = rm.id 
                     LIMIT 1) as image_path
             FROM order_item oi
             INNER JOIN restaurant_menu rm ON oi.restaurant_menu_id = rm.id
             WHERE oi.order_id = :order_id
             ORDER BY oi.id ASC"
        );
        $stmt->execute(['order_id' => $orderId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
}
