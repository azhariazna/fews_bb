<?php

namespace App\Controllers;
use App\Models\AwlrModel;
use App\Models\TelemetriModel;

class AwlrController extends BaseController
{
    public function index()
    {
        $telemetriModel = new TelemetriModel();
        $awlrList = $telemetriModel->where('nama_lokasi LIKE', 'AWLR%')->findAll();

        $id_awlr = $this->request->getGet('id_awlr');
        $start = $this->request->getGet('start');
        $end = $this->request->getGet('end');

        $dataModel = new AwlrModel();
        $data = [];

        if ($id_awlr && $start && $end) {
            $data = $dataModel
                ->where('id_telemetri', $id_awlr)
                ->where('waktu >=', $start)
                ->where('waktu <=', $end)
                ->orderBy('waktu', 'ASC')
                ->findAll();
        }

        return view('admin/data_awlr', [
            'awlrList' => $awlrList,
            'data' => $data,
            'id_awlr' => $id_awlr,
            'start' => $start,
            'end' => $end
        ]);
    }
}
