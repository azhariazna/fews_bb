<?php

namespace App\Controllers;

class Admin extends BaseController
{
    public function index()
    {
        // tampilkan loading screen HTML dulu
        return view('admin/home_loader');
    }

    public function data()
    {
        // Simulasi mulai proses API: waktu ambil dimulai
        $start = microtime(true);

        // Semua API Logger
        $urlList = [
            // 'logger1' => 'https://bintangbano.monitoring4system.com/api/dataterakhir?idlogger=10078&kategori=arr',
            'logger2' => 'https://bintangbano.monitoring4system.com/api/dataterakhir?idlogger=10077&kategori=t_klimatologi',
            'logger3' => 'https://bintangbano.monitoring4system.com/api/dataterakhir?idlogger=10080&kategori=awlr',
            'logger4' => 'https://bintangbano.monitoring4system.com/api/dataterakhir?idlogger=10079&kategori=v_notch',
        ];

        $authLogger = [
            'logger5' => 'https://tiusuntuk.monitoring4system.com/api/data_last?id_logger=10187',
            'logger6' => 'https://tiusuntuk.monitoring4system.com/api/data_last?id_logger=10217',
            'logger7' => 'https://tiusuntuk.monitoring4system.com/api/data_last?id_logger=10246',
            'logger8' => 'https://tiusuntuk.monitoring4system.com/api/data_last?id_logger=10244',
        ];

        // Load tanpa auth
        foreach ($urlList as $key => $url) {
            $data[$key] = json_decode(file_get_contents($url), true);
        }

        // Load dengan Basic Auth
        $context = stream_context_create([
            "http" => [
                "header" => "Authorization: Basic " . base64_encode("user_tiusuntuk:admin_tiusuntuk")
            ]
        ]);
        foreach ($authLogger as $key => $url) {
            $data[$key] = json_decode(file_get_contents($url, false, $context), true);
        }

        // Tambahkan: Ambil data AWLR Sungai (MataiYANG, Sampir, Menemeng) dari database
        $db = \Config\Database::connect();
        $awlrSungaiList = $db->table('tb_telemetri')
            ->whereIn('nama_lokasi', [
                'AWLR MATAIYANG',
                'AWLR SAMPIR',
                'AWLR MENEMENG'
            ])
            ->get()
            ->getResultArray();

        $data['awlrSungaiList'] = $awlrSungaiList;

        // Jangan overwrite $context jika sudah ada!
        // Hapus pembuatan ulang $context di bawah ini:
        // $context = stream_context_create([
        //     "http" => [
        //         "header" => "Authorization: Basic " . base64_encode("user_tiusuntuk:admin_tiusuntuk")
        //     ]
        // ]);

        // ...lanjutkan kode pengambilan AVW sensor...
        $avwSensors = [
            'FP1','FP2','FP3','FP4','EPC4','EPC5','EPC6',
            'EP1','EP2','EP3','EP4','EP5','EP6','EP7',
            'FP5','FP6','FP7','FP8','EPC1','EPC2','EPC3',
            'EP9','EP10','EP11','EP12','EP13','EP14','EP15','EP16','EP17','EP18','EP19','EP8','EP20'
        ];
        $avwSensors = array_unique($avwSensors);

        $avwData = [];
        $avwBaseUrl = 'https://tiusuntuk.monitoring4system.com/api/avw_new?id_logger=10245&id_avw=';

        foreach ($avwSensors as $sensor) {
            $url = $avwBaseUrl . urlencode($sensor);
            $json = @file_get_contents($url, false, $context);
            $parsed = json_decode($json, true);

            $avwData[$sensor] = [];
            if (isset($parsed['data'][0])) {
                $dataAvw = $parsed['data'][0];
                $params = [];
                if (isset($dataAvw['data']) && is_array($dataAvw['data'])) {
                    foreach ($dataAvw['data'] as $param) {
                        $params[] = isset($param['nilai']) ? $param['nilai'] : null;
                    }
                }
                $avwData[$sensor] = $params;
                if (isset($dataAvw['waktu'])) {
                    $avwData[$sensor . '_waktu'] = $dataAvw['waktu'];
                }
            }
        }
        $data['avwData'] = $avwData;

        // Opsional: pastikan waktu render minimal 1.5 detik
        $elapsed = microtime(true) - $start;
        if ($elapsed < 1.5) {
            usleep((1.5 - $elapsed) * 1_000_000); // delay agar animasi sempat muncul
        }

        return view('admin/home', $data); // kirim semua data ke view
    
    }
}
