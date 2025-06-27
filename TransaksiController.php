<?php
// app/Controllers/TransaksiController.php

class TransaksiController extends Controller
{
    private $orderModel;
    private $transaksiModel;

    public function __construct()
    {
        $this->orderModel = $this->model('OrderModel');
        $this->transaksiModel = $this->model('TransaksiModel');
    }

    // Tampilkan daftar order yang belum dibayar
    public function index()
    {
        // Ambil order dengan status NEW
        $query = "SELECT * FROM order_header WHERE status = 'NEW' ORDER BY tanggal DESC";
        $stmt = $this->orderModel->db->prepare($query);
        $stmt->execute();
        $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $data = [
            'title' => 'Daftar Transaksi',
            'orders' => $orders
        ];
        $this->view('transaksi/index', $data);
    }

    // Form pembayaran untuk satu order
    public function pay($id_order)
    {
        $order = $this->orderModel->getOrderById($id_order);
        $details = $this->orderModel->getDetails($id_order);
        $total = $order['total'];

        $data = [
            'title' => 'Pembayaran Order #' . $id_order,
            'id_order' => $id_order,
            'total' => $total,
            'details' => $details
        ];
        $this->view('transaksi/pay', $data);
    }

    // Proses simpan transaksi
    public function process()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_order = $_POST['id_order'];
            $total = (float) $_POST['total'];
            $bayar = (float) $_POST['bayar'];
            $kembalian = $bayar - $total;
            $metode = $_POST['metode_pembayaran'];

            if ($bayar < $total) {
                $_SESSION['error'] = "Uang bayar kurang.";
                $this->redirect("/angkringan-pos/transaksi/pay/{$id_order}");
                exit;
            }

            // Simpan data transaksi
            $data_input = [
                'id_order'        => $id_order,
                'bayar'           => $bayar,
                'kembalian'       => $kembalian,
                'metode_pembayaran' => $metode
            ];

            // Jika simpan gagal, tampilkan error
            $created = $this->transaksiModel->create($data_input);
            if (!$created) {
                $_SESSION['error'] = "Gagal simpan transaksi.";
                $this->redirect("/angkringan-pos/transaksi/pay/{$id_order}");
                exit;
            }

            // Tandai order_header sebagai PAID
            $this->transaksiModel->markAsPaid($id_order);

            // Berhasil → arahkan ke daftar transaksi (atau halaman sukses lain)
            $this->redirect('/angkringan-pos/transaksi');
            exit;
        }

        // Kalau bukan POST, langsung redirect ke daftar transaksi
        $this->redirect('/angkringan-pos/transaksi');
        exit;
    }
}
