<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<h2><?= $title ?></h2>
<form action="/angkringan-pos/kategori/update/<?= $kategori['id_kategori'] ?>" method="POST">
   <div class="mb-3">
     <label for="nama_kategori" class="form-label">Nama Kategori</label>
     <input type="text" class="form-control" id="nama_kategori" name="nama_kategori"
        value="<?= htmlspecialchars($kategori['nama_kategori']) ?>" required>
   </div>
   <div class="mb-3">
     <label for="deskripsi" class="form-label">Deskripsi</label>
     <textarea class="form-control" id="deskripsi" name="deskripsi" rows="3"><?= htmlspecialchars($kategori['deskripsi']) ?></textarea>
   </div>
   <button type="submit" class="btn btn-success">Perbarui</button>
   <a href="/angkringan-pos/kategori" class="btn btn-secondary">Batal</a>
</form>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
