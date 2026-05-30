<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\RestaurantTable;

class ScanqrController extends Controller
{
    public function index()
    {
        return $this->view('scanqr');
    }

    public function processScan()
    {
        $qrCodeData = $_POST['qr_code_data'] ?? '';

        // Proses data QR code sesuai kebutuhan
        // Misalnya, validasi data, simpan ke database, dll.

        // Contoh respons sederhana
        return $this->view('scanqr_result', [
            'title' => 'Hasil Pindai QR',
            'qrCodeData' => $qrCodeData
        ]);
    }

    public function inputManualCode()
    {
        $codeData = strtoupper(trim($_POST['code_data'] ?? ''));

        if ($codeData === '') {
            return $this->view('scanqr', [
                'error' => 'Kode meja wajib diisi.'
            ]);
        }

        $tableModel = new RestaurantTable();
        $table = $tableModel->findByIdentityCode($codeData);

        if (!$table) {
            return $this->view('scanqr', [
                'error' => 'Kode meja tidak ditemukan. Periksa kembali kode yang dimasukkan.',
                'codeData' => $codeData
            ]);
        }

        if (!($table['active'] === true || $table['active'] == 1 || $table['active'] === 't' || $table['active'] === 'true')) {
            return $this->view('scanqr', [
                'error' => 'Meja ini sedang tidak aktif. Silakan hubungi staf restoran.',
                'codeData' => $codeData
            ]);
        }

        $this->storeTableContext($table);

        header('Location: ' . BASE_URL . '/menu?table=' . urlencode($table['identity_code']));
        exit;
    }

    public function logoutTable()
    {
        unset($_SESSION['table_id'], $_SESSION['table_code'], $_SESSION['table_number']);

        $secure = parse_url(BASE_URL, PHP_URL_SCHEME) === 'https';
        $expired = time() - 3600;

        setcookie('table_code', '', [
            'expires' => $expired,
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        setcookie('table_number', '', [
            'expires' => $expired,
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        header('Location: ' . BASE_URL . '/scan-qr');
        exit;
    }

    private function storeTableContext($table)
    {
        $_SESSION['table_id'] = $table['id'];
        $_SESSION['table_code'] = $table['identity_code'];
        $_SESSION['table_number'] = $table['nomor_meja'];

        $secure = parse_url(BASE_URL, PHP_URL_SCHEME) === 'https';
        $expires = time() + (60 * 60 * 12);

        setcookie('table_code', $table['identity_code'], [
            'expires' => $expires,
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);

        setcookie('table_number', $table['nomor_meja'], [
            'expires' => $expires,
            'path' => '/',
            'secure' => $secure,
            'httponly' => true,
            'samesite' => 'Lax'
        ]);
    }
}
