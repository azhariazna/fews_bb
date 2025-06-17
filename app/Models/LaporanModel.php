<?php
namespace App\Models;

use CodeIgniter\Model;

class LaporanModel extends Model
{
    protected $table = 'laporan_rtd';
    protected $primaryKey = 'id';
    protected $allowedFields = ['nama_file'];
    public $timestamps = false;
}
