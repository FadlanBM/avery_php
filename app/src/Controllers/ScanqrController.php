<?php

namespace App\Controllers;

use App\Core\Controller;

class ScanqrController extends Controller
{
    public function index()
    {
        return $this->view('scanqr');
    }
}
