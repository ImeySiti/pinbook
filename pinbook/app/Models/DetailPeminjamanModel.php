<?php

namespace App\Models;
use CodeIgniter\Model;

class DetailPeminjamanModel extends Model
{
    protected $table = 'detail_peminjaman';
    protected $primaryKey = 'id_detail';
    protected $allowedFields = [
        'id_peminjaman',
        'id_buku',
        'jumlah'
    ];
}