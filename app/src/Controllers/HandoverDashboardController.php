<?php

namespace App\Controllers;

use App\Core\Controller;

class HandoverDashboardController extends Controller
{
    public function orderHandover()
    {
        return $this->view('handover_dashboard/order_handover', [
            'title' => 'Order Handover & Validation - Saffron & Sage'
        ]);
    }

    public function qrMassal()
    {
        return $this->view('handover_dashboard/qr_massal', [
            'title' => 'Pindai QR Massal - Saffron & Sage'
        ]);
    }
}
