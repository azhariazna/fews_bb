<?php

namespace App\Models;
use CodeIgniter\Model;

class SimulasiMenemengModel extends Model
{
    protected $table = 'simulasi_awlr_menemeng';
    protected $primaryKey = 'id';
    protected $allowedFields = ['waktu', 'tma'];
}
