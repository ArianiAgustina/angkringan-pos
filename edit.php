<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<h2><?= $title ?></h2>
<form action="/angkringan-pos/produk/update/<?= $produk['id_produk'] ?>" method="POST" enctype="multipart/form-data">
   <input type="hidden" name="old_gambar" value="<?= $produk['gambar'] ?>">
   <div class="mb-3">
     <label for="id_kategori" class="form-label">Kategori</label>
     <select name="id_kategori" id="id_kategori" class="form-select" required>
       <?php foreach ($kategoriList as $kat): ?>
         <option value="<?= $kat['id_kategori'] ?>"
           <?= $produk['id_kategori'] == $kat['id_kategori'] ? 'selected' : '' ?>>
           <?= htmlspecialchars($kat['nama_kategori']) ?>
         </option>
       <?php endforeach; ?>
     </select>
   </div>
   <div class="mb-3">
     <label for="nama_produk" class="form-label">Nama Produk</label>
     <input type="text" class="form-control" name="nama_produk" id="nama_produk"
        value="<?= htmlspecialchars($produk['nama_produk']) ?>" required>
   </div>
   <div class="mb-3">
     <label for="harga" class="form-label">Harga</label>
     <input type="number" class="form-control" name="harga" id="harga"
        value="<?= $produk['harga'] ?>" required>
   </div>
   <div class="mb-3">
     <label for="stok" class="form-label">Stok</label>
     <input type="number" class="form-control" name="stok" id="stok"
        value="<?= $produk['stok'] ?>" required>
   </div>
   <div class="mb-3">
     <label for="gambar" class="form-label">Gambar (opsional)</label><br>
     <?php if ($produk['gambar']): ?>
       <img src="/angkringan-pos/assets/uploads/<?= $produk['gambar'] ?>" alt="Gambar" width="80" class="mb-2">
     <?php endif; ?>
     <input type="file" class="form-control" name="gambar" id="gambar" accept="image/*">
   </div>
   <button type="submit" class="btn btn-success">Perbarui</button>
   <a href="/angkringan-pos/produk" class="btn btn-secondary">Batal</a>
</form>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
