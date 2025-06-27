<?php
// app/Controllers/OrderController.php

class OrderController extends Controller
{
    private $orderModel;
    private $produkModel;

    public function __construct()
    {
        $this->orderModel = $this->model('OrderModel');
        $this->produkModel = $this->model('ProdukModel');
        session_start();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    // Tampilkan form order (keranjang)
    public function index()
    {
        // Ambil semua produk untuk pilihan
        $produkList = $this->produkModel->getAll();
        $cart = $_SESSION['cart'];

        $data = [
            'title' => 'Buat Order',
            'produkList' => $produkList,
            'cart' => $cart
        ];
        $this->view('order/index', $data);
    }

    // Tambah item ke cart
    public function addToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id_produk = $_POST['id_produk'];
            $qty = (int) $_POST['qty'];
            // Ambil detail produk
            $produk = $this->produkModel->getById($id_produk);
            if ($produk && $qty > 0) {
                // Hitung subtotal
                $subtotal = $produk['harga'] * $qty;
                // Simpan ke session cart
                $_SESSION['cart'][] = [
                    'id_produk' => $produk['id_produk'],
                    'nama_produk' => $produk['nama_produk'],
                    'harga_produk' => $produk['harga'],
                    'qty' => $qty,
                    'subtotal' => $subtotal
                ];
            }
        }
        $this->redirect('/angkringan-pos/order');
    }

    // Hapus item cart berdasarkan indeks
    public function removeFromCart($index)
    {
        if (isset($_SESSION['cart'][$index])) {
            array_splice($_SESSION['cart'], $index, 1);
        }
        $this->redirect('/angkringan-pos/order');
    }

    // Proses simpan order
    public function checkout()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cart = $_SESSION['cart'];
            
            if (!empty($cart)) {
                // Hitung total
                $total = 0;
                foreach ($cart as $item) {
                    $total += $item['subtotal'];
                }
                // Simpan ke database
                $id_order = $this->orderModel->createOrder($total, $cart);
        //         var_dump($total, $cart);
        // exit;
                if ($id_order) {
                    // Setelah sukses, kosongkan cart dan redirect ke detail atau cetak struk
                    $_SESSION['order_id'] = $id_order;
                    $_SESSION['cart'] = [];
                    $this->redirect('/angkringan-pos/order/receipt');
                } else {
                    // Gagal simpan
                    $_SESSION['error'] = "Terjadi kesalahan saat menyimpan order.";
                    $this->redirect('/angkringan-pos/order');
                }
            } else {
                $this->redirect('/angkringan-pos/order');
            }
        }
    }

    // Tampilkan halaman struk setelah checkout
    public function receipt()
    {
        if (!isset($_SESSION['order_id'])) {
            $this->redirect('/angkringan-pos/order');
        }
        $id_order = $_SESSION['order_id'];
        $orderHeader  = $this->orderModel->getOrderById($id_order);
        $orderDetails = $this->orderModel->getDetails($id_order);

        $data = [
            'title'         => 'Struk Penjualan',
            'orderHeader'   => $orderHeader,
            'orderDetails'  => $orderDetails,
        ];
        $this->view('order/receipt', $data);
    }


    // Lihat daftar order (history)
    public function history()
    {
        $orders = $this->orderModel->getAllOrders();
        $data = [
            'title' => 'History Order',
            'orders' => $orders
        ];
        $this->view('order/history', $data);
    }
}
