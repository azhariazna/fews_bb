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
public function bulkUpdate()
{
    $request = service('request');
    $model = new \App\Models\DataModel();
    $dataList = $request->getJSON();

    $successCount = 0;
    $failCount = 0;
    $results = [];

    foreach ($dataList as $dataInput) {
        $id = isset($dataInput->id) ? (int)$dataInput->id : null;
        $jam = isset($dataInput->jam) ? (int)$dataInput->jam : null;
        $debit = isset($dataInput->debit) ? (int)$dataInput->debit : null;
        $lastupdate = $dataInput->update_at ?? null;
        $id_telemetri = isset($dataInput->id_telemetri)
            ? $dataInput->id_telemetri
            : ceil($id / 48);

        if ($id === null || $jam === null || $debit === null || $lastupdate === null) {
            $failCount++;
            $results[] = ['id' => $id, 'status' => 'invalid'];
            continue;
        }

        $dataUpdate = [
            'jam' => $jam,
            'debit' => $debit,
            'id_telemetri' => $id_telemetri,
            'update_at' => $lastupdate
        ];

        if ($id === 1) {
            log_message('debug', 'DEBUG ID 1: ' . json_encode($dataUpdate));
        }

        if ($model->update($id, $dataUpdate)) {
            $successCount++;
            $results[] = ['id' => $id, 'status' => 'updated'];
        } else {
            $failCount++;
            $results[] = ['id' => $id, 'status' => 'failed'];
        }
    }

    return $this->response->setJSON([
        'status' => true,
        'updated' => $successCount,
        'failed' => $failCount,
        'details' => $results
    ]);
}









}
