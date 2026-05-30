<?php

namespace App\Models;

use App\Core\Model;

class MenuLikeModel extends Model
{
    protected $table = 'restaurant_menu_like';

    /**
     * Toggle like for a menu item by session_id
     * Returns true if liked, false if unliked
     */
    public function toggleLike(string $sessionId, int $menuId): bool
    {
        $existing = $this->findBySessionAndMenu($sessionId, $menuId);

        if ($existing) {
            // Unlike: remove the record
            $this->delete($existing->id);
            return false;
        }

        // Like: create the record
        $data = [
            'session_id' => $sessionId,
            'restaurant_menu_id' => $menuId,
        ];

        if (isset($_SESSION['user_id'])) {
            $data['user_id'] = $_SESSION['user_id'];
        }

        $this->create($data);
        return true;
    }

    /**
     * Check if a menu item is liked by a session
     */
    public function isLiked(string $sessionId, int $menuId): bool
    {
        $existing = $this->findBySessionAndMenu($sessionId, $menuId);
        return $existing !== null;
    }

    /**
     * Find like by session and menu
     */
    public function findBySessionAndMenu(string $sessionId, int $menuId)
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM {$this->table} WHERE session_id = :session_id AND restaurant_menu_id = :menu_id LIMIT 1"
        );
        $stmt->execute(['session_id' => $sessionId, 'menu_id' => $menuId]);
        $attributes = $stmt->fetch(\PDO::FETCH_ASSOC);
        return $attributes ? new static($attributes) : null;
    }

    /**
     * Get all liked menu IDs for a session
     */
    public function getLikedMenuIds(string $sessionId): array
    {
        $stmt = $this->db->prepare(
            "SELECT restaurant_menu_id FROM {$this->table} WHERE session_id = :session_id"
        );
        $stmt->execute(['session_id' => $sessionId]);
        return $stmt->fetchAll(\PDO::FETCH_COLUMN);
    }
}
