<?php
$db = db_connect();
?>
<!DOCTYPE html>
<html lang="en">
<?php echo view('operator/ahead') ?>
<body>
   <?php echo view('operator/aheader') ?>
   <?php echo view('operator/aaside') ?>
   <main id="main" class="main">
      <div class="pagetitle">
         <h1>Pengajuan</h1>
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo base_url('') ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Status Verifikasi</li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title">Status Verifikasi</h5>
                     <table class="table datatable">
                        <thead>
                           <tr>
                              <th>*</th>
                              <th>Nomor</th>
                              <th>Tujuan</th>
                              <th>Status</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $n = 1;
                           foreach ($data as $d) {
                              $utusan = $db->query("select ifnull(count(*),0) as jumlah from utusan where idpengajuan = '".$d['idpengajuan']."'")->getRowArray()['jumlah'];
                              $agenda = $db->query("select ifnull(count(*),0) as jumlah from agenda where idpengajuan = '".$d['idpengajuan']."'")->getRowArray()['jumlah'];
                              $status = "-";
                              if($d['status'] == '0'){
                                 $status = "Proses Verifikasi Pimpinan";
                              }else if($d['status'] == '1'){
                                 $status = "Penyesuaian Pengajuan";
                              }else if($d['status'] == '2'){
                                 $status = "Proses Verifikasi Lembaga / Instansi";
                              }else if($d['status'] == '3'){
                                 $status = "Pengajuan Dibatalkan";
                              }else if($d['status'] == '4'){
                                 $status = "Verifikasi Selesai";
                              }else{
                                 $status = "Selesai";
                              }
                              ?>
                              <tr>
                                 <td><?php echo $n++ ?></td>
                                 <td><?php echo $d['nomor'] ?></td>
                                 <td>
                                    <?php echo $d['tujuan'] ?><br>
                                    <small><?php echo number_format($utusan).' anggota, '.number_format($agenda).' agenda' ?></small>
                                 </td>
                                 <td><?php echo $status ?></td>
                              </tr>
                           <?php } ?>
                        </tbody>
                     </table>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </main>
   <?php echo view('operator/ascript') ?>
</body>
</html>