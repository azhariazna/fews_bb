<?php

namespace App\Models;
use CodeIgniter\Model;

class TelemetriModel extends Model
{
    protected $table = 'tb_telemetri';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_lokasi', 'waktu', 'tma'];
}
