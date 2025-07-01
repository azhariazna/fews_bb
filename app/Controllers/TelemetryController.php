<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\TelemetryModel;

class TelemetryController extends Controller
{
    public function fetchAndStore()
    {
        helper('url');

        $results = [];
        $model = new TelemetryModel();
        $db = \Config\Database::connect();

        // ===============================
        // === API 1: Bintang Bano ===
        // ===============================
        $id_telemetri_1 = 10080;
        $url_1 = "https://bintangbano.monitoring4system.com/api/dataterakhir?idlogger=$id_telemetri_1&kategori=awlr";

        $json_1 = file_get_contents($url_1);
        if ($json_1) {
            $data = json_decode($json_1, true);
            if (isset($data['waktu'], $data['data_terakhir'])) {
                $waktu = $data['waktu'];
                $tma = null;

                foreach ($data['data_terakhir'] as $sensor) {
                    if ($sensor['sensor'] === "Tinggi_Muka_Air") {
                        $tma = $sensor['data'];
                        break;
                    }
                }

                if ($tma !== null) {
                    $exists = $model->where('id_telemetri', $id_telemetri_1)
                                    ->where('waktu', $waktu)
                                    ->first();

                    if (!$exists) {
                        $model->save([
                            'id_telemetri' => $id_telemetri_1,
                            'waktu' => $waktu,
                            'tma' => $tma
                        ]);

                        // Update tb_telemetri
                        $db->table('tb_telemetri')
                           ->where('id', $id_telemetri_1)
                           ->update(['waktu' => $waktu, 'tma' => $tma]);

                        $results[] = [
                            'id_telemetri' => $id_telemetri_1,
                            'status' => 'inserted',
                            'waktu' => $waktu,
                            'tma' => $tma
                        ];
                    } else {
                        $results[] = [
                            'id_telemetri' => $id_telemetri_1,
                            'status' => 'exists',
                            'waktu' => $waktu
                        ];
                    }
                } else {
                    $results[] = [
                        'id_telemetri' => $id_telemetri_1,
                        'status' => 'error',
                        'message' => 'TMA not found'
                    ];
                }
            } else {
                $results[] = [
                    'id_telemetri' => $id_telemetri_1,
                    'status' => 'error',
                    'message' => 'Format JSON tidak valid'
                ];
            }
        } else {
            $results[] = [
                'id_telemetri' => $id_telemetri_1,
                'status' => 'error',
                'message' => 'API Bintang Bano tidak bisa diakses'
            ];
        }

        // ===============================
        // === API 2: Tiu Suntuk (Auth) ===
        // ===============================
        $id_telemetri_2 = 10187;
        $url_2 = "https://tiusuntuk.monitoring4system.com/api/data_last?id_logger=$id_telemetri_2";

        $options = [
            "http" => [
                "header" => "Authorization: Basic " . base64_encode("user_tiusuntuk:admin_tiusuntuk")
            ]
        ];
        $context = stream_context_create($options);
        $json_2 = file_get_contents($url_2, false, $context);

        if ($json_2) {
            $data = json_decode($json_2, true);

            if (isset($data['data']['waktu'], $data['data']['data'])) {
                $waktu = $data['data']['waktu'];
                $tma = null;

                foreach ($data['data']['data'] as $item) {
                    if ($item['nama_parameter'] === "Tinggi_Muka_Air") {
                        $tma = $item['nilai'];
                        break;
                    }
                }

                if ($tma !== null) {
                    $exists = $model->where('id_telemetri', $id_telemetri_2)
                                    ->where('waktu', $waktu)
                                    ->first();

                    if (!$exists) {
                        $model->save([
                            'id_telemetri' => $id_telemetri_2,
                            'waktu' => $waktu,
                            'tma' => $tma
                        ]);

                        // Update tb_telemetri
                        $db->table('tb_telemetri')
                           ->where('id', $id_telemetri_2)
                           ->update(['waktu' => $waktu, 'tma' => $tma]);

                        $results[] = [
                            'id_telemetri' => $id_telemetri_2,
                            'status' => 'inserted',
                            'waktu' => $waktu,
                            'tma' => $tma
                        ];
                    } else {
                        $results[] = [
                            'id_telemetri' => $id_telemetri_2,
                            'status' => 'exists',
                            'waktu' => $waktu
                        ];
                    }
                } else {
                    $results[] = [
                        'id_telemetri' => $id_telemetri_2,
                        'status' => 'error',
                        'message' => 'TMA not found'
                    ];
                }
            } else {
                $results[] = [
                    'id_telemetri' => $id_telemetri_2,
                    'status' => 'error',
                    'message' => 'Format JSON tidak valid (Tiu Suntuk)'
                ];
            }
        } else {
            $results[] = [
                'id_telemetri' => $id_telemetri_2,
                'status' => 'error',
                'message' => 'API Tiu Suntuk tidak bisa diakses'
            ];
        }

        // === Kembalikan response JSON
        return $this->response->setJSON($results);
    }

    public function getBintangBano()
        {
            $db = \Config\Database::connect();
            $data = $db->table('tb_telemetri')
                    ->where('id', 10080)
                    ->select('waktu, tma')
                    ->get()
                    ->getRowArray();

            return $this->response->setJSON($data);
        }

    public function getTiuSuntuk()
        {
            $db = \Config\Database::connect();
            $data = $db->table('tb_telemetri')
                    ->where('id', 10187)
                    ->select('waktu, tma')
                    ->get()
                    ->getRowArray();

            return $this->response->setJSON($data);
        }

}
