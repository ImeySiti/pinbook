<?php

namespace App\Models;

use CodeIgniter\Model;

class KategoriModel extends Model
{
    protected $table            = 'kategori';
    protected $primaryKey       = 'id_kategori';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_kategori'];

    // Validasi rules
    protected $validationRules = [
        'nama_kategori' => 'required|min_length[3]|max_length[100]|is_unique[kategori.nama_kategori,id_kategori,{id_kategori}]'
    ];

    protected $validationMessages = [
        'nama_kategori' => [
            'required' => 'Nama kategori harus diisi.',
            'min_length' => 'Nama kategori minimal 3 karakter.',
            'max_length' => 'Nama kategori maksimal 100 karakter.',
            'is_unique' => 'Nama kategori sudah ada.'
        ]
    ];

    // Method untuk mendapatkan data dengan pagination
    public function getKategoriPaginated($perPage = 10)
    {
        return $this->orderBy('nama_kategori', 'ASC')->paginate($perPage);
    }
}