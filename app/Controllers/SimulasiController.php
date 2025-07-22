<?php

namespace App\Controllers;

class SimulasiController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }
        
        $db = db_connect();

        // Ambil data dari database
        $tiu = $db->table('simulasi_tiu_suntuk')->get()->getResultArray();
        $bano = $db->table('simulasi_bintang_bano')->get()->getResultArray();

        // Cari baris dengan elevasi maksimum
        $max_tiu_row = array_reduce($tiu, function($carry, $item) {
            return (!$carry || $item['elevasi'] > $carry['elevasi']) ? $item : $carry;
        });

        $max_bano_row = array_reduce($bano, function($carry, $item) {
            return (!$carry || $item['elevasi'] > $carry['elevasi']) ? $item : $carry;
        });

        // Nilai maksimum dan waktunya
        $max_tiu = $max_tiu_row['elevasi'];
        $max_tiu_time = $max_tiu_row['waktu'];

        $max_bano = $max_bano_row['elevasi'];
        $max_bano_time = $max_bano_row['waktu'];

        // Klasifikasi status berdasarkan elevasi
        $status_tiu = ($max_tiu > 105) ? 'Awas' : (($max_tiu > 104) ? 'Siaga' : 'Aman');
        $status_bano = ($max_bano > 112) ? 'Awas' : (($max_bano > 111) ? 'Siaga' : 'Aman');

        // Kirim ke view
        return view('admin/simulasi_view', [
            'tiu_suntuk' => $tiu,
            'bintang_bano' => $bano,
            'max_tiu' => $max_tiu,
            'max_tiu_time' => $max_tiu_time,
            'max_bano' => $max_bano,
            'max_bano_time' => $max_bano_time,
            'status_tiu' => $status_tiu,
            'status_bano' => $status_bano
        ]);
    }
}
