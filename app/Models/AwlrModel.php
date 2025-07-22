<?php

namespace App\Models;
use CodeIgniter\Model;

class AwlrModel extends Model
{
    protected $table = 'data_all_telemetri';
    protected $primaryKey = 'id';
    protected $allowedFields = ['id_telemetri', 'waktu', 'tma'];
}
