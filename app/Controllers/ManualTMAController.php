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

    $data = [
        'waktu' => $this->request->getPost('waktu'),
        'tma'   => $this->request->getPost('tma')
    ];

    if ($model->update($id, $data)) {
        return redirect()->to(base_url('/manual-tma'))->with('success', 'TMA berhasil diupdate.');
    } else {
        return redirect()->back()->with('error', 'Gagal memperbarui data.');
    }
}

}
