<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        helper('url'); // ← panggil di sini
        return view('map_view');
    }
}
