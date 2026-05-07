<?php

namespace App\Controllers;

use App\Core\Controller;

class OrderController extends Controller
{
    public function index()
    {
        return $this->view('order_tracking');
    }
}
