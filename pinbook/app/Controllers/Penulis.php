<?php

namespace App\Controllers;

use App\Models\PenulisModel;

class Penulis extends BaseController
{
    protected $penulis;

    public function __construct()
    {
        $this->penulis = new PenulisModel();
    }

    // =========================
    // LIST + SEARCH
    // =========================
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        if ($keyword) {
            $penulis = $this->penulis
                ->like('nama_penulis', $keyword)
                ->findAll();
        } else {
            $penulis = $this->penulis->findAll();
        }

        return view('penulis/index', [
            'penulis' => $penulis,
            'keyword' => $keyword
        ]);
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        return view('penulis/create');
    }

    // =========================
    // STORE
    // =========================
    public function store()
    {
        $nama = $this->request->getPost('nama_penulis');

        // anti duplikat
        $existing = $this->penulis
            ->where('nama_penulis', $nama)
            ->first();

        if (!$existing && $nama != '') {
            $this->penulis->insert([
                'nama_penulis' => $nama
            ]);
        }

        return redirect()->to('/penulis');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        return view('penulis/edit', [
            'penulis' => $this->penulis->find($id)
        ]);
    }

    // =========================
    // UPDATE
    // =========================
    public function update($id)
    {
        $this->penulis->update($id, [
            'nama_penulis' => $this->request->getPost('nama_penulis')
        ]);

        return redirect()->to('/penulis');
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id)
    {
        $this->penulis->delete($id);
        return redirect()->to('/penulis');
    }
}