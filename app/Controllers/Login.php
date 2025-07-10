<?php

namespace App\Controllers;

use App\Models\UserModel;

class Login extends BaseController
{
    public function index()
    {
        return view('login');
    }

    public function auth()
{
    $username = $this->request->getPost('username');
    $password = md5($this->request->getPost('password'));

    $userModel = new UserModel();
    $user = $userModel->where('username', $username)
                      ->where('password', $password)
                      ->first();

    if ($user) {
        session()->set('logged_in', true);
        session()->set('username', $user['username']);
        return redirect()->to(base_url('/')); // ← redirect ke halaman peta
    } else {
        session()->setFlashdata('error', 'Login gagal. Username atau password salah.');
        return redirect()->to(base_url('/'));
    }
}


    public function logout()
    {
        session()->destroy(); // Hapus semua session
        return redirect()->to(base_url('/')); // Kembali ke halaman peta
    }
}

