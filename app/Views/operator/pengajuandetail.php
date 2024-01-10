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
$nomor = $pengajuan['nomor'];
$nomor = explode("/", $nomor);
$data = array(
   'dasar' => $dasar,
   'utusan' => $utusan,
   'agenda' => $agenda,
   'keterangan' => $keterangan,
   'biaya' => $biaya,
   'pengikut' => $pengikut
);
$pegawai = $db->query("select * from pegawai where status = '1' order by nama asc")->getResultArray();
$indek = $db->query("select * from indek order by indek asc")->getResultArray();
$acc = $db->query("select ifnull(count(*),0) as jumlah from acc where idpengajuan = '".$pengajuan['idpengajuan']."'")->getRowArray()['jumlah'];
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
               <li class="breadcrumb-item"><a href="<?php echo base_url('o/pengajuan') ?>">Detail Data</a></li>
               <li class="breadcrumb-item active">Buat Baru</li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card info-card sales-card">
                  <form action="<?php echo base_url('o/pengajuan/u') ?>" method="post">
                     <input type="hidden" name="id" value="<?php echo $pengajuan['idpengajuan'] ?>">
                     <input type="hidden" name="nomor" value="<?php echo $nomor[1] ?>">
                     <div class="card-body">
                        <div class="filter" style="float: right;margin-top: 15px;">
                           <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-printer" style="font-size: 1.5em;"></i></a>
                           <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                              <li class="dropdown-header text-start">
                                 <h6>Cetak Berkas</h6>
                              </li>
                              <li><a class="dropdown-item" href="<?php echo base_url('cetak/1/'.$pengajuan['idpengajuan']) ?>" target="blank">Surat Pengajuan</a></li>
                              <?php if($acc > 0){ ?>
                                 <li><a class="dropdown-item" href="#" target="blank">Surat Pengantar</a></li>
                                 <li><a class="dropdown-item" href="#" target="blank">Surat Perintah</a></li>
                              <?php } ?>
                           </ul>
                        </div>
                        <h5 class="card-title">Detail Data Pengajuan</h5>
                        <?php if($pengajuan['status'] == '4' || $pengajuan['status'] == '5'){ ?>
                           <hr>
                           <div class="row">
                              <div class="col-lg-6">
                                 <div class="row">
                                    <div class="col-sm-3"><strong>Nomor</strong></div>
                                    <div class="col-sm-9">: <?php echo $pengajuan['nomor'] ?></div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-3"><strong>Tgl. Pengajuan</strong></div>
                                    <div class="col-sm-9">: <?php echo date('d-m-Y H:i:s', strtotime($pengajuan['waktu'])) ?></div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-3"><strong>Sumber Anggaran</strong></div>
                                    <div class="col-sm-9">: <?php echo $pengajuan['anggaran'] ?></div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-3"><strong>Status</strong></div>
                                    <div class="col-sm-9">:
                                       <?php
                                       if($pengajuan['status'] == '0'){
                                          echo "Proses Verifikasi Pimpinan";
                                       }else if($pengajuan['status'] == '1'){
                                          echo "Penyesuaian Pengajuan";
                                       }else if($pengajuan['status'] == '2'){
                                          echo "Proses Verifikasi Lembaga / Instansi";
                                       }else if($pengajuan['status'] == '3'){
                                          echo "Pengajuan Dibatalkan";
                                       }else if($pengajuan['status'] == '4'){
                                          echo "Verifikasi Selesai";
                                       }else{
                                          echo "Selesai";
                                       }
                                       ?>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-3"><strong>Angkutan</strong></div>
                                    <div class="col-sm-9">: <?php echo $pengajuan['angkutan'] ?></div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-3"><strong>Tujuan</strong></div>
                                    <div class="col-sm-9"> <?php echo $pengajuan['tujuan'] ?></div>
                                 </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="row">
                                    <div class="col-sm-3"><strong>Tembusan</strong></div>
                                    <div class="col-sm-9"><?php echo nl2br($pengajuan['tembusan']) ?></div>
                                 </div>
                                 <div class="row">
                                    <div class="col-sm-3"><strong>Keterangan</strong></div>
                                    <div class="col-sm-9"> <?php echo $pengajuan['keterangan'] ?></div>
                                 </div>
                              </div>
                           </div>
                        <?php }else{ ?>
                           <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Tambah Data</strong> untuk menambahkan detail data baru</p>
                           <hr>
                           <?php if($pengajuan['status'] == '1'){ ?>
                              <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                 <i class="bi bi-exclamation-octagon me-1"></i>
                                 <?php echo $pengajuan['catatan'] ?>
                              </div>
                           <?php } ?>
                           <div class="row mb-4">
                              <div class="col-sm-6">
                                 <textarea class="form-control" placeholder="Uraian Tujuan" name="tujuan" rows="3" style="resize: none;" required><?php echo $pengajuan['tujuan'] ?></textarea>
                              </div>
                              <div class="col-sm-6">
                                 <textarea class="form-control" placeholder="Uraian Angkutan" name="angkutan" rows="3" style="resize: none;" required><?php echo $pengajuan['angkutan'] ?></textarea>
                              </div>
                           </div>
                           <div class="row mb-4">
                              <div class="col-sm-6">
                                 <textarea class="form-control" placeholder="Sumber / Dasar Anggaran" name="anggaran" rows="3" style="resize: none;" required><?php echo $pengajuan['anggaran'] ?></textarea>
                              </div>
                              <div class="col-sm-6">
                                 <textarea class="form-control" placeholder="Keterangan" name="isi" rows="3" style="resize: none;" required><?php echo $pengajuan['keterangan'] ?></textarea>
                              </div>
                           </div>
                           <div class="row mb-4">
                              <div class="col-sm-6">
                                 <input type="text" class="form-control mb-2" value="<?php echo $nomor[0]."/".$nomor[1] ?>" disabled>
                                 <select class="form-control" name="indek" required>
                                    <option value="" selected>- Klasifikasi Pengajuan -</option>
                                    <?php foreach ($indek as $i) {?>
                                       <option <?php if($nomor[0] == $i['indek']){echo "selected";} ?> value="<?php echo $i['indek'] ?>"><?php echo $i['indek'].' - '.$i['tujuan'] ?></option>
                                    <?php } ?>
                                 </select>
                              </div>
                              <div class="col-sm-6">
                                 <textarea class="form-control" placeholder="Tembusan (pisahkan dengan ENTER)" name="tembusan" rows="3" style="resize: none;" required><?php echo $pengajuan['tembusan'] ?></textarea>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                     <div class="card-footer">
                        <a href="<?php echo base_url('o/pengajuan') ?>" class="btn btn-warning btn-sm"><i class="bi bi-arrow-return-left"></i> Kembali</a>
                        <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                           <?php if($pengajuan['status'] == '2'){ ?>
                              <a href="#verifikasi" data-bs-toggle="modal" class="btn btn-warning btn-sm" style="float: right;margin-right: 10px;"><i class="bi bi-check-circle"></i> Verifikasi</a>
                           <?php } ?>
                           <button type="submit" class="btn btn-primary btn-sm" style="float: right;margin-right: 10px;"><i class="bi bi-download"></i> Simpan Perubahan Data</button>
                        <?php } ?>
                     </div>
                  </form>
                  <div class="card-body">
                     <hr>
                     <ul class="nav nav-tabs d-flex" id="myTabjustified" role="tablist">
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100 <?php if($aktif == 'dasar'){echo "active";} ?>" id="home-tab" data-bs-toggle="tab" data-bs-target="#dasar-tab" type="button" role="tab" aria-controls="home" aria-selected="true">Dasar</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100 <?php if($aktif == 'utusan'){echo "active";} ?>" id="profile-tab" data-bs-toggle="tab" data-bs-target="#utusan-tab" type="button" role="tab" aria-controls="profile" aria-selected="false">Utusan</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100 <?php if($aktif == 'agenda'){echo "active";} ?>" id="contact-tab" data-bs-toggle="tab" data-bs-target="#agenda-tab" type="button" role="tab" aria-controls="contact" aria-selected="false">Agenda</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100 <?php if($aktif == 'keterangan'){echo "active";} ?>" id="contact-tab" data-bs-toggle="tab" data-bs-target="#keterangan-tab" type="button" role="tab" aria-controls="contact" aria-selected="false">Keterangan</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100 <?php if($aktif == 'pengikut'){echo "active";} ?>" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pengikut-tab" type="button" role="tab" aria-controls="contact" aria-selected="false">Pengikut</button>
                        </li>
                        <li class="nav-item flex-fill" role="presentation">
                           <button class="nav-link w-100 <?php if($aktif == 'biaya'){echo "active";} ?>" id="contact-tab" data-bs-toggle="tab" data-bs-target="#pembiayaan-tab" type="button" role="tab" aria-controls="contact" aria-selected="false">Pembiayaan</button>
                        </li>
                     </ul>
                     <div class="tab-content pt-2" id="myTabjustifiedContent">
                        <div class="tab-pane fade <?php if($aktif == 'dasar'){echo "show active";} ?>" id="dasar-tab" role="tabpanel" aria-labelledby="home-tab">
                           <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                              <a href="#tambahdasar" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                              <hr>
                           <?php } ?>
                           <ul class="list-group">
                              <?php foreach ($dasar as $d) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $d['dasar']?>
                                    <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                                       <?php if(count($dasar) > 1){ ?>
                                          <a href="<?php echo base_url('o/pengajuan/u/hd/'.$d['iddasar']) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                       <?php } ?>
                                    <?php } ?>
                                 </li>
                              <?php } ?>
                           </ul>
                        </div>
                        <div class="tab-pane fade <?php if($aktif == 'utusan'){echo "show active";} ?>" id="utusan-tab" role="tabpanel" aria-labelledby="profile-tab">
                           <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                              <a href="#tambahutusan" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                              <hr>
                           <?php } ?>
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
                                    <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                                       <?php if(count($utusan) > 1){ ?>
                                          <a href="<?php echo base_url('o/pengajuan/u/hu/'.$d['idutusan']) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                       <?php } ?>
                                    <?php } ?>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                        <div class="tab-pane fade <?php if($aktif == 'agenda'){echo "show active";} ?>" id="agenda-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                              <a href="#tambahagenda" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                              <hr>
                           <?php } ?>
                           <ol class="list-group list-group-numbered">
                              <?php foreach ($agenda as $d) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                       <div class="fw-bold"><?php echo tanggal_indo(date('Y-m-d', strtotime($d['waktu'])), true).', pukul '.date('H:i', strtotime($d['waktu'])).' WIB' ?></div>
                                       <?php echo $d['acara'] ?>
                                    </div>
                                    <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                                       <?php if(count($agenda) > 1){ ?>
                                          <a href="<?php echo base_url('o/pengajuan/u/ha/'.$d['idagenda']) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                       <?php } ?>
                                    <?php } ?>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                        <div class="tab-pane fade <?php if($aktif == 'keterangan'){echo "show active";} ?>" id="keterangan-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                              <a href="#tambahketerangan" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                              <hr>
                           <?php } ?>
                           <ul class="list-group">
                              <?php foreach ($keterangan as $d) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $d['keterangan'] ?>
                                    <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                                       <?php if(count($keterangan) > 1){ ?>
                                          <a href="<?php echo base_url('o/pengajuan/u/hk/'.$d['idketerangan']) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                       <?php } ?>
                                    <?php } ?>
                                 </li>
                              <?php } ?>
                           </ul>
                        </div>
                        <div class="tab-pane fade <?php if($aktif == 'pengikut'){echo "show active";} ?>" id="pengikut-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                              <a href="#tambahpengikut" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                              <hr>
                           <?php } ?>
                           <ol class="list-group list-group-numbered">
                              <?php foreach ($pengikut as $d) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                       <div class="fw-bold"><?php echo $d['nama'].' ['.date('d-m-Y', strtotime($d['tanggal'])).']' ?></div>
                                       <?php echo $d['keterangan'] ?>
                                    </div>
                                    <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                                       <?php if(count($pengikut) > 1){ ?>
                                          <a href="<?php echo base_url('o/pengajuan/u/hp/'.$d['idpengikut']) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                       <?php } ?>
                                    <?php } ?>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                        <div class="tab-pane fade <?php if($aktif == 'biaya'){echo "show active";} ?>" id="pembiayaan-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                              <a href="#tambahbiaya" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                              <hr>
                           <?php } ?>
                           <ol class="list-group list-group-numbered">
                              <?php foreach ($biaya as $d) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                       <div class="fw-bold"><?php echo $d['jenis'].' : Rp'.number_format($d['jumlah']) ?></div>
                                       <?php echo $d['rincian'] ?>
                                    </div>
                                    <?php if($pengajuan['status'] != '4' && $pengajuan['status'] != '5'){ ?>
                                       <?php if(count($biaya) > 1){ ?>
                                          <a href="<?php echo base_url('o/pengajuan/u/hb/'.$d['idbiaya']) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                       <?php } ?>
                                    <?php } ?>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </section>
   </main>
   <?php echo view('operator/ascript') ?>
</body>
<div class="modal fade" id="tambahdasar" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Tambah Informasi Dasar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form method="post" action="<?php echo base_url('o/pengajuan/u/td') ?>">
            <input type="hidden" name="id" value="<?php echo $pengajuan['idpengajuan'] ?>">
            <div class="modal-body">
               <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Tambah Data</strong> untuk menambahkan detail data baru</p>
               <hr>
               <div class="row mb-4">
                  <div class="col-sm-12">
                     <textarea class="form-control" placeholder="Dasar Pengajuan" name="isi" rows="5" style="resize: none;" required></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
               <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Tambah Data</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="tambahutusan" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Tambah Informasi Utusan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form method="post" action="<?php echo base_url('o/pengajuan/u/tu') ?>">
            <input type="hidden" name="id" value="<?php echo $pengajuan['idpengajuan'] ?>">
            <div class="modal-body">
               <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Tambah Data</strong> untuk menambahkan detail data baru</p>
               <hr>
               <div class="row mb-4">
                  <div class="col-sm-12">
                     <select class="form-control" name="pegawai" required>
                        <?php foreach ($pegawai as $p) {?>
                           <option value="<?php echo $p['idpegawai'] ?>"><?php echo $p['nip'].' '.$p['nama'] ?></option>
                        <?php } ?>
                     </select>
                  </div>
               </div>
               <div class="row mb-4">
                  <div class="col-sm-12">
                     <input type="text" name="isi" placeholder="Keterangan" class="form-control" maxlength="36" required>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
               <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Tambah Data</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="tambahagenda" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Tambah Informasi Agenda</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form method="post" action="<?php echo base_url('o/pengajuan/u/ta') ?>">
            <input type="hidden" name="id" value="<?php echo $pengajuan['idpengajuan'] ?>">
            <div class="modal-body">
               <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Tambah Data</strong> untuk menambahkan detail data baru</p>
               <hr>
               <div class="row mb-4">
                  <div class="col-sm-6">
                     <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                  </div>
                  <div class="col-sm-6">
                     <input type="time" name="jam" class="form-control" value="<?php echo date('H:i') ?>" required>
                  </div>
               </div>
               <div class="row mb-4">
                  <div class="col-sm-12">
                     <textarea class="form-control" placeholder="Uraian Acara" name="acara" rows="2" style="resize: none;" required></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
               <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Tambah Data</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="tambahketerangan" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Tambah Informasi Dasar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form method="post" action="<?php echo base_url('o/pengajuan/u/tk') ?>">
            <input type="hidden" name="id" value="<?php echo $pengajuan['idpengajuan'] ?>">
            <div class="modal-body">
               <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Tambah Data</strong> untuk menambahkan detail data baru</p>
               <hr>
               <div class="row mb-4">
                  <div class="col-sm-12">
                     <textarea class="form-control" placeholder="Keterangan Tambahan" name="isi" rows="5" style="resize: none;" required></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
               <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Tambah Data</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="tambahpengikut" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Tambah Informasi Dasar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form method="post" action="<?php echo base_url('o/pengajuan/u/tp') ?>">
            <input type="hidden" name="id" value="<?php echo $pengajuan['idpengajuan'] ?>">
            <div class="modal-body">
               <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Tambah Data</strong> untuk menambahkan detail data baru</p>
               <hr>
               <div class="row mb-4">
                  <div class="col-sm-8">
                     <input type="text" name="nama" class="form-control" placeholder="Nama Pengikut" required>
                  </div>
                  <div class="col-sm-4">
                     <input type="date" name="tanggal" class="form-control" value="<?php echo date('Y-m-d') ?>" required>
                  </div>
               </div>
               <div class="row mb-4">
                  <div class="col-sm-12">
                     <textarea class="form-control" placeholder="Keterangan" name="isi" rows="5" style="resize: none;" required></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
               <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Tambah Data</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="tambahbiaya" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Tambah Informasi Dasar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form method="post" action="<?php echo base_url('o/pengajuan/u/tb') ?>">
            <input type="hidden" name="id" value="<?php echo $pengajuan['idpengajuan'] ?>">
            <div class="modal-body">
               <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Tambah Data</strong> untuk menambahkan detail data baru</p>
               <hr>
               <div class="row mb-4">
                  <div class="col-sm-8">
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
                     <input type="number" name="jumlah" class="form-control" placeholder="Jumlah / Nominal" min="1000" value="1000" required>
                  </div>
               </div>
               <div class="row mb-4">
                  <div class="col-sm-12">
                     <textarea class="form-control" placeholder="Keterangan" name="isi" rows="5" style="resize: none;" required></textarea>
                  </div>
               </div>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
               <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Tambah Data</button>
            </div>
         </form>
      </div>
   </div>
</div>
<div class="modal fade" id="verifikasi" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Verifikasi Data Pengajuan</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <div class="modal-body">
            <p style="text-align: justify;">
               <strong><code>PENTING!!!</code></strong><br>
               Pastikan bahwa data pengajuan sudah di setujui oleh pihak Instansi atau Lembaga yang bersangkutan sebelum menggunakan fitur ini. Data yang telah diverifikasi tidak dapat diubah kembali. pilih tombol <strong>Verifikasi Data</strong> untuk menyimpan verifikasi data pengajuan
            </p>
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
            <a href="<?php echo base_url('o/pengajuan/acc/'.$pengajuan['idpengajuan']) ?>" class="btn btn-primary btn-sm"><i class="bi bi-check-circle"></i> Verifikasi Data</a>
         </div>
      </div>
   </div>
</div>
</html>