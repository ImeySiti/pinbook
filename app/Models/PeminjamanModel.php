<?php

namespace App\Models;

use CodeIgniter\Model;

class PeminjamanModel extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'id_peminjaman';
   protected $allowedFields = [
    'id_anggota',
    'id_petugas',
    'tanggal_pinjam',
    'tanggal_kembali',
    'status',
    'status_pengantaran',
    'bukti_bayar',
    'metode_pengambilan',
    'alamat_pengantaran'
];

    // 🔥 TAMBAHKAN INI
    public function getWithAnggota()
    {
        return $this->db->table('peminjaman')
            ->select('peminjaman.*, anggota.nama_anggota')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota')
            ->get()
            ->getResultArray();
    }
    
}