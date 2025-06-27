<?php
// app/Models/OrderModel.php

class OrderModel extends Model
{
    private $tableHeader = 'order_header';
    private $tableDetail = 'order_detail';

    public function getAllOrders()
    {
        $query = "SELECT * FROM {$this->tableHeader} ORDER BY tanggal DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id_order)
    {
        $query = "SELECT * FROM {$this->tableHeader} WHERE id_order = :id_order";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_order', $id_order, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDetails($id_order)
    {
        $query = "SELECT od.*, p.nama_produk 
                 FROM {$this->tableDetail} od
                 JOIN produk p ON od.id_produk = p.id_produk
                 WHERE od.id_order = :id_order";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id_order', $id_order, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createOrder($total, $items)
    {
        try {
            $this->db->beginTransaction();

            // --- Debug: tampilan nama tabel
            // echo "Tabel header: {$this->tableHeader}\n";
            // echo "Tabel detail: {$this->tableDetail}\n";

            // Insert ke order_header
            $queryHeader = "INSERT INTO {$this->tableHeader} (total) VALUES (:total)";
            $stmtHeader  = $this->db->prepare($queryHeader);
            $stmtHeader->bindParam(':total', $total);
            $stmtHeader->execute();
            $id_order    = $this->db->lastInsertId();

            if (!$id_order) {
                throw new \Exception("Gagal mendapatkan lastInsertId setelah INSERT order_header");
            }

            // Insert ke order_detail per item
            $queryDetail = "INSERT INTO {$this->tableDetail} 
                       (id_order, id_produk, harga_produk, qty, subtotal) 
                       VALUES (:id_order, :id_produk, :harga, :qty, :subtotal)";
            $stmtDetail  = $this->db->prepare($queryDetail);

            foreach ($items as $item) {
                $stmtDetail->bindParam(':id_order',   $id_order,          PDO::PARAM_INT);
                $stmtDetail->bindParam(':id_produk',  $item['id_produk'], PDO::PARAM_INT);
                $stmtDetail->bindParam(':harga',      $item['harga_produk'], PDO::PARAM_STR);
                $stmtDetail->bindParam(':qty',        $item['qty'],       PDO::PARAM_INT);
                $stmtDetail->bindParam(':subtotal',   $item['subtotal'],  PDO::PARAM_STR);
                $stmtDetail->execute();

                // Kurangi stok produk
                $stokQuery = "UPDATE produk SET stok = stok - :qty WHERE id_produk = :id_produk";
                $stokStmt  = $this->db->prepare($stokQuery);
                $stokStmt->bindParam(':qty',       $item['qty'],       PDO::PARAM_INT);
                $stokStmt->bindParam(':id_produk', $item['id_produk'], PDO::PARAM_INT);
                $stokStmt->execute();
            }

            $this->db->commit();
            return $id_order;
        } catch (Exception $e) {
            // Debug lengkap
            echo '<pre>';
            echo "DEBUG createOrder:\n";
            echo $e->getMessage() . "\n";
            echo $e->getTraceAsString();
            echo '</pre>';
            $this->db->rollBack();
            return false;
        }
    }
}
