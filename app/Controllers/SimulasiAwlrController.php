<?php

namespace App\Controllers;
use App\Models\SimulasiSampirModel;
use App\Models\SimulasiMenemengModel;

class SimulasiAwlrController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }
        
        $sampirModel = new SimulasiSampirModel();
        $menemengModel = new SimulasiMenemengModel();

        $data_sampir = $sampirModel->findAll();
        $data_menemeng = $menemengModel->findAll();

        $max_sampir_row = $sampirModel->orderBy('tma', 'DESC')->first();
        $max_menemeng_row = $menemengModel->orderBy('tma', 'DESC')->first();

        // Klasifikasi
        $max_sampir = $max_sampir_row['tma'];
        $max_menemeng = $max_menemeng_row['tma'];

        $status_sampir = ($max_sampir > 100) ? 'Awas' : (($max_sampir > 90) ? 'Siaga' : 'Aman');
        $status_menemeng = ($max_menemeng > 100) ? 'Awas' : (($max_menemeng > 90) ? 'Siaga' : 'Aman');

        return view('admin/simulasi_awlr_view', [
            'data_sampir' => $data_sampir,
            'data_menemeng' => $data_menemeng,
            'max_sampir' => $max_sampir,
            'max_menemeng' => $max_menemeng,
            'max_sampir_time' => $max_sampir_row['waktu'],
            'max_menemeng_time' => $max_menemeng_row['waktu'],
            'status_sampir' => $status_sampir,
            'status_menemeng' => $status_menemeng,
        ]);
    }
}
