<?php

namespace App\Controllers;

class Data_api extends BaseController
{
    protected $client;

    public function __construct()
    {
        $this->client = \Config\Services::curlrequest();
    }

    public function index()
    {
        $id_logger = $this->request->getGet('id_logger');
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');

        $dataSensor = [];
        $headers = [];
        $error = '';

        if ($id_logger && $start && $end) {
            // Validasi range maksimal 1 bulan
            $startDate = new \DateTime($start);
            $endDate = new \DateTime($end);
            $interval = $startDate->diff($endDate)->days;

            if ($interval > 31) {
                $error = 'Range tanggal tidak boleh lebih dari 1 bulan.';
            } else {
                $apiUrl = "https://tiusuntuk.monitoring4system.com/api/data_range?id_logger={$id_logger}&tgl_awal={$start}&tgl_akhir={$end}";

                try {
                    $response = $this->client->get($apiUrl, [
                        'auth' => ['user_tiusuntuk', 'admin_tiusuntuk']
                    ]);

                    $json = json_decode($response->getBody(), true);

                    if (isset($json['status']) && $json['status'] === true) {
                        $dataSensor = $json['data'] ?? [];

                        // Ambil headers unik dari parameter pertama
                        foreach ($dataSensor as $entry) {
                            if (isset($entry['data'])) {
                                foreach ($entry['data'] as $param) {
                                    $headers[] = $param['nama_parameter'];
                                }
                            }
                            break;
                        }

                        $headers = array_unique($headers); // hindari duplikat
                    } else {
                        $error = $json['message'] ?? 'Gagal mengambil data dari API.';
                    }
                } catch (\Exception $e) {
                    $error = 'Gagal mengambil data dari API.';
                }
            }
        }

        return view('admin/data_range_view', [
            'id_logger' => $id_logger,
            'start' => $start,
            'end' => $end,
            'dataSensor' => $dataSensor,
            'headers' => $headers,
            'error' => $error
        ]);
    }
}
