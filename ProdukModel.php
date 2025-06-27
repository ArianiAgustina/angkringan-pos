<?php
// app/Models/ProdukModel.php

class ProdukModel extends Model {
    private $table = 'produk';

    public function getAll() {
        $query = "SELECT p.*, k.nama_kategori 
                 FROM {$this->table} p 
                 JOIN kategori k ON p.id_kategori = k.id_kategori
                 ORDER BY p.nama_produk ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id_produk = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} 
                 (id_kategori, nama_produk, harga, stok, gambar) 
                 VALUES (:kategori, :nama, :harga, :stok, :gambar)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':kategori', $data['id_kategori'], PDO::PARAM_INT);
        $stmt->bindParam(':nama', $data['nama_produk'], PDO::PARAM_STR);
        $stmt->bindParam(':harga', $data['harga'], PDO::PARAM_STR);
        $stmt->bindParam(':stok', $data['stok'], PDO::PARAM_INT);
        $stmt->bindParam(':gambar', $data['gambar'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET 
                  id_kategori = :kategori, 
                  nama_produk = :nama, 
                  harga = :harga, 
                  stok = :stok, 
                  gambar = :gambar 
                  WHERE id_produk = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':kategori', $data['id_kategori'], PDO::PARAM_INT);
        $stmt->bindParam(':nama', $data['nama_produk'], PDO::PARAM_STR);
        $stmt->bindParam(':harga', $data['harga'], PDO::PARAM_STR);
        $stmt->bindParam(':stok', $data['stok'], PDO::PARAM_INT);
        $stmt->bindParam(':gambar', $data['gambar'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id_produk = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAllKategori() {
        // Untuk dropdown pilih kategori
        $query = "SELECT * FROM kategori ORDER BY nama_kategori ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
