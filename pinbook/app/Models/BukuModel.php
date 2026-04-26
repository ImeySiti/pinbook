<?php

namespace App\Models;

use CodeIgniter\Model;

class BukuModel extends Model
{
    protected $table = 'buku';
    protected $primaryKey = 'id_buku';

    // WAJIB: semua field yang boleh di-insert/update
    protected $allowedFields = [
        'isbn',
        'judul',
        'id_kategori',
        'id_penulis',
        'id_penerbit',
        'id_rak',        
         'buku_rak',        
        'tahun_terbit',
        'jumlah',
        'tersedia',
        'deskripsi',
        'cover'
    ];

    // optional tapi bagus
    protected $useTimestamps = false;
}