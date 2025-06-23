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
                'TS1736570018' => 'AWLR SAMPIR',
                'TS1736570140' => 'AWLR MENEMENG',
                'TS1736570205' => 'AWLR MATAIYANG'
            ];

            $model = new \App\Models\TelemetriModel();
            $results = [];

            foreach ($deviceMap as $deviceCode => $nama_lokasi) {
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

                    $createdAtRaw = $json['data'][0]['created_at'];  // misal: "2025-06-23T03:00:00.000Z"
                    $tma = $json['data'][0]['data'][0]['value'];

                    // Ambil datetime langsung tanpa mengubah zona waktu
                    $datetime = (new \DateTime($createdAtRaw, new \DateTimeZone('UTC')))
                        ->format('Y-m-d H:i:s');


                    $model->where('nama_lokasi', $nama_lokasi)
                        ->set(['waktu' => $datetime, 'tma' => $tma])
                        ->update();

                    $results[] = [
                        'nama_lokasi' => $nama_lokasi,
                        'tma' => $tma,
                        'waktu' => $datetime,
                    ];
                }
            }

            return $this->response->setJSON([
                'status' => 'updated',
                'updated_data' => $results
            ]);
        }


}
