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
$nomor = 1;
$cek = $db->query("select ifnull(count(*),0) as jumlah from pengajuan")->getRowArray()['jumlah'];
if($cek > 0){
   $nomor = $db->query("select ifnull(count(*),0) as jumlah from pengajuan")->getRowArray()['jumlah'];
   $nomor++;
}
if($nomor < 10){
   $nomor = "00".$nomor;
}else if($nomor < 100){
   $nomor = "0".$nomor;
}
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
               <li class="breadcrumb-item active">Buat Baru</li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-body">
                     <h5 class="card-title">Buat Pengajuan Baru</h5>
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
                           <a href="#tambahdasar" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                           <hr>
                           <ul class="list-group">
                              <?php for ($i=0; $i < count($dasar) ; $i++) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $dasar[$i] ?>
                                    <a href="<?php echo base_url('o/pengajuan/b/hd/'.base64_encode(serialize($data)).'/'.$i) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                 </li>
                              <?php } ?>
                           </ul>
                        </div>
                        <div class="tab-pane fade <?php if($aktif == 'utusan'){echo "show active";} ?>" id="utusan-tab" role="tabpanel" aria-labelledby="profile-tab">
                           <a href="#tambahutusan" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                           <hr>
                           <ol class="list-group list-group-numbered">
                              <?php
                              for ($i=0; $i < count($utusan) ; $i++) {
                                 $x = $db->query("select nama from pegawai where idpegawai = '".$utusan[$i]['pegawai']."'")->getRowArray()['nama'];
                                 ?>
                                 <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                       <div class="fw-bold"><?php echo $x ?></div>
                                       [<?php echo $utusan[$i]['jabatan'] ?>] : <?php echo $utusan[$i]['keterangan'] ?>
                                    </div>
                                    <a href="<?php echo base_url('o/pengajuan/b/hu/'.base64_encode(serialize($data)).'/'.$i) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                        <div class="tab-pane fade <?php if($aktif == 'agenda'){echo "show active";} ?>" id="agenda-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <a href="#tambahagenda" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                           <hr>
                           <ol class="list-group list-group-numbered">
                              <?php for ($i=0; $i < count($agenda) ; $i++) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                       <div class="fw-bold"><?php echo tanggal_indo(date('Y-m-d', strtotime($agenda[$i]['waktu'])), true).', pukul '.date('H:i', strtotime($agenda[$i]['waktu'])).' WIB' ?></div>
                                       <?php echo $agenda[$i]['acara'] ?>
                                    </div>
                                    <a href="<?php echo base_url('o/pengajuan/b/ha/'.base64_encode(serialize($data)).'/'.$i) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                        <div class="tab-pane fade <?php if($aktif == 'keterangan'){echo "show active";} ?>" id="keterangan-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <a href="#tambahketerangan" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                           <hr>
                           <ul class="list-group">
                              <?php for ($i=0; $i < count($keterangan) ; $i++) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-center">
                                    <?php echo $keterangan[$i] ?>
                                    <a href="<?php echo base_url('o/pengajuan/b/hk/'.base64_encode(serialize($data)).'/'.$i) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                 </li>
                              <?php } ?>
                           </ul>
                        </div>
                        <div class="tab-pane fade <?php if($aktif == 'pengikut'){echo "show active";} ?>" id="pengikut-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <a href="#tambahpengikut" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                           <hr>
                           <ol class="list-group list-group-numbered">
                              <?php for ($i=0; $i < count($pengikut) ; $i++) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                       <div class="fw-bold"><?php echo $pengikut[$i]['nama'].' ['.date('d-m-Y', strtotime($pengikut[$i]['tanggal'])).']' ?></div>
                                       <?php echo $pengikut[$i]['keterangan'] ?>
                                    </div>
                                    <a href="<?php echo base_url('o/pengajuan/b/hp/'.base64_encode(serialize($data)).'/'.$i) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                        <div class="tab-pane fade <?php if($aktif == 'biaya'){echo "show active";} ?>" id="pembiayaan-tab" role="tabpanel" aria-labelledby="contact-tab">
                           <a href="#tambahbiaya" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                           <hr>
                           <ol class="list-group list-group-numbered">
                              <?php for ($i=0; $i < count($biaya) ; $i++) {?>
                                 <li class="list-group-item d-flex justify-content-between align-items-start">
                                    <div class="ms-2 me-auto">
                                       <div class="fw-bold"><?php echo $biaya[$i]['jenis'].' : Rp'.number_format($biaya[$i]['jumlah']) ?></div>
                                       <?php echo $biaya[$i]['rincian'] ?>
                                    </div>
                                    <a href="<?php echo base_url('o/pengajuan/b/hb/'.base64_encode(serialize($data)).'/'.$i) ?>" title="Klik untuk menghapus detail data"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
                                 </li>
                              <?php } ?>
                           </ol>
                        </div>
                     </div>
                  </div>
                  <?php if(count($dasar) > 0 && count($utusan) > 0 && count($agenda) > 0 && count($keterangan) > 0 && count($biaya) > 0){ ?>
                     <div class="card-footer">
                        <a href="#simpan" data-bs-toggle="modal" class="btn btn-primary btn-sm" style="float: right;"><i class="bi bi-check"></i> Proses Pengajuan</a>
                     </div>
                  <?php } ?>
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
         <form method="post" action="<?php echo base_url('o/pengajuan/b/td') ?>">
            <input type="hidden" name="dasar" value="<?php echo htmlspecialchars(serialize($dasar)) ?>">
            <input type="hidden" name="utusan" value="<?php echo htmlspecialchars(serialize($utusan)) ?>">
            <input type="hidden" name="agenda" value="<?php echo htmlspecialchars(serialize($agenda)) ?>">
            <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars(serialize($keterangan)) ?>">
            <input type="hidden" name="biaya" value="<?php echo htmlspecialchars(serialize($biaya)) ?>">
            <input type="hidden" name="pengikut" value="<?php echo htmlspecialchars(serialize($pengikut)) ?>">
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
         <form method="post" action="<?php echo base_url('o/pengajuan/b/tu') ?>">
            <input type="hidden" name="dasar" value="<?php echo htmlspecialchars(serialize($dasar)) ?>">
            <input type="hidden" name="utusan" value="<?php echo htmlspecialchars(serialize($utusan)) ?>">
            <input type="hidden" name="agenda" value="<?php echo htmlspecialchars(serialize($agenda)) ?>">
            <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars(serialize($keterangan)) ?>">
            <input type="hidden" name="biaya" value="<?php echo htmlspecialchars(serialize($biaya)) ?>">
            <input type="hidden" name="pengikut" value="<?php echo htmlspecialchars(serialize($pengikut)) ?>">
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
         <form method="post" action="<?php echo base_url('o/pengajuan/b/ta') ?>">
            <input type="hidden" name="dasar" value="<?php echo htmlspecialchars(serialize($dasar)) ?>">
            <input type="hidden" name="utusan" value="<?php echo htmlspecialchars(serialize($utusan)) ?>">
            <input type="hidden" name="agenda" value="<?php echo htmlspecialchars(serialize($agenda)) ?>">
            <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars(serialize($keterangan)) ?>">
            <input type="hidden" name="biaya" value="<?php echo htmlspecialchars(serialize($biaya)) ?>">
            <input type="hidden" name="pengikut" value="<?php echo htmlspecialchars(serialize($pengikut)) ?>">
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
         <form method="post" action="<?php echo base_url('o/pengajuan/b/tk') ?>">
            <input type="hidden" name="dasar" value="<?php echo htmlspecialchars(serialize($dasar)) ?>">
            <input type="hidden" name="utusan" value="<?php echo htmlspecialchars(serialize($utusan)) ?>">
            <input type="hidden" name="agenda" value="<?php echo htmlspecialchars(serialize($agenda)) ?>">
            <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars(serialize($keterangan)) ?>">
            <input type="hidden" name="biaya" value="<?php echo htmlspecialchars(serialize($biaya)) ?>">
            <input type="hidden" name="pengikut" value="<?php echo htmlspecialchars(serialize($pengikut)) ?>">
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
         <form method="post" action="<?php echo base_url('o/pengajuan/b/tp') ?>">
            <input type="hidden" name="dasar" value="<?php echo htmlspecialchars(serialize($dasar)) ?>">
            <input type="hidden" name="utusan" value="<?php echo htmlspecialchars(serialize($utusan)) ?>">
            <input type="hidden" name="agenda" value="<?php echo htmlspecialchars(serialize($agenda)) ?>">
            <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars(serialize($keterangan)) ?>">
            <input type="hidden" name="biaya" value="<?php echo htmlspecialchars(serialize($biaya)) ?>">
            <input type="hidden" name="pengikut" value="<?php echo htmlspecialchars(serialize($pengikut)) ?>">
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
         <form method="post" action="<?php echo base_url('o/pengajuan/b/tb') ?>">
            <input type="hidden" name="dasar" value="<?php echo htmlspecialchars(serialize($dasar)) ?>">
            <input type="hidden" name="utusan" value="<?php echo htmlspecialchars(serialize($utusan)) ?>">
            <input type="hidden" name="agenda" value="<?php echo htmlspecialchars(serialize($agenda)) ?>">
            <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars(serialize($keterangan)) ?>">
            <input type="hidden" name="biaya" value="<?php echo htmlspecialchars(serialize($biaya)) ?>">
            <input type="hidden" name="pengikut" value="<?php echo htmlspecialchars(serialize($pengikut)) ?>">
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
<div class="modal fade" id="simpan" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Tambah Informasi Dasar</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form method="post" action="<?php echo base_url('o/pengajuan/s') ?>">
            <input type="hidden" name="nomor" value="<?php echo $nomor ?>">
            <input type="hidden" name="dasar" value="<?php echo htmlspecialchars(serialize($dasar)) ?>">
            <input type="hidden" name="utusan" value="<?php echo htmlspecialchars(serialize($utusan)) ?>">
            <input type="hidden" name="agenda" value="<?php echo htmlspecialchars(serialize($agenda)) ?>">
            <input type="hidden" name="keterangan" value="<?php echo htmlspecialchars(serialize($keterangan)) ?>">
            <input type="hidden" name="biaya" value="<?php echo htmlspecialchars(serialize($biaya)) ?>">
            <input type="hidden" name="pengikut" value="<?php echo htmlspecialchars(serialize($pengikut)) ?>">
            <div class="modal-body">
               <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Tambah Data</strong> untuk menambahkan detail data baru</p>
               <hr>
               <div class="row mb-4">
                  <div class="col-sm-6">
                     <textarea class="form-control" placeholder="Uraian Tujuan" name="tujuan" rows="3" style="resize: none;" required></textarea>
                  </div>
                  <div class="col-sm-6">
                     <textarea class="form-control" placeholder="Uraian Angkutan" name="angkutan" rows="3" style="resize: none;" required></textarea>
                  </div>
               </div>
               <div class="row mb-4">
                  <div class="col-sm-6">
                     <textarea class="form-control" placeholder="Sumber / Dasar Anggaran" name="anggaran" rows="3" style="resize: none;" required></textarea>
                  </div>
                  <div class="col-sm-6">
                     <textarea class="form-control" placeholder="Keterangan" name="isi" rows="3" style="resize: none;" required></textarea>
                  </div>
               </div>
               <div class="row mb-4">
                  <div class="col-sm-6">
                     <input type="text" class="form-control mb-2" value="<?php echo $nomor ?>" disabled>
                     <select class="form-control" name="indek" required>
                        <option value="" selected>- Klasifikasi Pengajuan -</option>
                        <?php foreach ($indek as $i) {?>
                           <option value="<?php echo $i['indek'] ?>"><?php echo $i['indek'].' - '.$i['tujuan'] ?></option>
                        <?php } ?>
                     </select>
                  </div>
                  <div class="col-sm-6">
                     <textarea class="form-control" placeholder="Tembusan (pisahkan dengan ENTER)" name="tembusan" rows="3" style="resize: none;" required></textarea>
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
</html>