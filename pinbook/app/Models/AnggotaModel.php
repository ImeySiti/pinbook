<?php

namespace App\Models;

use CodeIgniter\Model;

class AnggotaModel extends Model
{
    protected $table = 'anggota';
    protected $primaryKey = 'id_anggota';

    protected $allowedFields = [
        'user_id',
        'nis',
        'alamat',
        'no_hp',
        'tanggal_daftar'
    ];

    // Ambil semua data anggota
    public function getAnggota()
    {
        return $this->findAll();
    }

    // Ambil data anggota + search (opsional)
    public function search($keyword)
    {
        return $this->table($this->table)
            ->like('nis', $keyword)
            ->orLike('alamat', $keyword)
            ->orLike('no_hp', $keyword)
            ->findAll();
    }

    // Ambil 1 data detail
    public function getDetail($id)
    {
        return $this->where('id_anggota', $id)->first();
    }
}