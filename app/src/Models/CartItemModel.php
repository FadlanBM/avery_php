<?php

namespace App\Models;

use App\Core\Model;

class CartItemModel extends Model
{
    protected $table = 'cart_item';

    /**
     * Find a cart item by cart_id and menu_id
     */
    public function findByCartAndMenu(int $cartId, int $menuId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE cart_id = :cart_id AND restaurant_menu_id = :menu_id LIMIT 1"
        );
        $stmt->execute(['cart_id' => $cartId, 'menu_id' => $menuId]);
        $attributes = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $attributes ? new static($attributes) : null;
    }

    /**
     * Add an item to the cart, or increment quantity if it already exists
     */
    public function addItem(int $cartId, int $menuId, int $quantity = 1, ?string $notes = null)
    {
        $existing = $this->findByCartAndMenu($cartId, $menuId);

        if ($existing) {
            // Increment quantity
            $newQuantity = $existing->quantity + $quantity;
            $updateData = ['quantity' => $newQuantity];
            if ($notes !== null && $notes !== '') {
                $updateData['notes'] = $notes;
            }
            return $this->update($existing->id, $updateData);
        }

        // Create new item
        return $this->create([
            'cart_id' => $cartId,
            'restaurant_menu_id' => $menuId,
            'quantity' => $quantity,
            'notes' => $notes,
        ]);
    }

    /**
     * Update the quantity of a cart item
     */
    public function updateQuantity(int $itemId, int $quantity)
    {
        if ($quantity <= 0) {
            return $this->delete($itemId);
        }
        return $this->update($itemId, ['quantity' => $quantity]);
    }

    /**
     * Update notes for a cart item
     */
    public function updateNotes(int $itemId, string $notes)
    {
        return $this->update($itemId, ['notes' => $notes]);
    }

    /**
     * Remove an item from the cart
     */
    public function removeItem(int $itemId)
    {
        return $this->delete($itemId);
    }
}
