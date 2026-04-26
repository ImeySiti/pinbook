<?php

namespace App\Controllers;

use App\Models\RakModel;

class Rak extends BaseController
{
    protected $rakModel;

    public function __construct()
    {
        $this->rakModel = new RakModel();
    }

    // TAMPIL DATA
    public function index()
{
    $keyword = $this->request->getGet('keyword');

    $rakModel = new \App\Models\RakModel();

    if ($keyword) {
        $rak = $rakModel
            ->like('nama_rak', $keyword)
            ->orLike('lokasi', $keyword)
            ->findAll();
    } else {
        $rak = $rakModel->findAll();
    }

    return view('rak/index', [
        'rak' => $rak,
        'keyword' => $keyword
    ]);
}

    // FORM TAMBAH
    public function create()
    {
        return view('rak/create');
    }

    // SIMPAN
    public function store()
    {
        $this->rakModel->save([
            'nama_rak' => $this->request->getPost('nama_rak'),
            'lokasi'   => $this->request->getPost('lokasi')
        ]);

        return redirect()->to('/rak');
    }

    // FORM EDIT
    public function edit($id)
    {
        $data['rak'] = $this->rakModel->find($id);
        return view('rak/edit', $data);
    }

    // UPDATE
    public function update($id)
    {
        $this->rakModel->update($id, [
            'nama_rak' => $this->request->getPost('nama_rak'),
            'lokasi'   => $this->request->getPost('lokasi')
        ]);

        return redirect()->to('/rak');
    }

    // DELETE
    public function delete($id)
    {
        $this->rakModel->delete($id);
        return redirect()->to('/rak');
    }
}