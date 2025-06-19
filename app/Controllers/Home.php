<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        header("Access-Control-Allow-Origin: *");

        helper('url'); // ← panggil di sini
        return view('map_view');
    }
    public function getTelemetriGeoJSON()
    {
        $model = new \App\Models\TelemetriModel();
        $data = $model->findAll();

        $features = [];

        foreach ($data as $row) {
            // Pisahkan koordinat jika tidak kosong
            if (!empty($row['koordinat']) && strpos($row['koordinat'], ',') !== false) {
                list($lon, $lat) = explode(',', $row['koordinat']);

                $features[] = [
                    'type' => 'Feature',
                    'geometry' => [
                        'type' => 'Point',
                        'coordinates' => [(float)$lon, (float)$lat]
                    ],
                    'properties' => [
                        'id' => $row['id'],
                        'nama_lokasi' => $row['nama_lokasi'],
                        'waktu' => $row['waktu'],
                        'tma' => $row['tma'],
                        'hujan' => $row['hujan']
                    ]
                ];
            }
        }

        return $this->response->setJSON([
            'type' => 'FeatureCollection',
            'features' => $features
        ]);
    }

    public function grafik($idTelemetri = null)
        {
            header('Access-Control-Allow-Origin: *');
            header('Content-Type: application/json');

            if (!$idTelemetri) {
                return $this->response->setJSON([
                    'status' => 'error',
                    'message' => 'ID Telemetri tidak diberikan.'
                ]);
            }

            $grafikModel = new \App\Models\GrafikModel();
            $data = $grafikModel->getByTelemetriId($idTelemetri);

            return $this->response->setJSON($data);
        }

}
