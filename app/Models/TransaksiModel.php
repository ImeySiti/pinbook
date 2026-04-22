<?php

namespace App\Models;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $table = 'transaksi';
    protected $primaryKey = 'id_transaksi';

    protected $allowedFields = [
        'id_peminjaman',
        'jenis',
        'jumlah',
        'status',
        'tanggal',
        'bukti_bayar'
    ];

    protected $useTimestamps = false;

    // ================= AMBIL BERDASARKAN PEMINJAMAN =================
    public function getByPeminjaman($id_peminjaman)
    {
        return $this->where('id_peminjaman', $id_peminjaman)
                    ->findAll();
    }

    // ================= CEK SUDAH BAYAR ATAU BELUM =================
    public function sudahBayar($id_peminjaman)
    {
        return $this->where('id_peminjaman', $id_peminjaman)
                    ->where('status', 'lunas')
                    ->first();
    }

    // ================= AMBIL TRANSAKSI ONGKIR =================
    public function getOngkir($id_peminjaman)
    {
        return $this->where('id_peminjaman', $id_peminjaman)
                    ->where('jenis', 'ongkir')
                    ->first();
    }
}