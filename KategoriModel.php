<?php
// app/Models/KategoriModel.php

class KategoriModel extends Model {
    private $table = 'kategori';

    public function getAll() {
        $query = "SELECT * FROM {$this->table} ORDER BY nama_kategori ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $query = "SELECT * FROM {$this->table} WHERE id_kategori = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $query = "INSERT INTO {$this->table} (nama_kategori, deskripsi) VALUES (:nama, :deskripsi)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama', $data['nama_kategori'], PDO::PARAM_STR);
        $stmt->bindParam(':deskripsi', $data['deskripsi'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function update($id, $data) {
        $query = "UPDATE {$this->table} SET nama_kategori = :nama, deskripsi = :deskripsi WHERE id_kategori = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':nama', $data['nama_kategori'], PDO::PARAM_STR);
        $stmt->bindParam(':deskripsi', $data['deskripsi'], PDO::PARAM_STR);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM {$this->table} WHERE id_kategori = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
