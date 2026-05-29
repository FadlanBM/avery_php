<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CartModel;
use App\Models\CartItemModel;
use App\Models\MenuModel;

class CartController extends Controller
{
    /**
     * Ensure a session ID exists for cart tracking
     */
    private function ensureSessionId(): string
    {
        if (empty($_SESSION['cart_session_id'])) {
            $_SESSION['cart_session_id'] = session_id() . '_' . uniqid();
        }
        return $_SESSION['cart_session_id'];
    }

    /**
     * Display the cart page
     */
    public function index()
    {
        $sessionId = $this->ensureSessionId();
        $cartModel = new CartModel();
        $cart = $cartModel->findActiveBySessionId($sessionId);

        $cartItems = [];
        $total = 0;
        $itemCount = 0;

        if ($cart) {
            $cartItems = $cart->getItemsWithMenuDetails();
            $total = $cart->getTotal();
            $itemCount = $cart->getItemCount();
        }

        return $this->view('cart', [
            'title' => 'Keranjang Belanja',
            'cart' => $cart,
            'cartItems' => $cartItems,
            'total' => $total,
            'itemCount' => $itemCount,
        ]);
    }

    /**
     * API: Add an item to the cart (POST /cart/add)
     */
    public function addItem()
    {
        header('Content-Type: application/json');

        $sessionId = $this->ensureSessionId();
        $menuId = (int) ($_POST['menu_id'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 1);
        $notes = trim($_POST['notes'] ?? '');

        if ($menuId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Menu ID tidak valid']);
            return;
        }

        if ($quantity <= 0) {
            $quantity = 1;
        }

        // Verify menu exists
        $menuModel = new MenuModel();
        $menu = $menuModel->find($menuId);
        if (!$menu) {
            echo json_encode(['success' => false, 'message' => 'Menu tidak ditemukan']);
            return;
        }

        // Get or create cart
        $tableId = $_SESSION['table_id'] ?? null;
        $cartModel = new CartModel();
        $cart = $cartModel->getOrCreateForSession($sessionId, $tableId);

        if (!$cart) {
            echo json_encode(['success' => false, 'message' => 'Gagal membuat keranjang']);
            return;
        }

        // Add item to cart
        $cartItemModel = new CartItemModel();
        $result = $cartItemModel->addItem($cart->id, $menuId, $quantity, $notes ?: null);

        if ($result) {
            $refreshedCart = $cartModel->find($cart->id);
            echo json_encode([
                'success' => true,
                'message' => 'Item ditambahkan ke keranjang',
                'cartItemCount' => $refreshedCart ? $refreshedCart->getItemCount() : 0,
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal menambahkan item']);
        }
    }

    /**
     * API: Update a cart item quantity/notes (POST /cart/update)
     */
    public function updateItem()
    {
        header('Content-Type: application/json');

        $itemId = (int) ($_POST['item_id'] ?? 0);
        $quantity = (int) ($_POST['quantity'] ?? 1);
        $notes = trim($_POST['notes'] ?? '');
        $action = $_POST['action'] ?? '';

        if ($itemId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Item ID tidak valid']);
            return;
        }

        $cartItemModel = new CartItemModel();

        // Handle action-based updates
        if ($action === 'increment') {
            $item = $cartItemModel->find($itemId);
            if ($item) {
                $result = $cartItemModel->updateQuantity($itemId, $item->quantity + 1);
            }
        } elseif ($action === 'decrement') {
            $item = $cartItemModel->find($itemId);
            if ($item) {
                $newQty = $item->quantity - 1;
                if ($newQty <= 0) {
                    $result = $cartItemModel->removeItem($itemId);
                } else {
                    $result = $cartItemModel->updateQuantity($itemId, $newQty);
                }
            }
        } else {
            // Direct quantity update
            if ($quantity <= 0) {
                $result = $cartItemModel->removeItem($itemId);
            } else {
                $updateData = ['quantity' => $quantity];
                if ($notes !== '') {
                    $updateData['notes'] = $notes;
                }
                $result = $cartItemModel->update($itemId, $updateData);
            }
        }

        // Get updated totals
        $sessionId = $this->ensureSessionId();
        $cartModel = new CartModel();
        $cart = $cartModel->findActiveBySessionId($sessionId);

        echo json_encode([
            'success' => true,
            'total' => $cart ? $cart->getTotal() : 0,
            'itemCount' => $cart ? $cart->getItemCount() : 0,
        ]);
    }

    /**
     * API: Remove an item from the cart (POST /cart/remove)
     */
    public function removeItem()
    {
        header('Content-Type: application/json');

        $itemId = (int) ($_POST['item_id'] ?? 0);

        if ($itemId <= 0) {
            echo json_encode(['success' => false, 'message' => 'Item ID tidak valid']);
            return;
        }

        $cartItemModel = new CartItemModel();
        $result = $cartItemModel->removeItem($itemId);

        $sessionId = $this->ensureSessionId();
        $cartModel = new CartModel();
        $cart = $cartModel->findActiveBySessionId($sessionId);

        echo json_encode([
            'success' => $result,
            'total' => $cart ? $cart->getTotal() : 0,
            'itemCount' => $cart ? $cart->getItemCount() : 0,
        ]);
    }

    /**
     * API: Get cart data as JSON (GET /cart/api)
     */
    public function getCartApi()
    {
        header('Content-Type: application/json');

        $sessionId = $this->ensureSessionId();
        $cartModel = new CartModel();
        $cart = $cartModel->findActiveBySessionId($sessionId);

        if (!$cart) {
            echo json_encode(['success' => true, 'items' => [], 'total' => 0, 'itemCount' => 0]);
            return;
        }

        $items = $cart->getItemsWithMenuDetails();

        // Format items for API response
        $formattedItems = array_map(function ($item) {
            $imagePath = $item['image_path'] ?? 'assets/images/menu/quinoa_bowl.jpg';
            return [
                'id' => $item['id'],
                'menu_id' => $item['restaurant_menu_id'],
                'name' => $item['name'],
                'price' => (float) $item['price'],
                'quantity' => (int) $item['quantity'],
                'notes' => $item['notes'] ?? '',
                'image_path' => $imagePath,
                'subtotal' => (float) $item['price'] * (int) $item['quantity'],
            ];
        }, $items);

        echo json_encode([
            'success' => true,
            'items' => $formattedItems,
            'total' => $cart->getTotal(),
            'itemCount' => $cart->getItemCount(),
        ]);
    }
}
