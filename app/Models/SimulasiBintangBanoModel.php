<?php

namespace App\Models;
use CodeIgniter\Model;

class SimulasiBintangBanoModel extends Model
{
    protected $table = 'simulasi_bintang_bano';
    protected $allowedFields = ['id', 'waktu', 'inflow', 'outflow', 'elevasi'];
}
