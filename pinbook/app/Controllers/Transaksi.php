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
        $metode        = $this->request->getPost('metode');

        // ==========================
        // VALIDASI DATA
        // ==========================
        if (!$id_peminjaman || !$id_denda || !$metode) {
            return redirect()->back()->with('error', 'Data tidak lengkap');
        }

        // ==========================
        // AMBIL DENDA DARI DATABASE (AMAN)
        // ==========================
        $denda = $this->dendaModel->find($id_denda);

        if (!$denda) {
            return redirect()->back()->with('error', 'Data denda tidak ditemukan');
        }

        if ($denda['status'] === 'lunas') {
            return redirect()->back()->with('error', 'Denda sudah dibayar');
        }

        $jumlah = $denda['jumlah_denda'];

        // ==========================
        // VALIDASI METODE
        // ==========================
        if (!in_array($metode, ['cash', 'qris', 'transfer'])) {
            return redirect()->back()->with('error', 'Metode tidak valid');
        }

        // ==========================
        // STATUS PEMBAYARAN
        // ==========================
        $status = ($metode === 'cash') ? 'lunas' : 'pending';

        // ==========================
        // UPLOAD BUKTI (QRIS / TRANSFER)
        // ==========================
        $file = $this->request->getFile('bukti_bayar');
        $namaFile = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $namaFile = $file->getRandomName();
            $file->move(FCPATH . 'uploads/bukti', $namaFile);
        }

        // ==========================
        // SIMPAN KE TRANSAKSI
        // ==========================
        $this->transaksiModel->insert([
            'id_peminjaman' => $id_peminjaman,
            'jenis'         => 'denda',
            'jumlah'        => $jumlah,
            'status'        => $status,
            'tanggal'       => date('Y-m-d'),
            'metode'        => $metode,
            'bukti_bayar'   => $namaFile
        ]);

        // ==========================
        // UPDATE DENDA
        // ==========================
        $this->dendaModel->update($id_denda, [
            'status' => $status
        ]);

        // ==========================
        // UPDATE PEMINJAMAN
        // ==========================
        $this->peminjamanModel->update($id_peminjaman, [
            'status' => 'dikembalikan'
        ]);

        return redirect()->back()->with('success', 'Pembayaran berhasil diproses');
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