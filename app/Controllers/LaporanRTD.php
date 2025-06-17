<?php

namespace App\Controllers;

use PhpOffice\PhpWord\TemplateProcessor;
use App\Models\LaporanModel;

class LaporanRTD extends BaseController
{
    public function index()
    {
        if (!session()->has('username')) {
            return redirect()->to(base_url('login'));
        }
        return view('laporan_form');
    }

    public function submit()
    {
        $data = $this->request->getPost();
        $tgl = str_replace(['/', '\\', ':'], '-', $data['tgl_surat']);
        $namaFile = $tgl . ' Laporan_Keadaan_Darurat.docx';
        $filePath = FCPATH . "assets/docx/" . $namaFile;

        // Hapus file lama jika ada
        if (file_exists($filePath)) {
            unlink($filePath); // hapus file lama
        }

        // === Proses Template Word ===
        $template = new TemplateProcessor(FCPATH . 'template.docx');
        $template->setValue('jam', $data['jam']);
        $template->setValue('tanggal', $data['tanggal']);
        $template->setValue('status', $data['status']);
        $template->setValue('elevasi', $data['elevasi']);
        $template->setValue('elevasi_normal', $data['elevasi_normal']);
        $template->setValue('puncak_bendungan', $data['puncak_bendungan']);
        $template->setValue('debit', $data['debit']);
        $template->setValue('debit_hilir', $data['debit_hilir']);
        $template->setValue('tgl_surat', $data['tgl_surat']);

        for ($i = 1; $i <= 5; $i++) {
            $template->setValue("kampung{$i}", $data["kampung{$i}"] ?? '');
            $template->setValue("desa{$i}", $data["desa{$i}"] ?? '');
            $template->setValue("kecamatan{$i}", $data["kecamatan{$i}"] ?? '');
        }

        // Simpan file baru
        $template->saveAs($filePath);

        // === Simpan ke database ===
        $model = new LaporanModel();
        $existing = $model->where('nama_file', $namaFile)->first();

        if ($existing) {
            $model->update($existing['id'], ['nama_file' => $namaFile]);
        } else {
            $model->insert(['nama_file' => $namaFile]);
        }

        return view('laporan_sukses', [
            'docx_url' => base_url("assets/docx/$namaFile")
        ]);
    }


    public function download()
    {
        if (!session()->has('username')) {
            return redirect()->to(base_url('login'));
        }
        $model = new LaporanModel();
        $data['laporanList'] = $model->orderBy('id', 'DESC')->findAll();
        return view('download_rtd', $data);
    }
}
