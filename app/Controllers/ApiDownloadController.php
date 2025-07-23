<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class ApiDownloadController extends Controller
{
   public function index()
{
    helper(['form', 'url']);

    $sensors = [
        'FP1', 'FP2', 'FP3', 'FP4', 'FP5', 'FP6', 'FP7', 'FP8',
        'EPC1', 'EPC2', 'EPC3', 'EPC4', 'EPC5', 'EPC6',
        'EP1', 'EP2', 'EP3', 'EP4', 'EP5', 'EP6', 'EP7', 'EP8',
        'EP9', 'EP10', 'EP11', 'EP12', 'EP13', 'EP14', 'EP15', 'EP16', 'EP17', 'EP18', 'EP19', 'EP20'
    ];

    $selectedSensor = $this->request->getPost('sensor') ?? 'FP1';
    $selectedDate   = $this->request->getPost('tanggal') ?? date('Y-m-d');

    $apiUrl = "https://tiusuntuk.monitoring4system.com/api/data_avw?id_logger=10245&id_avw=$selectedSensor&tanggal=$selectedDate";
    $username = 'user_tiusuntuk';
    $password = 'admin_tiusuntuk';

    $client = \Config\Services::curlrequest();
    $dataList = [];
    $errorMsg = '';

    try {
        $response = $client->request('GET', $apiUrl, [
            'auth' => [$username, $password],
            'timeout' => 10
        ]);

        $result = json_decode($response->getBody(), true);

        if (!isset($result['status']) || $result['status'] !== true || empty($result['data'])) {
            $errorMsg = 'Data tidak tersedia atau kosong untuk sensor dan tanggal yang dipilih.';
        } else {
            $dataList = $result['data'];
        }

    } catch (\Exception $e) {
        $errorMsg = 'Gagal terhubung ke API: ' . $e->getMessage();
    }

    return view('admin/avw_view', [
        'sensors' => $sensors,
        'selectedSensor' => $selectedSensor,
        'selectedDate' => $selectedDate,
        'dataList' => $dataList,
        'errorMsg' => $errorMsg
    ]);
}

}
