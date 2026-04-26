<?php

namespace App\Models;

use CodeIgniter\Model;

class DetailModel extends Model
{
    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id_detail';

    protected $allowedFields = [
        'id_peminjaman',
        'id_buku',
        'jumlah'
    ];

    // 🔥 Ambil semua buku dalam 1 peminjaman
    public function getBukuByPeminjaman($id)
    {
        return $this->select('detail_peminjaman.*, buku.judul, buku.cover')
            ->join('buku', 'buku.id_buku = detail_peminjaman.id_buku')
            ->where('id_peminjaman', $id)
            ->findAll();
    }
}