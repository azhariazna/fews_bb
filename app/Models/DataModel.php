<?php

namespace App\Models;

use CodeIgniter\Model;

class DataModel extends Model
{
    protected $table = 'grafik'; 
    protected $primaryKey = 'id';
    protected $allowedFields = ['jam', 'debit', 'id_telemetri'];
}
