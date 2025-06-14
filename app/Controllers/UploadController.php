<?php

namespace App\Controllers;
use CodeIgniter\RESTful\ResourceController;

class UploadController extends ResourceController
{
    public function upload()
    {
        $file = $this->request->getFile('file');

        if (!$file || !$file->isValid()) {
            return $this->fail('No file uploaded or file is not valid.', 400);
        }

        // Simpan ke folder public/assets/geojson/
        $newName = $file->getClientName();  // pakai nama asli file
        $targetPath = FCPATH . 'public\assets\geojson';

        if (!is_dir($targetPath)) {
            mkdir($targetPath, 0775, true);  // buat folder kalau belum ada
        }

        $file->move($targetPath, $newName);

        return $this->respond([
            'status' => 'success',
            'message' => 'File uploaded',
            'filename' => $newName
        ]);
    }
}
