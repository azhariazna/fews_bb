<?php
namespace App\Controllers;

use App\Models\TmaModel;

class ManualTMAController extends BaseController
{
    public function index()
    {
        if (!session()->get('logged_in')) {
            return redirect()->to(base_url('login'));
        }
        
        $model = new TmaModel();

        // Ambil 1 data terakhir khusus AWLR BENDUNGAN TIU SUNTUK (id = 10187)
        $data_terakhir = $model->where('id', 10187)->orderBy('waktu', 'DESC')->first();

        return view('manual_input', [
            'tma' => $data_terakhir['tma'] ?? '',
            'waktu' => $data_terakhir['waktu'] ?? '',
            'id' => $data_terakhir['id'] ?? null
        ]);
    }

public function update($id)
{
    $model = new TmaModel();

    // Ambil input
    $waktuInput = $this->request->getPost('waktu');
    $tma = $this->request->getPost('tma');

    // Format waktu ke Y-m-d H:i:s
    $datetime = \DateTime::createFromFormat('Y-m-d\TH:i', $waktuInput);
    $waktu = $datetime ? $datetime->format('Y-m-d H:i:s') : null;

    $data = [
        'waktu' => $waktu,
        'tma' => $tma
    ];

    if ($model->update($id, $data)) {
        $db = \Config\Database::connect();

        // Cek apakah waktu + id_telemetri sudah ada
        $exists = $db->query("SELECT * FROM data_all_telemetri WHERE id_telemetri = ? AND waktu = ?", [$id, $waktu])->getRow();

        if (!$exists) {
            $db->table('data_all_telemetri')->insert([
                'id_telemetri' => $id,
                'waktu' => $waktu,
                'tma' => $tma
            ]);
        }

        return redirect()->to(base_url('/manual-tma'))->with('success', 'TMA berhasil diupdate.');
    } else {
        return redirect()->back()->with('error', 'Gagal memperbarui data.');
    }
}




}
