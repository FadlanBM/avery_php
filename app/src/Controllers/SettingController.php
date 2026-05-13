<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\PaymentMethod;
use App\Helpers\FlashMessage;
use App\Models\MenuCategory;
use App\Models\User;
use App\Models\RoleModel;
use App\Models\RestaurantOpenSetting;

class SettingController extends Controller
{
    public function index()
    {
        $paymentModel = new \App\Models\PaymentMethod();
        $paymentMethods = $paymentModel->all();

        $restaurantModel = new \App\Models\RestaurantSetting();
        $restaurant = $restaurantModel->query()->firstWhere('id', 1);

        if ($restaurant && $restaurant->photo_profile_restorant) {
            $assetModel = new \App\Models\Asset();
            $logo = $assetModel->find($restaurant->photo_profile_restorant);
            if ($logo) {
                $restaurant->logo_path = $logo->file_path;
            }
        }

        $openSettingModel = new RestaurantOpenSetting();
        $openSettings = $openSettingModel->getOpenSettings(1);

        $categoryModel = new \App\Models\MenuCategory();
        $categories = $categoryModel->all();

        $userModel = new \App\Models\User();
        $employees = $userModel->getAllWithRoles();

        $roleModel = new \App\Models\RoleModel();
        $roles = $roleModel->all();

        return $this->view('dashboard/settings', [
            'title' => 'Pengaturan',
            'paymentMethods' => $paymentMethods,
            'restaurant' => $restaurant,
            'openSettings' => $openSettings,
            'categories' => $categories,
            'employees' => $employees,
            'roles' => $roles,
        ]);
    }



    public function createPayment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $status = $_POST['status'] ?? '';
            $isActive = ($status == 'on') ? 1 : 0;
            $createdBy = $_SESSION['user_id'] ?? null;

            if (empty($name)) {
                FlashMessage::error('Nama metode pembayaran wajib diisi.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            if (!$createdBy) {
                FlashMessage::error('Sesi tidak valid, silakan login ulang.');
                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            try {
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

    public function deletePayment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $deletedBy = $_SESSION['user_id'] ?? null;

            if (!$id) {
                FlashMessage::error('ID metode pembayaran tidak valid.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            if (!$deletedBy) {
                FlashMessage::error('Sesi tidak valid, silakan login ulang.');
                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            try {
                $payment = new PaymentMethod();
                $payment->deletePaymentMethod($id);

                FlashMessage::success('Metode pembayaran berhasil dihapus!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal menghapus metode pembayaran: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/settings');
            exit;
        }
    }

    public function createCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $createdBy = $_SESSION['user_id'] ?? null;

            if (empty($name)) {
                FlashMessage::error('Nama kategori menu wajib diisi.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            if (empty($description)) {
                FlashMessage::error('Deskripsi kategori menu wajib diisi.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }


            if (!$createdBy) {
                FlashMessage::error('Sesi tidak valid, silakan login ulang.');
                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            try {
                $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
                $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

                $menuCategory = new MenuCategory();
                $menuCategory->createCategory($name, $description, $createdBy);

                FlashMessage::success('Kategori menu berhasil ditambahkan!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal menambahkan metode pembayaran: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/settings');
            exit;
        }
    }

    public function deleteCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $deletedBy = $_SESSION['user_id'] ?? null;

            if (!$id) {
                FlashMessage::error('ID kategori menu tidak valid.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            if (!$deletedBy) {
                FlashMessage::error('Sesi tidak valid, silakan login ulang.');
                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            try {
                $menuCategory = new MenuCategory();
                $menuCategory->deleteCategory($id);

                FlashMessage::success('Kategori menu berhasil dihapus!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal menghapus kategori menu: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/settings');
            exit;
        }
    }

    public function updateCategory()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $updatedBy = $_SESSION['user_id'] ?? null;

            if (!$id) {
                FlashMessage::error('ID kategori menu tidak valid.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            if (empty($name)) {
                FlashMessage::error('Nama kategori menu wajib diisi.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            if (empty($description)) {
                FlashMessage::error('Deskripsi kategori menu wajib diisi.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }


            if (!$updatedBy) {
                FlashMessage::error('Sesi tidak valid, silakan login ulang.');
                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            try {
                $name = htmlspecialchars($name, ENT_QUOTES, 'UTF-8');
                $description = htmlspecialchars($description, ENT_QUOTES, 'UTF-8');

                $menuCategory = new MenuCategory();
                $menuCategory->updateCategory($id, $name, $description, $updatedBy);

                FlashMessage::success('Kategori menu berhasil diupdate!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal mengupdate kategori menu: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/settings');
            exit;
        }
    }


    public function getPaymentById()
    {
        // Get ID from query parameter since the Router doesn't support dynamic paths
        $id = $_GET['id'] ?? null;

        // Clear any previous output buffers to ensure only JSON is returned
        if (ob_get_length()) ob_clean();

        try {
            $paymentModel = new PaymentMethod();
            $payment = $paymentModel->findPaymentMethodById($id);

            header('Content-Type: application/json');
            if (!$payment) {
                echo json_encode(['success' => false, 'message' => 'Metode pembayaran tidak ditemukan.']);
                exit;
            }

            echo json_encode(['success' => true, 'payment' => $payment]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function updatePayment()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = trim($_POST['name'] ?? '');
            $status = $_POST['status'] ?? '';
            $isActive = ($status == 'on') ? 1 : 0;
            $updatedBy = $_SESSION['user_id'] ?? null;

            if (!$id || empty($name)) {
                FlashMessage::error('Data tidak lengkap.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            try {
                $paymentModel = new PaymentMethod();
                $paymentModel->updatePaymentMethod($id, $name, $isActive, $updatedBy);
                FlashMessage::success('Metode pembayaran berhasil diupdate!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal mengupdate metode pembayaran.');
            }

            header('Location: ' . BASE_URL . '/dashboard/settings');
            exit;
        }
    }
    public function getCategoryById()
    {
        // Get ID from query parameter since the Router doesn't support dynamic paths
        $id = $_GET['id'] ?? null;

        if (ob_get_length()) ob_clean();

        try {
            $categoryModel = new MenuCategory();
            $category = $categoryModel->findById($id);

            header('Content-Type: application/json');
            if (!$category) {
                echo json_encode(['success' => false, 'message' => 'Kategori tidak ditemukan.']);
                exit;
            }

            echo json_encode(['success' => true, 'category' => $category]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function createEmployee()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $role_id = $_POST['role_id'] ?? null;
            $status = isset($_POST['status']) ? 1 : 0;

            if (empty($name) || empty($username) || empty($password) || empty($role_id)) {
                FlashMessage::error('Semua field wajib diisi.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            try {
                $userModel = new User();
                $userModel->create([
                    'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
                    'username' => htmlspecialchars($username, ENT_QUOTES, 'UTF-8'),
                    'password' => password_hash($password, PASSWORD_DEFAULT),
                    'role_id' => $role_id,
                    'status' => $status,
                    'remamber' => '' // Mandatory field in schema
                ]);

                FlashMessage::success('Karyawan berhasil ditambahkan!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal menambahkan karyawan: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/settings');
            exit;
        }
    }

    public function updateEmployee()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = trim($_POST['name'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';
            $role_id = $_POST['role_id'] ?? null;
            $status = isset($_POST['status']) ? 1 : 0;

            if (!$id || empty($name) || empty($username) || empty($role_id)) {
                FlashMessage::error('Data tidak lengkap.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            try {
                $userModel = new User();
                $data = [
                    'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
                    'username' => htmlspecialchars($username, ENT_QUOTES, 'UTF-8'),
                    'role_id' => $role_id,
                    'status' => $status
                ];

                if (!empty($password)) {
                    $data['password'] = password_hash($password, PASSWORD_DEFAULT);
                }

                $userModel->update($id, $data);
                FlashMessage::success('Data karyawan berhasil diupdate!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal mengupdate karyawan: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/settings');
            exit;
        }
    }

    public function deleteEmployee()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                FlashMessage::error('ID karyawan tidak valid.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            try {
                $userModel = new User();
                $userModel->delete($id);
                FlashMessage::success('Karyawan berhasil dihapus!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal menghapus karyawan: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/settings');
            exit;
        }
    }

    public function getEmployeeById()
    {
        $id = $_GET['id'] ?? null;

        if (ob_get_length()) ob_clean();

        try {
            $userModel = new User();
            $user = $userModel->find($id);

            header('Content-Type: application/json');
            if (!$user) {
                echo json_encode(['success' => false, 'message' => 'Karyawan tidak ditemukan.']);
                exit;
            }

            $userData = $user->getAttributes();
            unset($userData['password']);

            echo json_encode(['success' => true, 'employee' => $userData]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function updateProfile()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $phone_number = trim($_POST['phone_number'] ?? '');

            if (empty($name) || empty($email) || empty($address) || empty($phone_number)) {
                FlashMessage::error('Semua field wajib diisi.');
                header('Location: ' . BASE_URL . '/dashboard/settings');
                exit;
            }

            try {
                $restaurantModel = new \App\Models\RestaurantSetting();
                $restaurant = $restaurantModel->find(1);

                $data = [
                    'name' => htmlspecialchars($name, ENT_QUOTES, 'UTF-8'),
                    'email' => htmlspecialchars($email, ENT_QUOTES, 'UTF-8'),
                    'address' => htmlspecialchars($address, ENT_QUOTES, 'UTF-8'),
                    'phone_number' => htmlspecialchars($phone_number, ENT_QUOTES, 'UTF-8'),
                ];

                if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
                    $fileTmpPath = $_FILES['logo']['tmp_name'];
                    $fileName = $_FILES['logo']['name'];
                    $fileSize = $_FILES['logo']['size'];
                    $fileType = $_FILES['logo']['type'];
                    $fileNameCmps = explode(".", $fileName);
                    $fileExtension = strtolower(end($fileNameCmps));

                    $allowedfileExtensions = ['jpg', 'gif', 'png', 'jpeg'];
                    if (in_array($fileExtension, $allowedfileExtensions)) {
                        $uploadFileDir = dirname(dirname(dirname(__DIR__))) . '/assets/images/logo/';
                        if (!is_dir($uploadFileDir)) {
                            mkdir($uploadFileDir, 0755, true);
                        }

                        $newFileName = 'logo_' . time() . '.' . $fileExtension;
                        $dest_path = $uploadFileDir . $newFileName;

                        if (move_uploaded_file($fileTmpPath, $dest_path)) {
                            $assetModel = new \App\Models\Asset();
                            $assetId = null;

                            if ($restaurant && $restaurant->photo_profile_restorant) {
                                $oldAsset = $assetModel->find($restaurant->photo_profile_restorant);
                                if ($oldAsset) {
                                    $oldFilePath = dirname(dirname(dirname(__DIR__))) . '/' . $oldAsset->file_path;
                                    if (file_exists($oldFilePath)) {
                                        unlink($oldFilePath);
                                    }

                                    // Update existing record
                                    $assetModel->update($oldAsset->id, [
                                        'file_name' => $newFileName,
                                        'file_path' => 'assets/images/logo/' . $newFileName,
                                        'file_type' => $fileType,
                                        'file_size_kb' => round($fileSize / 1024)
                                    ]);
                                    $assetId = $oldAsset->id;
                                }
                            }

                            if (!$assetId) {
                                $newAsset = $assetModel->create([
                                    'file_name' => $newFileName,
                                    'file_path' => 'assets/images/logo/' . $newFileName,
                                    'file_type' => $fileType,
                                    'file_size_kb' => round($fileSize / 1024),
                                    'is_public' => true
                                ]);
                                if ($newAsset) {
                                    $assetId = $newAsset->id;
                                }
                            }

                            if ($assetId) {
                                $data['photo_profile_restorant'] = $assetId;
                            }
                        }
                    }
                }

                $attributes = ['id' => 1];
                if (!$restaurant && !isset($data['photo_profile_restorant'])) {
                    $data['photo_profile_restorant'] = 1; // Default asset ID
                }

                $restaurantModel->updateOrCreate($attributes, $data);
                FlashMessage::success('Profil restoran berhasil diperbarui!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal mengupdate profil: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/settings');
            exit;
        }
    }
    public function updateOpenSetting()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $days = $_POST['days'] ?? [];
            try {
                $openSettingModel = new RestaurantOpenSetting();

                foreach ($days as $dayName => $setting) {
                    $isOpen = isset($setting['is_open']) ? '1' : '0';
                    $startTime = $setting['start_time'] ?? '00:00';
                    $endTime = $setting['end_time'] ?? '00:00';

                    $openSettingModel->updateOpenSetting(1, $dayName, $isOpen, $startTime, $endTime);
                }
                FlashMessage::success('Jam operasional berhasil diperbarui!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal memperbarui jam operasional: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/settings');
            exit;
        }
    }
}
