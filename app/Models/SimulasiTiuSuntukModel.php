<?php

namespace App\Models;
use CodeIgniter\Model;

class SimulasiTiuSuntukModel extends Model
{
    protected $table = 'simulasi_tiu_suntuk';
    protected $allowedFields = ['id', 'waktu', 'inflow', 'outflow', 'elevasi'];
}
