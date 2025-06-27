<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<h2><?= $title ?></h2>
<form action="/angkringan-pos/produk/store" method="POST" enctype="multipart/form-data">
   <div class="mb-3">
     <label for="id_kategori" class="form-label">Kategori</label>
     <select name="id_kategori" id="id_kategori" class="form-select" required>
       <option value="" disabled selected>-- Pilih Kategori --</option>
       <?php foreach ($kategoriList as $kat): ?>
         <option value="<?= $kat['id_kategori'] ?>"><?= htmlspecialchars($kat['nama_kategori']) ?></option>
       <?php endforeach; ?>
     </select>
   </div>
   <div class="mb-3">
     <label for="nama_produk" class="form-label">Nama Produk</label>
     <input type="text" class="form-control" name="nama_produk" id="nama_produk" required>
   </div>
   <div class="mb-3">
     <label for="harga" class="form-label">Harga</label>
     <input type="number" class="form-control" name="harga" id="harga" required>
   </div>
   <div class="mb-3">
     <label for="stok" class="form-label">Stok</label>
     <input type="number" class="form-control" name="stok" id="stok" required>
   </div>
   <div class="mb-3">
     <label for="gambar" class="form-label">Gambar (opsional)</label>
     <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*">
   </div>
   <button type="submit" class="btn btn-success">Simpan</button>
   <a href="/angkringan-pos/produk" class="btn btn-secondary">Batal</a>
</form>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
