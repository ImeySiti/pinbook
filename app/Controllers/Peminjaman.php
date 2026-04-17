<?php

namespace App\Controllers;

use App\Models\PeminjamanModel;
use App\Models\AnggotaModel;
use App\Models\PetugasModel;
use App\Models\BukuModel;

class Peminjaman extends BaseController
{
    protected $peminjamanModel;

    public function __construct()
    {
        $this->peminjamanModel = new PeminjamanModel();
    }

    // =========================
    // INDEX (JOIN BUKU)
    // =========================
    public function index()
    {
        $keyword = $this->request->getGet('keyword');

        $builder = $this->peminjamanModel
            ->select('peminjaman.*, anggota.nis, petugas.jabatan, buku.judul as judul_buku, buku.cover')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku', 'left');

        if (!empty($keyword)) {
            $builder->groupStart()
                ->like('peminjaman.status', $keyword)
                ->orLike('buku.judul', $keyword)
                ->orLike('anggota.nis', $keyword)
                ->groupEnd();
        }

        $data['peminjaman'] = $builder->findAll();

        return view('peminjaman/index', $data);
    }

    // =========================
    // DETAIL (BARU DITAMBAH)
    // =========================
    public function show($id)
    {
        $data['peminjaman'] = $this->peminjamanModel
            ->select('peminjaman.*, anggota.nis, petugas.jabatan, buku.judul as judul_buku, buku.cover')
            ->join('anggota', 'anggota.id_anggota = peminjaman.id_anggota', 'left')
            ->join('petugas', 'petugas.id_petugas = peminjaman.id_petugas', 'left')
            ->join('buku', 'buku.id_buku = peminjaman.id_buku', 'left')
            ->where('peminjaman.id_peminjaman', $id)
            ->first();

        if (!$data['peminjaman']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        return view('peminjaman/detail', $data);
    }

    // =========================
    // CREATE
    // =========================
    public function create()
    {
        $anggotaModel = new AnggotaModel();
        $petugasModel = new PetugasModel();
        $bukuModel    = new BukuModel();

        $data = [
            'anggota' => $anggotaModel->findAll(),
            'petugas' => $petugasModel->findAll(),
            'buku'    => $bukuModel->findAll()
        ];

        return view('peminjaman/create', $data);
    }

    // =========================
    // STORE
    // =========================
    public function store()
    {
        $tanggal_pinjam = $this->request->getPost('tanggal_pinjam');

        $tanggal_kembali = date('Y-m-d', strtotime($tanggal_pinjam . ' +7 days'));

        $this->peminjamanModel->save([
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_petugas'      => $this->request->getPost('id_petugas'),
            'id_buku'         => $this->request->getPost('id_buku'),
            'tanggal_pinjam'  => $tanggal_pinjam,
            'tanggal_kembali' => $tanggal_kembali,
            'status'          => 'dipinjam'
        ]);

        return redirect()->to('/peminjaman');
    }

    // =========================
    // EDIT
    // =========================
    public function edit($id)
    {
        $anggotaModel = new AnggotaModel();
        $petugasModel = new PetugasModel();
        $bukuModel    = new BukuModel();

        $data = [
            'peminjaman' => $this->peminjamanModel->find($id),
            'anggota'    => $anggotaModel->findAll(),
            'petugas'    => $petugasModel->findAll(),
            'buku'       => $bukuModel->findAll()
        ];

        return view('peminjaman/edit', $data);
    }

    // =========================
    // UPDATE
    // =========================
    public function update($id)
    {
        $this->peminjamanModel->update($id, [
            'id_anggota'      => $this->request->getPost('id_anggota'),
            'id_petugas'      => $this->request->getPost('id_petugas'),
            'id_buku'         => $this->request->getPost('id_buku'),
            'tanggal_pinjam'  => $this->request->getPost('tanggal_pinjam'),
            'tanggal_kembali' => $this->request->getPost('tanggal_kembali'),
            'status'          => $this->request->getPost('status')
        ]);

        return redirect()->to('/peminjaman');
    }

    // =========================
    // DELETE
    // =========================
    public function delete($id)
    {
        $this->peminjamanModel->delete($id);
        return redirect()->to('/peminjaman');
    }
}