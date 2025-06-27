<?php
// app/Models/TransaksiModel.php

class TransaksiModel extends Model {
    private $table = 'transaksi';

    public function create($data) {
        $query = "INSERT INTO {$this->table} 
                  (id_order, bayar, kembalian, metode_pembayaran) 
                  VALUES (:id_order, :bayar, :kembalian, :metode)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_order', $data['id_order'], PDO::PARAM_INT);
        $stmt->bindParam(':bayar', $data['bayar'], PDO::PARAM_STR);
        $stmt->bindParam(':kembalian', $data['kembalian'], PDO::PARAM_STR);
        $stmt->bindParam(':metode', $data['metode_pembayaran'], PDO::PARAM_STR);
        return $stmt->execute();
    }

    public function markAsPaid($id_order) {
        $query = "UPDATE order_header SET status = 'PAID' WHERE id_order = :id_order";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_order', $id_order, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
