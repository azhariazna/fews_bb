<?php

namespace App\Controllers;
use App\Models\TmaModel;

class Home extends BaseController
{
    public function index(): string
{
    helper('url');

    $model = new TmaModel();
    $tmabano   = $model->getLatestTMAByLocation('AWLR BENDUNGAN BINTANG BANO');
    $tmaSuntuk   = $model->getLatestTMAByLocation('AWLR BENDUNGAN TIU SUNTUK');
    $tmaSampir   = $model->getLatestTMAByLocation('AWLR SAMPIR');
    $tmaMenemeng = $model->getLatestTMAByLocation('AWLR MENEMENG');

    // Default kosong jika cuaca gagal diambil
    $cuacaArray = [];

    // Ambil cuaca dari API BMKG dengan try-catch + file_get_contents aman
    try {
        $context = stream_context_create([
            'http' => [
                'timeout' => 5 // Timeout maksimal 5 detik
            ]
        ]);

        $response = @file_get_contents("https://api.bmkg.go.id/publik/prakiraan-cuaca?adm4=52.07.07.2002", false, $context);

        if ($response !== false) {
            $json = json_decode($response, true);
            $cuacaArray = $json['data'][0]['cuaca'] ?? [];
        } else {
            log_message('error', 'Gagal mengambil data dari API BMKG (network unreachable)');
        }
    } catch (\Throwable $e) {
        log_message('error', 'Exception saat ambil API BMKG: ' . $e->getMessage());
    }

    $data = [
        'tmaData' => [
            'jam_bano' => $tmabano['waktu'] ?? 0,
            'jam_suntuk' => $tmaSuntuk['waktu'] ?? 0,
            'jam_sampir' => $tmaSampir['waktu'] ?? 0,
            'jam_menemeng' => $tmaMenemeng['waktu'] ?? 0,
            'bano' => $tmabano['tma'] ?? 0,
            'suntuk' => $tmaSuntuk['tma'] ?? 0,
            'sampir' => $tmaSampir['tma'] ?? 0,
            'menemeng' => $tmaMenemeng['tma'] ?? 0
        ],
        'cuacaList' => $cuacaArray
    ];

    return view('map_view', $data);
}


    
    public function getTelemetriGeoJSON()
    {
        $model = new \App\Models\TelemetriModel();
        
        // Ambil hanya yang status = 'aktif'
        $data = $model->where('status', 'aktif')->findAll();

        $features = [];

        foreach ($data as $row) {
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

        $db = \Config\Database::connect();

        $query = $db->query("
            SELECT 
                g.id_telemetri,
                g.jam,
                g.debit AS debit_prediksi,
                d.tma AS tma_aktual,
                g.update_at
            FROM grafik g
            LEFT JOIN data_all_telemetri d
                ON g.id_telemetri = d.id_telemetri
                AND DATE(g.update_at) = DATE(d.waktu)
                AND HOUR(g.update_at) = HOUR(d.waktu)
            WHERE g.id_telemetri = ?
            ORDER BY g.update_at
        ", [$idTelemetri]);

        $data = $query->getResultArray();

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data
        ]);
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
