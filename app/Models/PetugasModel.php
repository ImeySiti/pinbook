<?php

namespace App\Models;

use CodeIgniter\Model;

class PetugasModel extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $allowedFields = [
        'user_id',
        'jabatan'
    ];

    // Ambil semua data petugas
    public function getPetugas()
    {
        return $this->findAll();
    }

    // Search petugas (opsional)
    public function search($keyword)
    {
        return $this->table($this->table)
            ->like('jabatan', $keyword)
            ->findAll();
    }

    // Ambil detail 1 petugas
    public function getDetail($id)
    {
        return $this->where('id_petugas', $id)->first();
    }
}