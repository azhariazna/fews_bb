<?php

namespace App\Models;
use CodeIgniter\Model;

class TmaModel extends Model
{
    protected $table = 'tb_telemetri';
    protected $primaryKey = 'id';
    protected $allowedFields = ['waktu', 'tma'];
}
