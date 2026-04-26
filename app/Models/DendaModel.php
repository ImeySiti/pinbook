<?php

namespace App\Models;

use CodeIgniter\Model;

class DendaModel extends Model
{
    protected $table = 'denda';
    protected $primaryKey = 'id_denda';

    protected $allowedFields = [
        'id_pengembalian',
        'jumlah_denda',
        'status'
    ];

    // ==========================
    // AMBIL SEMUA DENDA + PENGEMBALIAN
    // ==========================
    public function getAllDenda()
    {
        return $this->db->table('denda d')
            ->select('d.*, p.id_peminjaman, p.tanggal_dikembalikan')
            ->join('pengembalian p', 'p.id_pengembalian = d.id_pengembalian', 'left')
            ->get()
            ->getResultArray();
    }

    // ==========================
    // AMBIL DENDA BY ID PENGEMBALIAN
    // ==========================
    public function getByPengembalian($id_pengembalian)
    {
        return $this->where('id_pengembalian', $id_pengembalian)
            ->first();
    }

    // ==========================
    // CEK DENDA BELUM BAYAR
    // ==========================
    public function getBelumBayar()
    {
        return $this->where('status', 'belum')
            ->findAll();
    }

    // ==========================
    // CEK DENDA LUNAS
    // ==========================
    public function getLunas()
    {
        return $this->where('status', 'lunas')
            ->findAll();
    }
}