<?php

namespace App\Controllers;

use App\Models\PenerbitModel;
use CodeIgniter\Exceptions\PageNotFoundException;

class Penerbit extends BaseController
{
    protected $penerbitModel;

    public function __construct()
    {
        $this->penerbitModel = new PenerbitModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Data Penerbit',
            'penerbit' => $this->penerbitModel->getPenerbitPaginated(10),
            'pager' => $this->penerbitModel->pager
        ];

        return view('penerbit/index', $data);
    }

    public function create()
    {
        $data = [
            'title' => 'Tambah Penerbit Baru',
            'validation' => \Config\Services::validation()
        ];

        return view('penerbit/create', $data);
    }

    public function store()
    {
        if (!$this->validateData()) {
            return redirect()->back()->withInput();
        }

        $data = $this->request->getPost(['nama_penerbit', 'alamat']);

        $this->penerbitModel->insert($data);

        return redirect()->to('/penerbit')->with('success', 'Penerbit berhasil ditambahkan!');
    }

    public function edit($id = null)
    {
        $penerbit = $this->penerbitModel->find($id);

        if (!$penerbit) {
            throw new PageNotFoundException('Penerbit tidak ditemukan.');
        }

        $data = [
            'title' => 'Edit Penerbit',
            'penerbit' => $penerbit,
            'validation' => \Config\Services::validation()
        ];

        return view('penerbit/edit', $data);
    }

    public function update($id = null)
    {
        $penerbit = $this->penerbitModel->find($id);

        if (!$penerbit) {
            throw new PageNotFoundException('Penerbit tidak ditemukan.');
        }

        if (!$this->validateData($id)) {
            return redirect()->to("/penerbit/edit/$id")->withInput();
        }

        $data = $this->request->getPost(['nama_penerbit', 'alamat']);

        $this->penerbitModel->update($id, $data);

        return redirect()->to('/penerbit')->with('success', 'Penerbit berhasil diupdate!');
    }

    public function delete($id = null)
    {
        $penerbit = $this->penerbitModel->find($id);

        if (!$penerbit) {
            throw new PageNotFoundException('Penerbit tidak ditemukan.');
        }

        $this->penerbitModel->delete($id);

        return redirect()->to('/penerbit')->with('success', 'Penerbit berhasil dihapus!');
    }

    private function validateData($id = null)
    {
        $rules = [
            'nama_penerbit' => 'required|min_length[3]|max_length[100]',
            'alamat'        => 'permit_empty|max_length[500]'
        ];

        // Tambahkan unique rule kecuali saat edit
        if ($id) {
            $rules['nama_penerbit'] .= "|is_unique[penerbit.nama_penerbit,id_penerbit,$id]";
        } else {
            $rules['nama_penerbit'] .= "|is_unique[penerbit.nama_penerbit]";
        }

        return $this->validate($rules);
    }
}