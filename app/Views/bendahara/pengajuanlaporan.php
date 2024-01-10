<?php
$db = db_connect();
$daftarbulan = [1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$daftartahun = date('Y');
$cek = $db->query("select ifnull(count(*),0) as jumlah from bayar")->getRowArray()['jumlah'];
if($cek > 0){
   $daftartahun = $db->query("select year(waktu) as tahun from bayar order by waktu asc limit 1")->getRowArray()['tahun'];
}
?>
<!DOCTYPE html>
<html lang="en">
<?php echo view('bendahara/ahead') ?>
<body>
   <?php echo view('bendahara/aheader') ?>
   <?php echo view('bendahara/aaside') ?>
   <main id="main" class="main">
      <div class="pagetitle">
         <h1>Pengajuan</h1>
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo base_url('') ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Laporan Pembayaran</li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-body">
                     <form class="row col-lg-2 g-3" method="post" action="<?php echo base_url('b/laporan/l/t') ?>" style="float: right;margin-top: 5px;">
                        <div class="col-md-8">
                           <select class="form-control" name="bulan" required onchange="this.form.submit()">
                              <?php for ($i=1; $i <= 12; $i++) {?>
                                 <option <?php if($bulan == $i){echo "selected";} ?> value="<?php echo $i ?>"><?php echo $daftarbulan[$i] ?></option>
                              <?php } ?>
                           </select>
                        </div>
                        <div class="col-md-4">
                           <select class="form-control" name="tahun" required onchange="this.form.submit()">
                              <?php for ($i=date('Y'); $i >= $daftartahun ; $i--) {?>
                                 <option <?php if($tahun == $i){echo "selected";} ?>><?php echo $i ?></option>
                              <?php } ?>
                           </select>
                        </div>
                     </form>
                     <h5 class="card-title">Detail Data Pembayaran</h5>
                     <table class="table datatable">
                        <thead>
                           <tr>
                              <th>*</th>
                              <th>Waktu</th>
                              <th>No. Pengajuan</th>
                              <th>Penerima</th>
                              <th>Uraian</th>
                              <th>Nominal</th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $n = 1;
                           foreach ($data as $d) {
                              $nomor = $db->query("select nomor from pengajuan where idpengajuan = '".$d['idpengajuan']."'")->getRowArray()['nomor'];
                              ?>
                              <tr>
                                 <td><?php echo $n++ ?></td>
                                 <td><?php echo date('d-m-Y H:i', strtotime($d['waktu'])) ?></td>
                                 <td><?php echo $nomor ?></td>
                                 <td><?php echo $d['penerima'] ?></td>
                                 <td><?php echo $d['jenis'].', '.$d['keterangan'] ?></td>
                                 <td><?php echo "Rp".number_format($d['jumlah']) ?></td>
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
   <?php echo view('bendahara/ascript') ?>
</body>
</html>