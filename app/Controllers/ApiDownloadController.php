<?php

namespace App\Controllers;

class ApiDownloadController extends BaseController
{
    public function index()
    {
        helper(['form', 'url']);
        $sensorList = [
            'FP1', 'FP2', 'FP3', 'FP4', 'FP5', 'FP6', 'FP7', 'FP8',
            'EPC1', 'EPC2', 'EPC3', 'EPC4', 'EPC5', 'EPC6',
            'EP1', 'EP2', 'EP3', 'EP4', 'EP5', 'EP6', 'EP7',
            'EP8', 'EP9', 'EP10', 'EP11', 'EP12', 'EP13', 'EP14', 'EP15',
            'EP16', 'EP17', 'EP18', 'EP19', 'EP20'
        ];

        $data = [
            'sensorList' => $sensorList,
            'selectedSensor' => null,
            'selectedDate' => null,
            'records' => [],
            'parameters' => [],
            'error' => null,
            'isPost' => false
        ];

        if ($this->request->getMethod() === 'post') {
            $data['isPost'] = true;
            $sensor = $this->request->getPost('sensor');
            $tanggal = $this->request->getPost('tanggal');

            // Simpan pilihan agar tetap terisi setelah submit
            $data['selectedSensor'] = $sensor;
            $data['selectedDate'] = $tanggal;

            if (!$sensor || !$tanggal) {
                $data['error'] = 'Sensor dan tanggal wajib diisi.';
            } else {
                $formattedDate = date('Y-m-d', strtotime($tanggal));
                $url = "https://tiusuntuk.monitoring4system.com/api/data_avw?id_logger=10245&id_avw={$sensor}&tanggal={$formattedDate}";

                $auth = base64_encode("user_tiusuntuk:admin_tiusuntuk");
                $options = [
                    "http" => [
                        "header" => "Authorization: Basic $auth"
                    ]
                ];
                $context = stream_context_create($options);

                $response = @file_get_contents($url, false, $context);
                // Debug: log response ke file log untuk pengecekan
                // log_message('debug', 'API Response: ' . $response);

                if ($response === false) {
                    $data['error'] = 'Gagal mengambil data dari API.';
                    $data['records'] = [];
                    $data['parameters'] = [];
                } else {
                    // Debug: kirim response ke view untuk console.log
                    $data['apiRaw'] = $response;

                    $json = json_decode($response, true);
                    if (!isset($json['data']) || !is_array($json['data']) || count($json['data']) === 0) {
                        $data['error'] = null;
                        $data['records'] = [];
                        $data['parameters'] = [];
                    } else {
                        $records = [];
                        $parameters = [];
                        foreach ($json['data'] as $entry) {
                            $row = ['waktu' => $entry['waktu']];
                            if (isset($entry['data']) && is_array($entry['data'])) {
                                foreach ($entry['data'] as $param) {
                                    $row[$param['nama_parameter']] = $param['nilai'];
                                    $parameters[$param['nama_parameter']] = true;
                                }
                            }
                            $records[] = $row;
                        }
                        $data['records'] = $records;
                        $data['parameters'] = array_keys($parameters);
                        $data['error'] = null;
                    }
                }
            }
        }

        return view('admin/avw_view', $data);
    }
}
