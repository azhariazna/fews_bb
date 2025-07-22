<?php

namespace App\Models;
use CodeIgniter\Model;

class SimulasiSampirModel extends Model
{
    protected $table = 'simulasi_awlr_sampir';
    protected $primaryKey = 'id';
    protected $allowedFields = ['waktu', 'tma'];
}
