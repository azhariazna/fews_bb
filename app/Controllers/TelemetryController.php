<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\TelemetryModel;

class TelemetryController extends Controller
{
    public function fetchAndStore()
    {
        helper('url');

        $id_telemetri = 10080;
        $url = "https://bintangbano.monitoring4system.com/api/dataterakhir?idlogger=$id_telemetri&kategori=awlr";
        $json = file_get_contents($url);

        if (!$json) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'API tidak bisa diakses']);
        }

        $data = json_decode($json, true);

        if (!isset($data['waktu']) || !isset($data['data_terakhir'])) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'Format JSON tidak valid']);
        }

        $waktu = $data['waktu'];
        $tma = null;

        foreach ($data['data_terakhir'] as $sensor) {
            if ($sensor['sensor'] == "Tinggi_Muka_Air") {
                $tma = $sensor['data'];
                break;
            }
        }

        if ($tma === null) {
            return $this->response->setJSON(['status' => 'error', 'message' => 'TMA not found']);
        }

        $model = new TelemetryModel();

        // Cek jika data dengan kombinasi id_telemetri dan waktu sudah ada
        $exists = $model->where('id_telemetri', $id_telemetri)
                        ->where('waktu', $waktu)
                        ->first();

        if (!$exists) {
            $model->save([
                'id_telemetri' => $id_telemetri,
                'waktu' => $waktu,
                'tma' => $tma
            ]);
            return $this->response->setJSON(['status' => 'inserted', 'waktu' => $waktu, 'tma' => $tma]);
        } else {
            return $this->response->setJSON(['status' => 'exists', 'waktu' => $waktu]);
        }
    }

    public function getLatestTMA()
    {
        $model = new TelemetryModel();
        $latest = $model->where('id_telemetri', 10080)
                        ->orderBy('waktu', 'DESC')
                        ->first();

        return $this->response->setJSON($latest);
    }
}
