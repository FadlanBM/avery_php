<?php

namespace App\Controllers;

use App\Core\Controller;

class ManageuserController extends Controller
{
    public function index()
    {
        return $this->view('dashboard/manageuser', [
            'title' => 'Manage User'
        ]);
    }
}
