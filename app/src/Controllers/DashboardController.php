<?php

namespace App\Controllers;

use App\Core\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return $this->view('dashboard/dashboard', [
            'title' => 'dashboard'
        ]);
    }

}
