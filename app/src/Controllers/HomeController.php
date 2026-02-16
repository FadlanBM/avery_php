<?php

namespace App\Controllers;

use App\Core\Controller;

class HomeController extends Controller
{
    public function index()
    {
        $jam = date('H');
        $salam = "";

        if ($jam >= 5 && $jam < 12) {
            $salam = "Selamat Pagi";
        } elseif ($jam >= 12 && $jam < 15) {
            $salam = "Selamat Siang";
        } elseif ($jam >= 15 && $jam < 18) {
            $salam = "Selamat Sore";
        } else {
            $salam = "Selamat Malam";
        }

        $data = [
            'nama_website' => 'Cuaca PHP',
            'salam' => $salam,
            'time' => date('H:i:s'),
            'date' => date('d F Y'),
            'php_version' => phpversion()
        ];

        return $this->view('home', $data);
    }
}
