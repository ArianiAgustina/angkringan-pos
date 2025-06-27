<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<div class="text-center mb-4">
   <h3>Angkringan POS</h3>
   <p>Tanggal: <?= date('d-m-Y H:i', strtotime($orderHeader['tanggal'])) ?></p>
</div>

<table class="table table-borderless">
   <thead>
     <tr>
       <th>Nama Produk</th>
       <th class="text-center">Qty</th>
       <th class="text-end">Harga</th>
       <th class="text-end">Subtotal</th>
     </tr>
   </thead>
   <tbody>
     <?php foreach ($orderDetails as $det): ?>
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
       <th class="text-end">Rp <?= number_format($orderHeader['total'],0,',','.') ?></th>
     </tr>
   </tfoot>
</table>

<div class="text-center mt-5">
   <button onclick="window.print()" class="btn btn-primary">Cetak Struk</button>
   <a href="/angkringan-pos/order" class="btn btn-secondary">Kembali ke Order</a>
</div>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
