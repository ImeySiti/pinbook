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
        'tgl_ambil',
        'status',
        'status_pengantaran',
        'status_pengajuan',
        'status_pengembalian',
        'bukti_bayar',
        'metode_pengambilan',
        'alamat_pengantaran'
    ];

    public function getWithAnggota()
    {
        return $this->db->table('peminjaman pm')
            ->select('pm.*, a.nama_anggota')
            ->join('anggota a', 'a.id_anggota = pm.id_anggota', 'left')
            ->get()
            ->getResultArray();
    }
}