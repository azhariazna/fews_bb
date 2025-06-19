<?php

namespace App\Models;
use CodeIgniter\Model;

class GrafikModel extends Model
{
    protected $table = 'grafik';
    protected $allowedFields = ['id_telemetri', 'jam', 'debit'];
    protected $returnType = 'array';

    public function getByTelemetriId($idTelemetri)
    {
        return $this->where('id_telemetri', $idTelemetri)
                    ->orderBy('jam', 'ASC')
                    ->findAll();
    }
}
