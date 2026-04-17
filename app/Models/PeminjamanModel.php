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
        'status'
    ];

    public function getPeminjaman()
    {
        return $this->db->table('peminjaman')
            ->select('peminjaman.*, anggota.nis, petugas.jabatan')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left')
            ->get()
            ->getResultArray();
    }
}