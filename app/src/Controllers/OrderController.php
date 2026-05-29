<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class OrderController extends Controller
{
    /**
     * Display order tracking page
     */
    public function index()
    {
        $orderId = isset($_GET['order_id']) ? (int) $_GET['order_id'] : ($_SESSION['last_order_id'] ?? null);

        if (!$orderId) {
            header('Location: /menu');
            return;
        }

        $orderModel = new OrderModel();
        $order = $orderModel->getOrderWithDetails($orderId);

        if (!$order) {
            $_SESSION['error'] = 'Pesanan tidak ditemukan.';
            header('Location: /menu');
            return;
        }

        // Verify session matches order's session_id to restrict access
        $currentSessionId = $_SESSION['cart_session_id'] ?? '';
        if ($order['session_id'] !== $currentSessionId) {
            $_SESSION['error'] = 'Anda tidak memiliki akses ke pesanan ini.';
            header('Location: /menu');
            return;
        }

        $orderItemModel = new OrderItemModel();
        $orderItems = $orderItemModel->getItemsWithMenuDetails($orderId);

        return $this->view('order_tracking', [
            'title' => 'Status Pesanan',
            'order' => $order,
            'orderItems' => $orderItems
        ]);
    }

    /**
     * API: Get order status for polling (GET /order/status)
     */
    public function getStatus()
    {
        header('Content-Type: application/json');

        $orderId = isset($_GET['order_id']) ? (int) $_GET['order_id'] : ($_SESSION['last_order_id'] ?? null);

        if (!$orderId) {
            echo json_encode(['success' => false, 'message' => 'Order ID tidak valid']);
            return;
        }

        $orderModel = new OrderModel();
        $order = $orderModel->find($orderId);

        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Pesanan tidak ditemukan']);
            return;
        }

        // Verify session matches order's session_id
        $currentSessionId = $_SESSION['cart_session_id'] ?? '';
        if ($order->session_id !== $currentSessionId) {
            echo json_encode(['success' => false, 'message' => 'Akses ditolak']);
            return;
        }

        echo json_encode([
            'success' => true,
            'status' => $order->status,
            'updated_at' => $order->updated_at
        ]);
    }
}
