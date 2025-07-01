<?php

namespace App\Controllers;
use CodeIgniter\Controller;

class ManualTMAController extends Controller
{
    public function index()
    {
        return view('manual_input');
    }

    public function save()
    {
        $tma   = $this->request->getPost('tma');
        $waktu = $this->request->getPost('waktu');
        $id_telemetri = 10187; // Tiu Suntuk

        if (!$tma || !$waktu) {
            return redirect()->back()->with('error', 'Data tidak lengkap.');
        }

        $db = \Config\Database::connect();

        // Simpan ke data_all_telemetri
        $db->table('data_all_telemetri')->insert([
            'id_telemetri' => $id_telemetri,
            'waktu' => $waktu,
            'tma' => $tma
        ]);

        // Update ke tb_telemetri
        $db->table('tb_telemetri')
           ->where('id', $id_telemetri)
           ->update([
               'waktu' => $waktu,
               'tma' => $tma
           ]);

        return redirect()->to('/manual-tma')->with('success', 'TMA berhasil disimpan.');
    }
}
