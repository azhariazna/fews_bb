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

        $model = new TelemetriModel();
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

                // Ambil waktu UTC tanpa menggeser ke zona waktu lokal
                $createdAtUTC = $json['data'][0]['created_at'];
                $tma = $json['data'][0]['data'][0]['value'];

                // Format waktu agar sesuai format MySQL (tanpa timezone)
                $datetime = date('Y-m-d H:i:s', strtotime($createdAtUTC));

                // Update ke database
                $model->where('nama_lokasi', $nama_lokasi)
                      ->set(['waktu' => $datetime, 'tma' => $tma])
                      ->update();

                $results[] = [
                    'nama_lokasi' => $nama_lokasi,
                    'tma' => $tma,
                    'waktu' => $datetime, // masih dalam UTC
                ];
            }
        }

        return $this->response->setJSON([
            'status' => 'updated',
            'updated_data' => $results
        ]);
    }
}
