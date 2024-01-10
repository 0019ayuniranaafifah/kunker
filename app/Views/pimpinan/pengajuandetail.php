<?php
$db = db_connect();
date_default_timezone_set('Asia/Jakarta');
function tanggal_indo($tanggal, $cetak_hari = false){
   $hari = array ( 1 => 'Senin','Selasa','Rabu','Kamis','Jumat','Sabtu','Minggu');
   $bulan = array (1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
   $split     = explode('-', $tanggal);
   $tgl_indo = $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
   if ($cetak_hari) {
      $num = date('N', strtotime($tanggal));
      return $hari[$num] . ', ' . $tgl_indo;
   }
   return $tgl_indo;
}
$pegawai = $db->query("select * from pegawai where status = '1'")->getResultArray();
?>
<!DOCTYPE html>
<html lang="en">
<?php echo view('pimpinan/ahead') ?>
<body>
   <?php echo view('pimpinan/aheader') ?>
   <?php echo view('pimpinan/aaside') ?>
   <main id="main" class="main">
      <div class="pagetitle">
         <h1>Pengajuan</h1>
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo base_url('') ?>">Dashboard</a></li>
               <li class="breadcrumb-item"><a href="<?php echo base_url('p/verifikasi') ?>">Verifikasi Pengajuan</a></li>
               <li class="breadcrumb-item active">Detail Data Pengajuan <?php echo $data['nomor'] ?></li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card info-card sales-card">
                  <div class="card-body">
                     <h5 class="card-title">Detail Data Pengajuan</h5>
                     <hr>
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="row">
                              <div class="col-sm-3"><strong>Nomor</strong></div>
                              <div class="col-sm-9">: <?php echo $data['nomor'] ?></div>
                           </div>
                           <div class="row">
                              <div class="col-sm-3"><strong>Tgl. Pengajuan</strong></div>
                              <div class="col-sm-9">: <?php echo date('d-m-Y H:i:s', strtotime($data['waktu'])) ?></div>
                           </div>
                           <div class="row">
                              <div class="col-sm-3"><strong>Sumber Anggaran</strong></div>
                              <div class="col-sm-9">: <?php echo $data['anggaran'] ?></div>
                           </div>
                           <div class="row">
                              <div class="col-sm-3"><strong>Status</strong></div>
                              <div class="col-sm-9">:
                                 <?php
                                 if($data['status'] == '0'){
                                    echo "Proses Verifikasi Pimpinan";
                                 }else if($data['status'] == '1'){
                                    echo "Penyesuaian Pengajuan";
                                 }else if($data['status'] == '2'){
                                    echo "Proses Verifikasi Lembaga / Instansi";
                                 }else if($data['status'] == '3'){
                                    echo "Pengajuan Dibatalkan";
                                 }else if($data['status'] == '4'){
                                    echo "Verifikasi Selesai";
                                 }else{
                                    echo "Selesai";
                                 }
                                 ?>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-sm-3"><strong>Angkutan</strong></div>
                              <div class="col-sm-9">: <?php echo $data['angkutan'] ?></div>
                           </div>
                           <div class="row">
                              <div class="col-sm-3"><strong>Tujuan</strong></div>
                              <div class="col-sm-9"> <?php echo $data['tujuan'] ?></div>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="row">
                              <div class="col-sm-3"><strong>Tembusan</strong></div>
                              <div class="col-sm-9"><?php echo nl2br($data['tembusan']) ?></div>
                           </div>
                           <div class="row">
                              <div class="col-sm-3"><strong>Keterangan</strong></div>
                              <div class="col-sm-9"> <?php echo $data['keterangan'] ?></div>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="card-body">
                     <hr>
                     <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100 active" id="home-tab" data-bs-toggle="tab" data-bs-target="#dasar-tab" type="button" role="tab" aria-controls="home" aria-selected="true">Dasar</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100" id="profile-tab" data-bs-toggle="tab" data-bs-target="#utusan-tab" type="button" role="tab" aria-controls="profile" aria-selected="false">Utusan</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#agenda-tab" type="button" role="tab" aria-controls="contact" aria-selected="false">Agenda</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#keterangan-tab" type="button" role="tab" aria-controls="contact" aria-selected="false">Keterangan</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pengikut-tab" type="button" role="tab" aria-controls="contact" aria-selected="false">Pengikut</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pembiayaan-tab" type="button" role="tab" aria-controls="contact" aria-selected="false">Pembiayaan</button>
                        </li>
                     </ul>
                     <div class="tab-content pt-2" id="myTabjustifiedContent">
                        <div class="tab-pane fade show active" id="dasar-tab" role="tabpanel" aria-labelledby="home-tab">
                           <ul class="list-group">
                              <?php foreach ($dasar as $d) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $d['dasar']?>
                                 </li>
                              <?php } ?>
                           </ul>
                        </div>
                        <div class="tab-pane fade" id="utusan-tab" role="tabpanel" aria-labelledby="profile-tab">
                           <ol class="list-group list-group-numbered">
                              <?php
                              foreach ($utusan as $d) {
                                 $x = $db->query("select nama from pegawai where idpegawai = '".$d['idpegawai']."'")->getRowArray()['nama'];
                                 ?>
                                 <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                       <div class="fw-bold"><?php echo $x ?></div>
                                       [<?php echo $d['jabatan'] ?>] : <?php echo $d['keterangan'] ?>
                                    </div>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                        <div class="tab-pane fade" id="agenda-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <ol class="list-group list-group-numbered">
                              <?php foreach ($agenda as $d) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                       <div class="fw-bold"><?php echo tanggal_indo(date('Y-m-d', strtotime($d['waktu'])), true).', pukul '.date('H:i', strtotime($d['waktu'])).' WIB' ?></div>
                                       <?php echo $d['acara'] ?>
                                    </div>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                        <div class="tab-pane fade" id="keterangan-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <ul class="list-group">
                              <?php foreach ($keterangan as $d) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $d['keterangan'] ?>
                                 </li>
                              <?php } ?>
                           </ul>
                        </div>
                        <div class="tab-pane fade" id="pengikut-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <ol class="list-group list-group-numbered">
                              <?php foreach ($pengikut as $d) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                       <div class="fw-bold"><?php echo $d['nama'].' ['.date('d-m-Y', strtotime($d['tanggal'])).']' ?></div>
                                       <?php echo $d['keterangan'] ?>
                                    </div>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                        <div class="tab-pane fade" id="pembiayaan-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <ol class="list-group list-group-numbered">
                              <?php foreach ($biaya as $d) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                       <div class="fw-bold"><?php echo $d['jenis'].' : Rp'.number_format($d['jumlah']) ?></div>
                                       <?php echo $d['rincian'] ?>
                                    </div>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                     </div>
                  </div>
                  <div class="card-footer">
                     <a href="<?php echo base_url('p/verifikasi') ?>" class="btn btn-warning btn-sm"><i class="bi bi-arrow-return-left"></i> Kembali</a>
                     <?php if($data['status'] == '0'){ ?>
                        <a href="#tolak" data-bs-toggle="modal" class="btn btn-warning btn-sm" style="float: right;margin-right: 10pt;"><i class="bi bi-x-octagon"></i> Tolak Pengajuan</a>
                        <a href="#terima" data-bs-toggle="modal" class="btn btn-success btn-sm" style="float: right;margin-right: 10pt;"><i class="bi bi-check-circle"></i> Terima Pengajuan</a>
                     <?php } ?>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </main>
   <?php echo view('pimpinan/ascript') ?>
</body>
<div class="modal fade" id="tolak" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Catatan Verifikasi Pengajuan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form action="<?php echo base_url('p/verifikasi/ts') ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $data['idpengajuan'] ?>">
            <div class="modal-body">
               <div class="col-sm-12">
                  <textarea class="form-control" placeholder="Catatan Penyesuaian / Verifikasi Penolakan" name="catatan" rows="5" style="resize: none;" required></textarea>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
               <button type="submit" class="btn btn-warning btn-sm"><i class="bi bi-x-octagon"></i> Tolak Pengajuan</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="terima" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Pilih Verifikator</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form action="<?php echo base_url('p/verifikasi/s') ?>" method="post">
            <input type="hidden" name="id" value="<?php echo $data['idpengajuan'] ?>">
            <div class="modal-body">
               <div class="col-sm-12">
                  <select class="form-control" name="pegawai" required>
                     <?php foreach ($pegawai as $p) {?>
                        <option value="<?php echo $p['idpegawai'] ?>"><?php echo $p['nip'].' - '.$p['nama'] ?></option>
                     <?php } ?>
                  </select>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
               <button type="submit" class="btn btn-success btn-sm"><i class="bi bi-check-circle"></i> Terima Pengajuan</button>
            </div>
         </form>
      </div>
   </div>
</div>
</html>