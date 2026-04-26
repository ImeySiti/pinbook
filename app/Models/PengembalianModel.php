<?php

namespace App\Models;

use CodeIgniter\Model;

class PengembalianModel extends Model
{
   
protected $table = 'pengembalian';
protected $primaryKey = 'id_pengembalian';

protected $allowedFields = [
    'id_peminjaman',
    'tanggal_dikembalikan', // Sesuaikan dengan nama di SQL (bukan tgl_pengembalian)
    'denda',
    'tgl_kembali_asli',
    'jumlah_hari_telat',
    'status_bayar'          // ENUM di database: 'belum', 'pending', 'lunas'
];
}