<?php

namespace App\Models;

use CodeIgniter\Model;

class PenerbitModel extends Model
{
    protected $table            = 'penerbit';
    protected $primaryKey       = 'id_penerbit';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['nama_penerbit', 'alamat'];

    // Validasi rules
    protected $validationRules = [
        'nama_penerbit' => 'required|min_length[3]|max_length[100]|is_unique[penerbit.nama_penerbit,id_penerbit,{id_penerbit}]',
        'alamat'        => 'permit_empty|max_length[500]'
    ];

    protected $validationMessages = [
        'nama_penerbit' => [
            'required' => 'Nama penerbit harus diisi.',
            'min_length' => 'Nama penerbit minimal 3 karakter.',
            'max_length' => 'Nama penerbit maksimal 100 karakter.',
            'is_unique' => 'Nama penerbit sudah ada.'
        ],
        'alamat' => [
            'max_length' => 'Alamat maksimal 500 karakter.'
        ]
    ];

    // Method untuk mendapatkan data dengan pagination
    public function getPenerbitPaginated($perPage = 10)
    {
        return $this->orderBy('nama_penerbit', 'ASC')->paginate($perPage);
    }
}