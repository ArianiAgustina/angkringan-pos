<?php require_once BASE_PATH . '/app/Views/layouts/header.php'; ?>

<h2><?= $title ?></h2>
<table class="table table-striped">
   <thead>
     <tr>
       <th>#</th>
       <th>ID Order</th>
       <th>Tanggal</th>
       <th>Total (Rp)</th>
       <th>Status</th>
       <th>Aksi</th>
     </tr>
   </thead>
   <tbody>
     <?php foreach ($orders as $i => $ord): ?>
       <tr>
         <td><?= $i + 1 ?></td>
         <td><?= $ord['id_order'] ?></td>
         <td><?= date('d-m-Y H:i', strtotime($ord['tanggal'])) ?></td>
         <td>Rp <?= number_format($ord['total'],0,',','.') ?></td>
         <td><?= ucfirst(strtolower($ord['status'])) ?></td>
         <td>
           <a href="/angkringan-pos/order/receipt/<?= $ord['id_order'] ?>" class="btn btn-sm btn-info">
             Lihat Struk
           </a>
         </td>
       </tr>
     <?php endforeach; ?>
   </tbody>
</table>

<?php require_once BASE_PATH . '/app/Views/layouts/footer.php'; ?>
