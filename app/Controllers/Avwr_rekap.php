<?php

namespace App\Controllers;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Avwr_rekap extends BaseController
{
    protected $apiUrl = 'https://tiusuntuk.monitoring4system.com/api/rekap_sta';
    protected $apiUser = 'user_tiusuntuk';
    protected $apiPass = 'admin_tiusuntuk';
    protected $session;

    public function __construct()
    {
        $this->session = \Config\Services::session();
    }

    public function index()
    {
        // Debug mode - output raw JSON
        if ($this->request->getGet('debug') === 'json') {
            $sensorData = $this->getSensorData();
            if ($sensorData === null) {
                return $this->response->setJSON([
                    'error' => 'Failed to fetch data',
                    'request' => [
                        'sta' => $this->request->getGet('sta'),
                        'start_date' => $this->request->getGet('start_date'),
                        'end_date' => $this->request->getGet('end_date'),
                        'url' => $this->apiUrl,
                        'user' => $this->apiUser,
                        'pass' => '********' // Don't expose password in output
                    ]
                ]);
            }
            return $this->response->setJSON($sensorData);
        }

        // Define available stations
        $stations = [
            '100' => '+100',
            '180' => '+180',
            // Add more stations as needed
        ];


        $intervals = [
            'jam' => 'Jam',
            'hari' => 'Hari',
        ];

        $data = [
            'title' => 'AVWR Rekap Data',
            'sensorData' => null,
            'stations' => $stations,
            'intervals' => $intervals,
            'sta' => null,
            'interval' => null,
            'start_date' => null,
            'end_date' => null
        ];


        // Handle form submission (POST request)
        if ($this->request->getMethod() === 'post') {
            $validation = \Config\Services::validation();
            $validation->setRules([
                'sta' => 'required',
                'interval' => 'required|in_list[jam,hari]',
                'start_date' => 'required|valid_date',
                'end_date' => 'required|valid_date'
            ]);

            if ($validation->withRequest($this->request)->run()) {
                // Store the form data in the session
                $session = session();
                $formData = [
                    'sta' => $this->request->getPost('sta'),
                    'interval' => $this->request->getPost('interval'),
                    'start_date' => $this->request->getPost('start_date'),
                    'end_date' => $this->request->getPost('end_date')
                ];
                $session->setFlashdata('form_data', $formData);
                // Redirect to the same page with GET parameters
                return redirect()->to(site_url('avwr-rekap') . '?' . http_build_query($formData));
            } else {
                // If validation fails, show errors
                $data['validation'] = $validation;
            }
        }

        // Check for GET parameters or form data in flashdata

        $sta = $this->request->getGet('sta');
        $interval = $this->request->getGet('interval');
        $start_date = $this->request->getGet('start_date');
        $end_date = $this->request->getGet('end_date');

        // If no GET parameters but we have flashdata, use that
        if ((!$sta || !$interval) && $this->session->has('form_data')) {
            $formData = $this->session->getFlashdata('form_data');
            $sta = $formData['sta'] ?? null;
            $interval = $formData['interval'] ?? null;
            $start_date = $formData['start_date'] ?? null;
            $end_date = $formData['end_date'] ?? null;
        }

        // Set the form values in data array
        $data['sta'] = $sta;
        $data['interval'] = $interval;
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        if ($sta && $interval && $start_date && $end_date) {
            $sensorData = $this->getSensorData();
            if ($sensorData === null) {
                $errorMessage = 'Gagal mengambil data dari API';
                // Add debug info in development
                if (ENVIRONMENT !== 'production') {
                    $debugInfo = [
                        'request' => [
                            'sta' => $this->request->getGet('sta'),
                            'interval' => $this->request->getGet('interval'),
                            'start_date' => $this->request->getGet('start_date'),
                            'end_date' => $this->request->getGet('end_date'),
                            'url' => $this->apiUrl,
                        ],
                        'error' => error_get_last()
                    ];
                    session()->setFlashdata('debug', print_r($debugInfo, true));
                }
                session()->setFlashdata('error', $errorMessage);
            } else {
                $data['sensorData'] = $sensorData;
            }
        }

        return view('admin/avwr_rekap', $data);
    }

    private function getSensorData()
    {
        // Get parameters from either GET or POST
        $sta = $this->request->getGet('sta') ?? $this->request->getPost('sta');
        $interval = $this->request->getGet('interval') ?? $this->request->getPost('interval');
        $startDate = $this->request->getGet('start_date') ?? $this->request->getPost('start_date');
        $endDate = $this->request->getGet('end_date') ?? $this->request->getPost('end_date');
        
        // If we have form data in flashdata, use that
        if ($this->session->has('form_data')) {
            $formData = $this->session->getFlashdata('form_data');
            $sta = $formData['sta'];
            $startDate = $formData['start_date'];
            $endDate = $formData['end_date'];
        }
    
        // Pastikan parameter yang dibutuhkan ada
        if (empty($sta) || empty($startDate) || empty($endDate)) {
            log_message('error', 'Missing required parameters');
            return null;
        }
    
        $url = "{$this->apiUrl}?sta={$sta}&awal={$startDate}&akhir={$endDate}&interval={$interval}";
        
        // Log URL yang akan di-request
        log_message('debug', 'API Request URL: ' . $url);
        
        $client = \Config\Services::curlrequest();
        
        try {
            $response = $client->get($url, [
                'auth' => [$this->apiUser, $this->apiPass],
                'http_errors' => false,
                'timeout' => 30,
                'connect_timeout' => 10,
                'verify' => false  // Nonaktifkan verifikasi SSL untuk testing
            ]);
            
            $statusCode = $response->getStatusCode();
            $body = (string) $response->getBody();
            
            log_message('debug', 'API Response Status: ' . $statusCode);
            log_message('debug', 'API Response: ' . $body);
            
            if ($statusCode !== 200) {
                log_message('error', 'API Error Status: ' . $statusCode . ' - ' . $body);
                return null;
            }
            
            // Coba decode JSON
            $data = json_decode($body, true);
            
            if (json_last_error() !== JSON_ERROR_NONE) {
                log_message('error', 'JSON Decode Error: ' . json_last_error_msg());
                return null;
            }
            
            // Debug: Tampilkan struktur data yang diterima
            log_message('debug', 'Data structure: ' . print_r($data, true));
            
            // Cek format data yang diterima
            if (isset($data['data_avw'])) {
                return $data['data_avw'];
            } elseif (isset($data['data'])) {
                return $data['data'];
            } elseif (is_array($data)) {
                return $data;
            }
            
            log_message('error', 'Unexpected data format: ' . print_r($data, true));
            return null;
            
        } catch (\Exception $e) {
            log_message('error', 'API Request Exception: ' . $e->getMessage());
            return null;
        }
    }

    public function export()
    {
        $data = $this->getSensorData();
        if (!$data) {
            return redirect()->back()->with('error', 'Failed to fetch data');
        }

        // Siapkan header CSV
        $filename = "rekap_avwr_STA{$this->request->getGet('sta')}_{$this->request->getGet('start_date')}_to_{$this->request->getGet('end_date')}.csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $output = fopen('php://output', 'w');

        // Cek struktur data (nested atau flat)
        $firstItem = reset($data);
        $isNested = (is_array($firstItem) && isset($firstItem['data']));

        // Ambil semua kolom unik
        $columns = [];
        foreach ($data as $item) {
            $rowData = $isNested ? ($item['data'] ?? []) : $item;
            $columns = array_merge($columns, array_keys($rowData));
        }
        $columns = array_unique($columns);
        $columns = array_diff($columns, ['id', 'id_sta']);
        sort($columns);

        // Header CSV
        $headerRow = array_merge(['Waktu'], $columns);
        fputcsv($output, $headerRow);

        // Data CSV
        foreach ($data as $item) {
            $rowData = $isNested ? ($item['data'] ?? []) : $item;
            $waktu = $rowData['waktu'] ?? ($item['waktu'] ?? 'N/A');
            unset($rowData['waktu']);
            $row = [$waktu];
            foreach ($columns as $col) {
                $row[] = $rowData[$col] ?? '';
            }
            fputcsv($output, $row);
        }

        fclose($output);
        exit();
    }

    private function getUnit($param)
    {
        if (strpos($param, 'Frekuensi') !== false) return 'Hz';
        if (strpos($param, 'P_kPa') !== false) return 'kPa';
        if (strpos($param, 'P_mH2O') !== false) return 'mH2O';
        if (strpos($param, 'Temperature') !== false) return '°C';
        return '';
    }
}