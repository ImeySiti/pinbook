<?php

namespace App\Controllers;

use App\Models\TransaksiModel;

class Transaksi extends BaseController
{
    protected $transaksiModel;

    public function __construct()
    {
        $this->transaksiModel = new TransaksiModel();
    }

    // FORM EDIT
    public function edit($id)
    {
        $data['transaksi'] = $this->transaksiModel->find($id);

        if (!$data['transaksi']) {
            return redirect()->to('/transaksi')->with('error', 'Data tidak ditemukan');
        }

        return view('transaksi/edit', $data);
    }

    // PROSES UPDATE
    public function update($id)
    {
        $this->transaksiModel->update($id, [
            'jenis'        => $this->request->getPost('jenis'),
            'status'       => $this->request->getPost('status'),
            'jumlah'       => $this->request->getPost('jumlah'),
            'tanggal'      => $this->request->getPost('tanggal'),
            'metode'       => $this->request->getPost('metode'),
        ]);

        return redirect()->to('/transaksi')->with('success', 'Data berhasil diupdate');
    }
}