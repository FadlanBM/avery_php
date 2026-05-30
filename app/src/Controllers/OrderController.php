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

    /**
     * API: cashier lookup order by payment_code (GET /order/lookup)
     */
    public function lookupByCode()
    {
        header('Content-Type: application/json');

        $code = $_GET['code'] ?? null;
        if (!$code) {
            echo json_encode(['success' => false, 'message' => 'Kode pembayaran tidak valid']);
            return;
        }

        $orderModel = new OrderModel();
        $order = $orderModel->getOrderWithDetails_byCode($code);

        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Pesanan tidak ditemukan']);
            return;
        }

        $orderItemModel = new OrderItemModel();
        $items = $orderItemModel->getItemsWithMenuDetails($order['id']);

        echo json_encode([
            'success' => true,
            'order' => $order,
            'items' => $items
        ]);
    }

    /**
     * Cancel pending order (POST /order/cancel)
     */
    public function cancel()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo json_encode(['success' => false, 'message' => 'Method not allowed']);
            return;
        }

        $orderId = $_POST['order_id'] ?? null;
        $sessionId = $_SESSION['cart_session_id'] ?? null;

        if (!$orderId || !$sessionId) {
            echo json_encode(['success' => false, 'message' => 'Akses tidak sah atau parameter salah']);
            return;
        }

        $orderModel = new OrderModel();
        $order = $orderModel->find((int)$orderId);

        if (!$order) {
            echo json_encode(['success' => false, 'message' => 'Pesanan tidak ditemukan']);
            return;
        }

        // Pastikan order milik session ini
        if ($order->session_id !== $sessionId) {
            echo json_encode(['success' => false, 'message' => 'Anda tidak memiliki hak untuk membatalkan pesanan ini']);
            return;
        }

        // Pastikan status masih pending
        if ($order->status !== 'pending') {
            echo json_encode(['success' => false, 'message' => 'Pesanan tidak dapat dibatalkan karena sudah diproses']);
            return;
        }

        // Update status ke cancelled
        $updated = $orderModel->update((int)$orderId, [
            'status' => 'cancelled',
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        if ($updated) {
            echo json_encode(['success' => true, 'message' => 'Pesanan berhasil dibatalkan']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Gagal membatalkan pesanan']);
        }
    }
}
