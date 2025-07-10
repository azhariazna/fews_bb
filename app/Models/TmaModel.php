<?php

namespace App\Models;
use CodeIgniter\Model;

class TmaModel extends Model
{
    protected $table = 'tb_telemetri';
    protected $allowedFields = ['nama_lokasi', 'tma', 'waktu'];

    public function getLatestTMAByLocation($lokasi)
    {
        return $this->where('nama_lokasi', $lokasi)
                    ->orderBy('waktu', 'DESC')
                    ->first();
    }
}
