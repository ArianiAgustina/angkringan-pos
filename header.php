<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= isset($title) ? $title : 'Angkringan POS' ?></title>
  <!-- Bootstrap 5 CSS via CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
  <!-- (Opsional) file CSS tambahan -->
  <link rel="stylesheet" href="<?= '/angkringan-pos/assets/css/style.css' ?>">
</head>

<body>
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4">
    <div class="container-fluid">
      <a class="navbar-brand" href="<?= '/angkringan-pos' ?>">POS Angkringan</a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
        aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav">
          <li class="nav-item"><a class="nav-link" href="/angkringan-pos">Dashboard</a></li>
          <li class="nav-item"><a class="nav-link" href="/angkringan-pos/kategori">Kategori</a></li>
          <li class="nav-item"><a class="nav-link" href="/angkringan-pos/produk">Produk</a></li>
          <li class="nav-item"><a class="nav-link" href="/angkringan-pos/order">Order</a></li>
          <li class="nav-item"><a class="nav-link" href="/angkringan-pos/transaksi">Transaksi</a></li>
        </ul>
      </div>
    </div>
  </nav>
  <div class="container">
<?php 
// Pastikan session sudah dimulai
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Cek apakah ada pesan error di session
if (isset($_SESSION['error']) && !empty($_SESSION['error'])): ?>
  <div class="alert alert-danger">
    <?= htmlspecialchars($_SESSION['error']) ?>
  </div>
  <?php 
  // Hapus pesan error setelah ditampilkan
  unset($_SESSION['error']); 
endif;
?>