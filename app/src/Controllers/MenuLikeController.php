<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\MenuLikeModel;

class MenuLikeController extends Controller
{
    private function ensureSessionId(): string
    {
        if (empty($_SESSION['cart_session_id'])) {
            $_SESSION['cart_session_id'] = session_id() . '_' . uniqid();
        }
        return $_SESSION['cart_session_id'];
    }

    /**
     * Toggle like for a menu item (POST /like/toggle)
     */
    public function toggle()
    {
        header('Content-Type: application/json');

        $sessionId = $this->ensureSessionId();
        $menuId = (int) ($_POST['menu_id'] ?? 0);

        if ($menuId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Menu ID tidak valid']);
            return;
        }

        $likeModel = new MenuLikeModel();
        $isLiked = $likeModel->toggleLike($sessionId, $menuId);

        echo json_encode([
            'success' => true,
            'liked' => $isLiked,
        ]);
    }
}
