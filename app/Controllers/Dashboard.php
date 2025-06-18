<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }
        return view('dashboard'); // akan memuat app/Views/dashboard.php
    }
}
