<?php

namespace App\Controllers;

use App\Core\Controller;

class CartController extends Controller
{
    public function index()
    {
        return $this->view('cart');
    }
}
