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
               <li class="breadcrumb-item active">Detail Data</li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title">Detail Data Pengajuan</h5>
                     <p>pilih tombol <strong><i class="bi bi-pencil-square"></i></strong> untuk mengubah detail data. pilih tombol <strong><i class="bi bi-power"></i></strong> untuk membatalkan pengajuan. pilih tombol <strong><i class="bi bi-x-octagon"></i></strong> untuk menghapus data</p>
                     <table class="table datatable">
                        <thead>
                           <tr>
                              <th>*</th>
                              <th>Nomor</th>
                              <th>Tujuan</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $n = 1;
                           foreach ($data as $d) {
                              $utusan = $db->query("select ifnull(count(*),0) as jumlah from utusan where idpengajuan = '".$d['idpengajuan']."'")->getRowArray()['jumlah'];
                              $agenda = $db->query("select ifnull(count(*),0) as jumlah from agenda where idpengajuan = '".$d['idpengajuan']."'")->getRowArray()['jumlah'];
                              ?>
                              <tr>
                                 <td><?php echo $n++ ?></td>
                                 <td><?php echo $d['nomor'] ?></td>
                                 <td>
                                    <?php echo $d['tujuan'] ?><br>
                                    <small><?php echo number_format($utusan).' anggota, '.number_format($agenda).' agenda' ?></small>
                                 </td>
                                 <td>
                                    <a href="<?php echo base_url('o/pengajuan/d/'.$d['idpengajuan']) ?>"><i class="bi bi-pencil-square" style="font-size: 1.2em;"></i></a>
                                    <?php if($d['status'] != '3' && $d['status'] != '4' && $d['status'] != '5'){ ?>
                                       &nbsp;
                                       <a href="<?php echo base_url('o/pengajuan/d/'.$d['idpengajuan']) ?>"><i class="bi bi-power" style="font-size: 1.2em;"></i></a>
                                       &nbsp;
                                       <a href="<?php echo base_url('o/pengajuan/d/'.$d['idpengajuan']) ?>"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                    <?php } ?>
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
   <?php echo view('operator/ascript') ?>
</body>
</html>