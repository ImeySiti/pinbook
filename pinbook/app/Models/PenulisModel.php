<?php

namespace App\Models;

use CodeIgniter\Model;

class PenulisModel extends Model
{
    protected $table            = 'penulis';
    protected $primaryKey       = 'id_penulis';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_penulis'];

    // Validasi rules
    protected $validationRules = [
        'nama_penulis' => 'required|min_length[3]|max_length[100]|is_unique[penulis.nama_penulis,id_penulis,{id_penulis}]'
    ];

    protected $validationMessages = [
        'nama_penulis' => [
            'required' => 'Nama penulis harus diisi.',
            'min_length' => 'Nama penulis minimal 3 karakter.',
            'max_length' => 'Nama penulis maksimal 100 karakter.',
            'is_unique' => 'Nama penulis sudah ada.'
        ]
    ];

    // Method untuk mendapatkan data dengan pagination
    public function getPenulisPaginated($perPage = 10)
    {
        return $this->orderBy('nama_penulis', 'ASC')->paginate($perPage);
    }

    // Method untuk dropdown di form buku
    public function getAllForDropdown()
    {
        return $this->orderBy('nama_penulis', 'ASC')->findAll();
    }
}