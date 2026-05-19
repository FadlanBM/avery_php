<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Helpers\FlashMessage;
use App\Models\RestaurantTableArea;

class TablemanagementController extends Controller
{
    public function index()
    {
        $areaModel = new RestaurantTableArea();
        $tableModel = new \App\Models\RestaurantTable();
        $areas = $areaModel->all();

        foreach ($areas as $area) {
            $area->tablesCount = (int) $tableModel->countTablesByArea($area->id);
            $area->available = (int) $tableModel->countAvailableTablesByArea($area->id);
        }

        return $this->view('dashboard/table_management', [
            'title' => 'Manajemen Meja',
            'areas' => $areas
        ]);
    }

    public function createArea()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $createdBy = $_SESSION['user_id'] ?? null;

            if (empty($name)) {
                FlashMessage::error('Nama area wajib diisi.');
                header('Location: ' . BASE_URL . '/dashboard/table-management');
                exit;
            }

            if (!$createdBy) {
                FlashMessage::error('Sesi tidak valid, silakan login ulang.');
                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            try {
                $areaModel = new RestaurantTableArea();
                $areaModel->createArea($name, $description, $createdBy);
                FlashMessage::success('Area meja berhasil ditambahkan!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal menambahkan area meja: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/table-management');
            exit;
        }
    }

    public function updateArea()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;
            $name = trim($_POST['name'] ?? '');
            $description = trim($_POST['description'] ?? '');

            if (!$id || empty($name)) {
                FlashMessage::error('Data tidak lengkap.');
                header('Location: ' . BASE_URL . '/dashboard/table-management');
                exit;
            }

            $updatedBy = $_SESSION['user_id'] ?? null;
            if (!$updatedBy) {
                FlashMessage::error('Sesi tidak valid, silakan login ulang.');
                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            try {
                $areaModel = new RestaurantTableArea();
                $areaModel->updateArea($id, $name, $description, $updatedBy);
                FlashMessage::success('Area meja berhasil diperbarui!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal memperbarui area meja: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/table-management');
            exit;
        }
    }

    public function deleteArea()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                FlashMessage::error('ID area tidak valid.');
                header('Location: ' . BASE_URL . '/dashboard/table-management');
                exit;
            }

            try {
                $areaModel = new RestaurantTableArea();
                $areaModel->deleteArea($id);
                FlashMessage::success('Area meja berhasil dihapus!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal menghapus area meja: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/table-management');
            exit;
        }
    }

    public function getAreaById()
    {
        $id = $_GET['id'] ?? null;

        if (ob_get_length()) ob_clean();

        try {
            $areaModel = new RestaurantTableArea();
            $area = $areaModel->findById($id);

            header('Content-Type: application/json');
            if (!$area) {
                echo json_encode(['success' => false, 'message' => 'Area tidak ditemukan.']);
                exit;
            }

            echo json_encode(['success' => true, 'area' => $area]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function createTable()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $areaId = $_POST['area_id'] ?? null;
            $nomorMeja = trim($_POST['nomor_meja'] ?? '');
            $kapasitas = intval($_POST['kapasitas'] ?? 0);
            $active = isset($_POST['active']) ? 1 : 0;
            $createdBy = $_SESSION['user_id'] ?? null;

            if (!$areaId || empty($nomorMeja) || $kapasitas <= 0) {
                FlashMessage::error('Data meja tidak lengkap.');
                header('Location: ' . BASE_URL . '/dashboard/table-management');
                exit;
            }

            if (!$createdBy) {
                FlashMessage::error('Sesi tidak valid, silakan login ulang.');
                header('Location: ' . BASE_URL . '/login');
                exit;
            }

            try {
                $tableModel = new \App\Models\RestaurantTable();
                $tableModel->createTable($areaId, $nomorMeja, $kapasitas, $active, $createdBy);
                FlashMessage::success('Meja berhasil ditambahkan!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal menambahkan meja: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/table-management');
            exit;
        }
    }

    public function getTablesByArea()
    {
        $areaId = $_GET['area_id'] ?? null;

        if (ob_get_length()) ob_clean();

        try {
            $tableModel = new \App\Models\RestaurantTable();
            $tables = $tableModel->getTablesByArea($areaId);

            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'tables' => $tables]);
        } catch (\Exception $e) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => $e->getMessage()]);
        }
        exit;
    }

    public function deleteTable()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'] ?? null;

            if (!$id) {
                FlashMessage::error('ID meja tidak valid.');
                header('Location: ' . BASE_URL . '/dashboard/table-management');
                exit;
            }

            try {
                $tableModel = new \App\Models\RestaurantTable();
                $tableModel->deleteTable($id);
                FlashMessage::success('Meja berhasil dihapus!');
            } catch (\Exception $e) {
                FlashMessage::error('Gagal menghapus meja: ' . $e->getMessage());
            }

            header('Location: ' . BASE_URL . '/dashboard/table-management');
            exit;
        }
    }
}
