<?php

namespace App\Controllers;

use App\Core\Controller;

class TablemanagementController extends Controller
{
    public function index()
    {
        return $this->view('dashboard/table_management', [
            'title' => 'Manajemen Meja'
        ]);
    }

    public function addTable()
    {
        return $this->view('dashboard/form/add_table', [
            'title' => 'Tambah Meja Baru'
        ]);
    }
}
