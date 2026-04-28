<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Home extends Controller
{
    public function index()
    {
        return view('layouts/dashboard');
    }

    // ================= REALTIME DASHBOARD =================
    public function stats()
    {
        $db = \Config\Database::connect();

        // TOTAL BUKU
        $total_buku = $db->table('buku')->countAllResults();

        // TOTAL ANGGOTA
        $total_anggota = $db->table('anggota')->countAllResults();

        // PEMINJAMAN AKTIF
        $peminjaman_aktif = $db->table('peminjaman')
            ->where('status', 'dipinjam')
            ->countAllResults();

        // TERLAMBAT (berdasarkan tanggal)
        $terlambat = $db->table('peminjaman')
            ->where('status', 'dipinjam')
            ->where('tanggal_kembali <', date('Y-m-d'))
            ->countAllResults();

        // PENGEMBALIAN
        $pengembalian = $db->table('pengembalian')->countAllResults();

        // RESPONSE JSON REALTIME
        return $this->response
            ->setHeader('Cache-Control', 'no-store, no-cache, must-revalidate, max-age=0')
            ->setJSON([
                'buku' => $total_buku,
                'anggota' => $total_anggota,
                'peminjaman' => $peminjaman_aktif,
                'terlambat' => $terlambat,
                'pengembalian' => $pengembalian
            ]);
    }
}