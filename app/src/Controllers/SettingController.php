<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\PaymentMethod;
use App\Helpers\FlashMessage;

class SettingController extends Controller
{
    public function index()
    {
        $paymentModel = new \App\Models\PaymentMethod();
        $paymentMethods = $paymentModel->all();

        $restaurantModel = new \App\Models\RestaurantSetting();
        $restaurant = $restaurantModel->query()->firstWhere('id', 1); // Assuming ID 1 is the main restaurant

        $openSettingModel = new \App\Models\RestaurantOpenSetting();
        $openSettings = $openSettingModel->all();

        $categoryModel = new \App\Models\MenuCategory();
        $categories = $categoryModel->all();

        return $this->view('dashboard/settings', [
            'title' => 'Pengaturan',
            'paymentMethods' => $paymentMethods,
            'restaurant' => $restaurant,
            'openSettings' => $openSettings,
            'categories' => $categories
        ]);
    }

    public function createPaymentMethod()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $status = $_POST['status'] ?? '';
            $isActive = ($status == 'on') ? 1 : 0;
            $createdBy = $_SESSION['user_id'] ?? null;

            // Validasi: Nama wajib diisi
            if (empty($name)) {
                FlashMessage::error('Nama metode pembayaran wajib diisi.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            // Validasi: Sesi user wajib ada
            if (!$createdBy) {
                FlashMessage::error('Sesi tidak valid, silakan login ulang.');
                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            try {
                // Sanitize input untuk keamanan XSS
                $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');

                $payment = new PaymentMethod();
                $payment->createPaymentMethod($name, $isActive, $createdBy);

                FlashMessage::success('Metode pembayaran berhasil ditambahkan!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal menambahkan metode pembayaran: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/settings');
            exit;
        }
    }
}
