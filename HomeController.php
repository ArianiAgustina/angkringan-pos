<?php
// app/Controllers/HomeController.php

class HomeController extends Controller {
    private $orderModel;

    public function __construct() {
        $this->orderModel = $this->model('OrderModel');
    }

    public function index() {
        // Hitung total pendapatan dari semua order yang status = PAID
        $queryPendapatan = "SELECT SUM(total) as total_pendapatan FROM order_header WHERE status = 'PAID'";
        $stmt = $this->orderModel->db->prepare($queryPendapatan);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $total_pendapatan = $row['total_pendapatan'] ?? 0;

        // Hitung total order terbayar
        $queryOrder = "SELECT COUNT(*) as total_order FROM order_header WHERE status = 'PAID'";
        $stmt2 = $this->orderModel->db->prepare($queryOrder);
        $stmt2->execute();
        $row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
        $total_order = $row2['total_order'] ?? 0;

        $data = [
            'title' => 'Dashboard Angkringan POS',
            'total_pendapatan' => $total_pendapatan,
            'total_order' => $total_order
        ];
        $this->view('home/index', $data);
    }
}
