<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class HistoryController extends Controller
{
    /**
     * Render the order history page
     */
    public function index()
    {
        $sessionId = $_SESSION['cart_session_id'] ?? null;
        
        if (!$sessionId) {
            // No active session (haven't scanned QR), redirect to menu
            header('Location: ' . BASE_URL . '/menu');
            return;
        }

        $orderModel = new OrderModel();
        $orders = $orderModel->getOrdersBySession($sessionId);

        $orderItemModel = new OrderItemModel();
        $ordersWithItems = [];
        foreach ($orders as $order) {
            $items = $orderItemModel->getItemsWithMenuDetails((int)$order['id']);
            $ordersWithItems[] = [
                'order' => $order,
                'items' => $items
            ];
        }

        return $this->view('history', [
            'title' => 'Riwayat Pesanan Saya',
            'ordersWithItems' => $ordersWithItems,
            'tableNumber' => $_SESSION['table_number'] ?? null,
        ]);
    }
}
