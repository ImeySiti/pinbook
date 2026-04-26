<?php

namespace App\Controllers;

use App\Models\TransaksiModel;
use App\Models\DendaModel;
use App\Models\PeminjamanModel;

class Transaksi extends BaseController
{
    protected $transaksiModel;
    protected $dendaModel;
    protected $peminjamanModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
        $this->dendaModel = new DendaModel();
        $this->peminjamanModel = new PeminjamanModel();
    }

    // ==========================
    // BAYAR DENDA
    // ==========================
   public function bayar()
{
    $id_peminjaman = $this->request->getPost('id_peminjaman');
    $id_denda      = $this->request->getPost('id_denda');
    $jumlah        = $this->request->getPost('jumlah');
    $metode        = $this->request->getPost('metode');

    if (!$id_denda) {
        return redirect()->back()->with('error', 'Data tidak valid');
    }

    // ================= UPDATE DENDA =================
    $this->db->table('denda')
        ->where('id_denda', $id_denda)
        ->update([
            'status' => 'lunas',
            'metode' => $metode
        ]);

    // ================= UPDATE PEMINJAMAN =================
    $this->db->table('peminjaman')
        ->where('id_peminjaman', $id_peminjaman)
        ->update([
            'status' => 'dikembalikan'
        ]);

    return redirect()->to('/pengembalian')
        ->with('success', 'Pembayaran berhasil');
}
    // ==========================
    // KONFIRMASI ADMIN (QRIS / TRANSFER)
    // ==========================
    public function konfirmasi($id)
    {
        $transaksi = $this->transaksiModel->find($id);

        if (!$transaksi) {
            return redirect()->back()->with('error', 'Transaksi tidak ditemukan');
        }

        // update transaksi
        $this->transaksiModel->update($id, [
            'status' => 'lunas'
        ]);

        // update denda
        $this->dendaModel
            ->where('id_peminjaman', $transaksi['id_peminjaman'])
            ->set(['status' => 'lunas'])
            ->update();

        return redirect()->back()->with('success', 'Pembayaran dikonfirmasi');
    }

    // ==========================
    // (OPSIONAL) LIST TRANSAKSI
    // ==========================
    public function index()
    {
        $data['transaksi'] = $this->transaksiModel->findAll();
        return view('transaksi/index', $data);
    }
}