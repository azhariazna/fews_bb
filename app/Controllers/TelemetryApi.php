<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\ResponseInterface;
use App\Models\TelemetriModel;

class TelemetryApi extends BaseController
{
    public function updateAwlrToDB()
        {
            $deviceMap = [
                'TS1736570018' => ['id_telemetri' => 248002, 'nama_lokasi' => 'AWLR SAMPIR'],
                'TS1736570140' => ['id_telemetri' => 248003, 'nama_lokasi' => 'AWLR MENEMENG'],
                'TS1736570205' => ['id_telemetri' => 248001, 'nama_lokasi' => 'AWLR MATAIYANG']
            ];

            $db = \Config\Database::connect();
            $results = [];

            foreach ($deviceMap as $deviceCode => $info) {
                $url = "https://tiu-suntuk-services.opshi.net/api/public/last/" . $deviceCode;

                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_USERPWD => 'nanotek:poiuy09876',
                    CURLOPT_HTTPAUTH => CURLAUTH_BASIC,
                ]);

                $response = curl_exec($curl);
                curl_close($curl);

                if ($response) {
                    $json = json_decode($response, true);

                    $createdAtRaw = $json['data'][0]['created_at'];
                    $tma = $json['data'][0]['data'][0]['value'];
                    $datetime = (new \DateTime($createdAtRaw, new \DateTimeZone('UTC')))->format('Y-m-d H:i:s');

                    // --- INSERT ke data_all_telemetri jika belum ada ---
                    $existing = $db->table('data_all_telemetri')
                        ->where('id_telemetri', $info['id_telemetri'])
                        ->where('waktu', $datetime)
                        ->get()
                        ->getRow();

                    if (!$existing) {
                        $db->table('data_all_telemetri')->insert([
                            'id_telemetri' => $info['id_telemetri'],
                            'waktu'        => $datetime,
                            'tma'          => $tma
                        ]);
                    }

                    // --- UPDATE ke tb_telemetri ---
                    $db->table('tb_telemetri')
                        ->where('id', $info['id_telemetri'])
                        ->update([
                            'waktu' => $datetime,
                            'tma'   => $tma
                        ]);

                    $results[] = [
                        'id_telemetri' => $info['id_telemetri'],
                        'nama_lokasi'  => $info['nama_lokasi'],
                        'tma'          => $tma,
                        'waktu'        => $datetime,
                        'status'       => $existing ? 'sudah_ada' : 'ditambahkan'
                    ];
                }
            }

            return $this->response->setJSON([
                'status' => 'berhasil',
                'hasil'  => $results
            ]);
        }




}
