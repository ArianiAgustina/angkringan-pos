<?php
// app/Controllers/ProdukController.php

class ProdukController extends Controller {
    private $produkModel;

    public function __construct() {
        $this->produkModel = $this->model('ProdukModel');
    }

    // List semua produk
    public function index() {
        $produks = $this->produkModel->getAll();
        $data = [
            'title' => 'Daftar Produk',
            'produks' => $produks
        ];
        $this->view('produk/index', $data);
    }

    // Form tambah produk
    public function create() {
        $kategoriList = $this->produkModel->getAllKategori();
        $data = [
            'title' => 'Tambah Produk',
            'kategoriList' => $kategoriList
        ];
        $this->view('produk/create', $data);
    }

    // Proses simpan produk
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Upload gambar (opsional)
            $gambar_nama = null;
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $ekstensi = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $gambar_nama = time() . '.' . $ekstensi;
                move_uploaded_file($_FILES['gambar']['tmp_name'], BASE_PATH . '/assets/uploads/' . $gambar_nama);
            }

            $data_input = [
                'id_kategori' => $_POST['id_kategori'],
                'nama_produk' => $_POST['nama_produk'],
                'harga' => $_POST['harga'],
                'stok' => $_POST['stok'],
                'gambar' => $gambar_nama
            ];
            $this->produkModel->create($data_input);
            $this->redirect('/angkringan-pos/produk');
        }
    }

    // Form edit produk
    public function edit($id) {
        $produk = $this->produkModel->getById($id);
        $kategoriList = $this->produkModel->getAllKategori();
        $data = [
            'title' => 'Edit Produk',
            'produk' => $produk,
            'kategoriList' => $kategoriList
        ];
        $this->view('produk/edit', $data);
    }

    // Proses update produk
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Tangani upload gambar baru (jika ada)
            $gambar_nama = $_POST['old_gambar'];
            if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] == 0) {
                $ekstensi = pathinfo($_FILES['gambar']['name'], PATHINFO_EXTENSION);
                $gambar_nama = time() . '.' . $ekstensi;
                move_uploaded_file($_FILES['gambar']['tmp_name'], BASE_PATH . '/assets/uploads/' . $gambar_nama);
            }

            $data_input = [
                'id_kategori' => $_POST['id_kategori'],
                'nama_produk' => $_POST['nama_produk'],
                'harga' => $_POST['harga'],
                'stok' => $_POST['stok'],
                'gambar' => $gambar_nama
            ];
            $this->produkModel->update($id, $data_input);
            $this->redirect('/angkringan-pos/produk');
        }
    }

    // Hapus produk
    public function delete($id) {
        $this->produkModel->delete($id);
        $this->redirect('/angkringan-pos/produk');
    }
}
