<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\CartModel;
use App\Models\PaymentMethod;
use App\Models\OrderModel;
use App\Models\OrderItemModel;

class CheckoutController extends Controller
{
    /**
     * Ensure a session ID exists for checkout tracking
     */
    private function ensureSessionId(): string
    {
        if (empty($_SESSION['cart_session_id'])) {
            $_SESSION['cart_session_id'] = session_id() . '_' . uniqid();
        }
        return $_SESSION['cart_session_id'];
    }

    /**
     * Render checkout page
     */
    public function index()
    {
        $sessionId = $this->ensureSessionId();
        
        // 1. Get active cart
        $cartModel = new CartModel();
        $cart = $cartModel->findActiveBySessionId($sessionId);
        
        if (!$cart || $cart->getItemCount() === 0) {
            $_SESSION['error'] = 'Keranjang belanja Anda kosong.';
            header('Location: /menu');
            return;
        }
        
        $cartItems = $cart->getItemsWithMenuDetails();
        $subtotal = $cart->getTotal();
        
        // Calculate charges
        $tax = $subtotal * 0.10; // 10% tax
        $serviceCharge = 5000; // Service charge Rp 5,000
        $total = $subtotal + $tax + $serviceCharge;
        
        // 2. Get active payment methods
        $paymentMethodModel = new PaymentMethod();
        $allPaymentMethods = $paymentMethodModel->all();
        $paymentMethods = array_filter($allPaymentMethods, function($pm) {
            $active = $pm->is_active;
            return $active === true || $active == 1 || $active === 't' || $active === 'true';
        });
        
        return $this->view('checkout', [
            'title' => 'Checkout Pesanan',
            'cart' => $cart,
            'cartItems' => $cartItems,
            'subtotal' => $subtotal,
            'tax' => $tax,
            'serviceCharge' => $serviceCharge,
            'total' => $total,
            'paymentMethods' => $paymentMethods,
            'tableNumber' => $_SESSION['table_number'] ?? null,
        ]);
    }

    /**
     * Process checkout form submission
     */
    public function process()
    {
        $sessionId = $this->ensureSessionId();
        
        // 1. Get active cart
        $cartModel = new CartModel();
        $cart = $cartModel->findActiveBySessionId($sessionId);
        
        if (!$cart || $cart->getItemCount() === 0) {
            $_SESSION['error'] = 'Keranjang belanja Anda kosong.';
            header('Location: /menu');
            return;
        }
        
        // 2. Validate input
        $paymentMethodId = (int) ($_POST['payment_method_id'] ?? 0);
        $notes = trim($_POST['notes'] ?? '');
        
        if ($paymentMethodId <= 0) {
            $_SESSION['error'] = 'Silakan pilih metode pembayaran.';
            header('Location: /checkout');
            return;
        }
        
        // 3. Calculate financial details
        $cartItems = $cart->getItemsWithMenuDetails();
        $subtotal = $cart->getTotal();
        $tax = $subtotal * 0.10;
        $serviceCharge = 5000;
        $total = $subtotal + $tax + $serviceCharge;
        
        $tableId = $_SESSION['table_id'] ?? null;
        
        // Fetch payment method name to check if cash
        $paymentMethodModel = new PaymentMethod();
        $paymentMethod = $paymentMethodModel->find($paymentMethodId);
        $paymentMethodName = $paymentMethod->name ?? '';

        $paymentCode = null;
        $orderModel = new OrderModel();
        if (\App\Helpers\PaymentCodeHelper::isCash($paymentMethodName)) {
            do {
                $paymentCode = \App\Helpers\PaymentCodeHelper::generate();
                $existing = $orderModel->firstWhere('payment_code', $paymentCode);
            } while ($existing !== null);
        }

        // 4. Create Order
        $order = $orderModel->create([
            'cart_id' => $cart->id,
            'session_id' => $sessionId,
            'restaurant_table_id' => $tableId,
            'payment_method_id' => $paymentMethodId,
            'status' => 'pending',
            'notes' => $notes ?: null,
            'subtotal' => $subtotal,
            'tax_amount' => $tax,
            'service_charge' => $serviceCharge,
            'total_amount' => $total,
            'payment_code' => $paymentCode
        ]);
        
        if (!$order) {
            $_SESSION['error'] = 'Terjadi kesalahan saat memproses pesanan. Silakan coba lagi.';
            header('Location: /checkout');
            return;
        }
        
        // 5. Create Order Items (snapshot)
        $orderItemModel = new OrderItemModel();
        foreach ($cartItems as $item) {
            $itemSubtotal = $item['price'] * $item['quantity'];
            $orderItemModel->create([
                'order_id' => $order->id,
                'restaurant_menu_id' => $item['restaurant_menu_id'],
                'quantity' => $item['quantity'],
                'unit_price' => $item['price'],
                'subtotal' => $itemSubtotal,
                'notes' => $item['notes'] ?: null
            ]);
        }
        
        // 6. Complete/Update the Cart status so it is no longer active
        $cartModel->update($cart->id, [
            'status' => 'completed'
        ]);
        
        // 7. Save order ID to session for order-tracking page
        $_SESSION['last_order_id'] = $order->id;
        
        // Redirect to order tracking page
        header('Location: /order-tracking?order_id=' . $order->id);
        return;
    }
}
