<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<h2><?= $title ?></h2>

<table class="table table-bordered mb-3">
   <thead>
     <tr>
       <th>Nama Produk</th>
       <th class="text-center">Qty</th>
       <th class="text-end">Harga</th>
       <th class="text-end">Subtotal</th>
     </tr>
   </thead>
   <tbody>
     <?php foreach ($details as $det): ?>
       <tr>
         <td><?= htmlspecialchars($det['nama_produk']) ?></td>
         <td class="text-center"><?= $det['qty'] ?></td>
         <td class="text-end">Rp <?= number_format($det['harga_produk'],0,',','.') ?></td>
         <td class="text-end">Rp <?= number_format($det['subtotal'],0,',','.') ?></td>
       </tr>
     <?php endforeach; ?>
   </tbody>
   <tfoot>
     <tr>
       <th colspan="3" class="text-end">Total</th>
       <th class="text-end">Rp <?= number_format($total,0,',','.') ?></th>
     </tr>
   </tfoot>
</table>

<form action="/angkringan-pos/transaksi/process" method="POST" class="row g-3">
   <input type="hidden" name="id_order" value="<?= $id_order ?>">
   <input type="hidden" name="total" value="<?= $total ?>">
   <div class="col-md-4">
     <label for="bayar" class="form-label">Bayar (Rp)</label>
     <input type="number" class="form-control" id="bayar" name="bayar" required>
   </div>
   <div class="col-md-4">
     <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
     <select name="metode_pembayaran" id="metode_pembayaran" class="form-select" required>
       <option value="TUNAI" selected>TUNAI</option>
       <option value="NON-TUNAI">NON-TUNAI</option>
     </select>
   </div>
   <div class="col-md-4 d-flex align-items-end">
     <button type="submit" class="btn btn-success w-100">Proses Pembayaran</button>
   </div>
</form>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
