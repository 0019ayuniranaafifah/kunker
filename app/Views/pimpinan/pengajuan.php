<?php
$db = db_connect();
?>
<!DOCTYPE html>
<html lang="en">
<?php echo view('pimpinan/ahead') ?>
<body>
   <?php echo view('pimpinan/aheader') ?>
   <?php echo view('pimpinan/aaside') ?>
   <main id="main" class="main">
      <div class="pagetitle">
         <h1>Verifikasi</h1>
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo base_url('') ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Verifikasi Pengajuan</li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title">Verifikasi Data Pengajuan</h5>
                     <p>pilih tombol <strong><i class="bi bi-pencil-square"></i></strong> untuk mengubah detail data</p>
                     <table class="table datatable">
                        <thead>
                           <tr>
                              <th>*</th>
                              <th>Nomor</th>
                              <th>Tujuan</th>
                              <th>Status</th>
                              <th></th>
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
                                 <td>
                                    <a href="<?php echo base_url('p/verifikasi/d/'.$d['idpengajuan']) ?>"><i class="bi bi-pencil-square" style="font-size: 1.2em;"></i></a>
                                 </td>
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
   <?php echo view('pimpinan/ascript') ?>
</body>
</html>