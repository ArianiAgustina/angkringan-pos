<?php
// app/Controllers/KategoriController.php

class KategoriController extends Controller {
    private $kategoriModel;

    public function __construct() {
        $this->kategoriModel = $this->model('KategoriModel');
    }

    // List semua kategori
    public function index() {
        $kategoris = $this->kategoriModel->getAll();
        $data = [
            'title' => 'Daftar Kategori',
            'kategoris' => $kategoris
        ];
        $this->view('kategori/index', $data);
    }

    // Tampilkan form tambah kategori
    public function create() {
        $data = ['title' => 'Tambah Kategori'];
        $this->view('kategori/create', $data);
    }

    // Proses simpan kategori baru
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data_input = [
                'nama_kategori' => $_POST['nama_kategori'],
                'deskripsi' => $_POST['deskripsi']
            ];
            $this->kategoriModel->create($data_input);
            $this->redirect('/angkringan-pos/kategori');
        }
    }

    // Tampilkan form edit kategori
    public function edit($id) {
        $kategori = $this->kategoriModel->getById($id);
        $data = [
            'title' => 'Edit Kategori',
            'kategori' => $kategori
        ];
        $this->view('kategori/edit', $data);
    }

    // Proses update kategori
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data_input = [
                'nama_kategori' => $_POST['nama_kategori'],
                'deskripsi' => $_POST['deskripsi']
            ];
            $this->kategoriModel->update($id, $data_input);
            $this->redirect('/angkringan-pos/kategori');
        }
    }

    // Hapus kategori
    public function delete($id) {
        $this->kategoriModel->delete($id);
        $this->redirect('/angkringan-pos/kategori');
    }
}
