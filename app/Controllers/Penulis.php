<?php

namespace App\Controllers;

use App\Models\PenulisModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Penulis extends BaseController
{
    protected $penulisModel;

    public function __construct()
    {
        $this->penulisModel = new PenulisModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Penulis',
            'penulis' => $this->penulisModel->getPenulisPaginated(10),
            'pager' => $this->penulisModel->pager
        ];

        return view('penulis/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Penulis Baru',
            'validation' => \Config\Services::validation()
        ];

        return view('penulis/create', $data);
    }

    public function store()
    {
        if (!$this->validateData()) {
            return redirect()->back()->withInput();
        }

        $data = $this->request->getPost('nama_penulis');

        $this->penulisModel->insert($data);

        return redirect()->to('/penulis')->with('success', 'Penulis berhasil ditambahkan!');
    }

    public function edit($id = null)
    {
        $penulis = $this->penulisModel->find($id);

        if (!$penulis) {
            throw new PageNotFoundException('Penulis tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Penulis',
            'penulis' => $penulis,
            'validation' => \Config\Services::validation()
        ];

        return view('penulis/edit', $data);
    }

    public function update($id = null)
    {
        $penulis = $this->penulisModel->find($id);

        if (!$penulis) {
            throw new PageNotFoundException('Penulis tidak ditemukan.');
        }

        if (!$this->validateData($id)) {
            return redirect()->to("/penulis/edit/$id")->withInput();
        }

        $data = $this->request->getPost('nama_penulis');

        $this->penulisModel->update($id, $data);

        return redirect()->to('/penulis')->with('success', 'Penulis berhasil diupdate!');
    }

    public function delete($id = null)
    {
        $penulis = $this->penulisModel->find($id);

        if (!$penulis) {
            throw new PageNotFoundException('Penulis tidak ditemukan.');
        }

        $this->penulisModel->delete($id);

        return redirect()->to('/penulis')->with('success', 'Penulis berhasil dihapus!');
    }

    private function validateData($id = null)
    {
        $rules = [
            'nama_penulis' => 'required|min_length[3]|max_length[100]'
        ];

        // Tambahkan unique rule kecuali saat edit
        if ($id) {
            $rules['nama_penulis'] .= "|is_unique[penulis.nama_penulis,id_penulis,$id]";
        } else {
            $rules['nama_penulis'] .= "|is_unique[penulis.nama_penulis]";
        }

        return $this->validate($rules);
    }
}