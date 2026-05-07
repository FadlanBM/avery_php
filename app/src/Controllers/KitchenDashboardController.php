<?php

namespace App\Controllers;

use App\Core\Controller;

class KitchenDashboardController extends Controller
{
    public function index()
    {
        return $this->view('kitchen_dashboard/dashboard', [
            'title' => 'Kitchen Display System - Saffron & Sage'
        ]);
    }
}
