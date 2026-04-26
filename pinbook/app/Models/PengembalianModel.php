<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianModel extends Model
{
    protected $table = 'pengembalian';
    protected $primaryKey = 'id_pengembalian';

    protected $allowedFields = [
        'id_peminjaman',
        'tgl_kembali_asli',
        'tgl_pengembalian',
        'jumlah_hari_telat',
        'total_denda',
        'status_bayar'
    ];
}