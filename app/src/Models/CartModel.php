<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Database;

class CartModel extends Model
{
    protected $table = 'cart';

    /**
     * Find the active cart for a given session ID
     */
    public function findActiveBySessionId(string $sessionId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE session_id = :session_id AND status = 'active' LIMIT 1"
        );
        $stmt->execute(['session_id' => $sessionId]);
        $attributes = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $attributes ? new static($attributes) : null;
    }

    /**
     * Create a new cart for a session
     */
    public function createForSession(string $sessionId, ?int $tableId = null)
    {
        $data = [
            'session_id' => $sessionId,
            'restaurant_table_id' => $tableId,
            'status' => 'active',
        ];

        // Only set user_id if logged in
        if (isset($_SESSION['user_id'])) {
            $data['user_id'] = $_SESSION['user_id'];
        }

        return $this->create($data);
    }

    /**
     * Get or create an active cart for a session
     */
    public function getOrCreateForSession(string $sessionId, ?int $tableId = null)
    {
        $cart = $this->findActiveBySessionId($sessionId);
        if (!$cart) {
            $cart = $this->createForSession($sessionId, $tableId);
        }
        return $cart;
    }

    /**
     * Get all items in this cart with menu details
     */
    public function getItemsWithMenuDetails()
    {
        $cartId = $this->attributes['id'] ?? null;
        if (!$cartId) return [];

        $stmt = $this->db->prepare(
            "SELECT ci.*, rm.name, rm.price, rm.description, rm.slug,
                    (SELECT a.file_path FROM restaurant_menu_assets rma INNER JOIN assets a ON a.id = rma.assets_id WHERE rma.restaurant_menu_id = rm.id LIMIT 1) as image_path
             FROM cart_item ci
             INNER JOIN restaurant_menu rm ON ci.restaurant_menu_id = rm.id
             WHERE ci.cart_id = :cart_id
             ORDER BY ci.created_at ASC"
        );
        $stmt->execute(['cart_id' => $cartId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Get the total amount for this cart
     */
    public function getTotal()
    {
        $cartId = $this->attributes['id'] ?? null;
        if (!$cartId) return 0;

        $stmt = $this->db->prepare(
            "SELECT SUM(ci.quantity * rm.price) as total
             FROM cart_item ci
             INNER JOIN restaurant_menu rm ON ci.restaurant_menu_id = rm.id
             WHERE ci.cart_id = :cart_id"
        );
        $stmt->execute(['cart_id' => $cartId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (float) ($result['total'] ?? 0);
    }

    /**
     * Get total item count in the cart
     */
    public function getItemCount()
    {
        $cartId = $this->attributes['id'] ?? null;
        if (!$cartId) return 0;

        $stmt = $this->db->prepare(
            "SELECT SUM(quantity) as count FROM cart_item WHERE cart_id = :cart_id"
        );
        $stmt->execute(['cart_id' => $cartId]);
        $result = $stmt->fetch(\PDO::FETCH_ASSOC);
        return (int) ($result['count'] ?? 0);
    }

    /**
     * Mark cart as checked out / completed
     */
    public function markAsCompleted()
    {
        $cartId = $this->attributes['id'] ?? null;
        if (!$cartId) return false;
        return $this->update($cartId, ['status' => 'completed']);
    }
}
