<?php

namespace App\Controllers;

use App\Models\TmaModel;
use App\Models\TelemetriModel;

class ManualTMAController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }

        $tmaModel = new TmaModel();
        $telemetriModel = new \App\Models\TelemetriModel();

        // 🔹 Ambil semua lokasi dari tb_telemetri (tanpa filter status)
        $bendunganList = $telemetriModel
            ->like('nama_lokasi', 'AWLR')
            ->findAll();

        if (empty($bendunganList)) {
            return view('manual_input', [
                'tma' => '',
                'waktu' => '',
                'id' => null,
                'bendungan' => 'Tidak ditemukan',
                'daftar_bendungan' => []
            ]);
        }

        // 🔹 ID dari query ?id=... atau default ke ID pertama
        $id = $this->request->getGet('id') ?? $bendunganList[0]['id'];

        $data_terakhir = $tmaModel->where('id', $id)->orderBy('waktu', 'DESC')->first();
        $bendungan_nama = $telemetriModel->find($id)['nama_lokasi'] ?? 'Tidak diketahui';

        return view('manual_input', [
            'tma' => $data_terakhir['tma'] ?? '',
            'waktu' => $data_terakhir['waktu'] ?? '',
            'id' => $id,
            'bendungan' => $bendungan_nama,
            'daftar_bendungan' => $bendunganList
        ]);
    }

    public function update($id)
    {
        $model = new TmaModel();

        $waktuInput = $this->request->getPost('waktu');
        $tma = $this->request->getPost('tma');

        $datetime = \DateTime::createFromFormat('Y-m-d\TH:i', $waktuInput);
        $waktu = $datetime ? $datetime->format('Y-m-d H:i:s') : null;

        $data = [
            'waktu' => $waktu,
            'tma' => $tma
        ];

        if ($model->update($id, $data)) {
            $db = \Config\Database::connect();

            $exists = $db->query("SELECT * FROM data_all_telemetri WHERE id_telemetri = ? AND waktu = ?", [$id, $waktu])->getRow();

            if (!$exists) {
                $db->table('data_all_telemetri')->insert([
                    'id_telemetri' => $id,
                    'waktu' => $waktu,
                    'tma' => $tma
                ]);
            }

            return redirect()->to(base_url('/manual-tma?id=' . $id))->with('success', 'TMA berhasil diupdate.');
        } else {
            return redirect()->back()->with('error', 'Gagal memperbarui data.');
        }
    }
}
