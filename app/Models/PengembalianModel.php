<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianModel extends Model
{
    protected $table = 'pengembalian';
    protected $primaryKey = 'id_pengembalian';

    protected $allowedFields = [
        'id_peminjaman',
        'tanggal_kembali',
        'denda'
    ];
}