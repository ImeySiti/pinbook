<?php

namespace App\Models;

use CodeIgniter\Model;

class RakModel extends Model
{
    protected $table = 'rak';
    protected $primaryKey = 'id_rak';

    protected $allowedFields = [
    'nama_rak',
    'lokasi'
];

    // Ambil semua data rak
    public function getRak()
    {
        return $this->findAll();
    }
}