<?php
$db = db_connect();
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
                     <p>pilih tombol <strong><i class="bi bi-pencil-square"></i></strong> untuk menampilkan detail data. pilih tombol <strong><i class="bi bi-download"></i></strong> untuk menambahkan pembayaran baru</p>
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
                              $t = $db->query("select sum(jumlah) as total from biaya where idpengajuan = '".$d['idpengajuan']."'")->getRowArray()['total'];
                              $b = $db->query("select sum(jumlah) as total from bayar where idpengajuan = '".$d['idpengajuan']."'")->getRowArray()['total'];
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
                                    <a href="#detail<?php echo $d['idpengajuan'] ?>" data-bs-toggle="modal"><i class="bi bi-pencil-square" style="font-size: 1.2em;"></i></a>
                                    <?php if($t != $b){ ?>
                                       &nbsp;
                                       <a href="#bayar<?php echo $d['idpengajuan'] ?>" data-bs-toggle="modal"><i class="bi bi-download" style="font-size: 1.2em;"></i></a>
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
   <?php echo view('bendahara/ascript') ?>
</body>
<?php
foreach ($data as $d) {
   $t = $db->query("select sum(jumlah) as total from biaya where idpengajuan = '".$d['idpengajuan']."'")->getRowArray()['total'];
   $b = $db->query("select sum(jumlah) as total from bayar where idpengajuan = '".$d['idpengajuan']."'")->getRowArray()['total'];
   $sisa = $t-$b;
   $biaya = $db->query("select * from biaya where idpengajuan = '".$d['idpengajuan']."'")->getResultArray();
   $bayar = $db->query("select * from bayar where idpengajuan = '".$d['idpengajuan']."' order by waktu asc")->getResultArray();
   $total = $db->query("select sum(jumlah) as total from biaya where idpengajuan = '".$d['idpengajuan']."'")->getRowArray()['total'];
   ?>
   <div class="modal fade" id="detail<?php echo $d['idpengajuan'] ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Detail Pembiayaan</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <div class="row">
                  <div class="col-sm-3"><strong>Nomor</strong></div>
                  <div class="col-sm-9">: <?php echo $d['nomor'] ?></div>
               </div>
               <div class="row">
                  <div class="col-sm-3"><strong>Tgl. Pengajuan</strong></div>
                  <div class="col-sm-9">: <?php echo date('d-m-Y H:i:s', strtotime($d['waktu'])) ?></div>
               </div>
               <div class="row">
                  <div class="col-sm-3"><strong>Sumber Anggaran</strong></div>
                  <div class="col-sm-9">: <?php echo $d['anggaran'] ?></div>
               </div>
               <div class="row">
                  <div class="col-sm-3"><strong>Status</strong></div>
                  <div class="col-sm-9">:
                     <?php
                     if($d['status'] == '0'){
                        echo "Proses Verifikasi Pimpinan";
                     }else if($d['status'] == '1'){
                        echo "Penyesuaian Pengajuan";
                     }else if($d['status'] == '2'){
                        echo "Proses Verifikasi Lembaga / Instansi";
                     }else if($d['status'] == '3'){
                        echo "Pengajuan Dibatalkan";
                     }else if($d['status'] == '4'){
                        echo "Verifikasi Selesai";
                     }else{
                        echo "Selesai";
                     }
                     ?>
                  </div>
               </div>
               <hr>
               <?php foreach ($biaya as $b) {?>
                  <div class="row">
                     <div class="col-sm-2"><strong><?php echo $b['jenis'] ?></strong></div>
                     <div class="col-sm-8">: <?php echo $b['rincian'] ?></div>
                     <div class="col-sm-2" style="text-align: right;"><?php echo "Rp".number_format($b['jumlah']) ?></div>
                  </div>
               <?php } ?>
               <hr>
               <h6 style="font-weight: bold;">Detail Pembayaran</h6>
               <?php foreach ($bayar as $b) {?>
                  <div class="row">
                     <div class="col-sm-2"><strong><?php echo $b['jenis'] ?></strong></div>
                     <div class="col-sm-8">: [<?php echo date('d-m-Y H:i', strtotime($b['waktu'])) ?>] <?php echo $b['penerima'].', '.$b['keterangan'] ?></div>
                     <div class="col-sm-2" style="text-align: right;"><?php echo "Rp".number_format($b['jumlah']) ?></div>
                  </div>
               <?php } ?>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">OK</button>
            </div>
         </div>
      </div>
   </div>
   <div class="modal fade" id="bayar<?php echo $d['idpengajuan'] ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered modal-lg">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Tambah Pembayaran Baru</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?php echo base_url('b/pengajuan/b') ?>" method="post">
               <input type="hidden" name="id" value="<?php echo $d['idpengajuan'] ?>">
               <div class="modal-body">
                  <div class="row mb-4">
                     <label for="inputText" class="col-sm-3 col-form-label">Jenis - Jumlah</label>
                     <div class="col-sm-5">
                        <select class="form-control" name="jenis" required>
                           <option>Akomodasi</option>
                           <option>Komunikasi</option>
                           <option>Makan dan Minum</option>
                           <option>Transportasi</option>
                           <option>Transportasi Lokal</option>
                           <option>Lain-Lain</option>
                        </select>
                     </div>
                     <div class="col-sm-4">
                        <input type="number" class="form-control" placeholder="Nominal" name="jumlah" min="10000" max="<?php echo $sisa ?>" value="<?php echo $sisa ?>" required>
                     </div>
                  </div>
                  <div class="row mb-4">
                     <label for="inputText" class="col-sm-3 col-form-label">Penerima</label>
                     <div class="col-sm-9">
                        <input type="text" class="form-control" placeholder="Penerima" name="penerima" maxlength="63" required>
                     </div>
                  </div>
                  <div class="row mb-4">
                     <label for="inputText" class="col-sm-3 col-form-label">Keterangan</label>
                     <div class="col-sm-9">
                        <textarea class="form-control" name="keterangan" placeholder="Keterangan Pembayaran" rows="3" style="resize: none;" required></textarea>
                     </div>
                  </div>
               </div>
               <div class="modal-footer">
                  <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
                  <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Simpan Data</button>
               </div>
            </form>
         </div>
      </div>
   </div>
<?php } ?>
</html>