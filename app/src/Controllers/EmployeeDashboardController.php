<?php

namespace App\Controllers;

use App\Core\Controller;

class EmployeeDashboardController extends Controller
{
    public function scanQr()
    {
        return $this->view('cashire_dashboard/scan_qr', [
            'title' => 'Scan QR Pelanggan - Saffron & Sage'
        ]);
    }

    public function pembayaranTunai()
    {
        return $this->view('cashire_dashboard/pembayaran_tunai', [
            'title' => 'Pembayaran Tunai - Saffron & Sage'
        ]);
    }
}
