<?php
$db = db_connect();
$daftarbulan = [1 => 'Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'];
$daftartahun = date('Y');
$cek = $db->query("select ifnull(count(*),0) as jumlah from pengajuan")->getRowArray()['jumlah'];
if($cek > 0){
   $daftartahun = $db->query("select year(waktu) as tahun from pengajuan order by waktu asc limit 1")->getRowArray()['tahun'];
}
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
                     <form class="row col-lg-2 g-3" method="post" action="<?php echo base_url('o/laporan/l/t') ?>" style="float: right;margin-top: 5px;">
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
                     <h5 class="card-title">Detail Data Pengajuan</h5>
                     <p>pilih tombol <strong><i class="bi bi-journal-bookmark"></i></strong> untuk membuat laporan agenda kegiatan</p>
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
                              $ag = $db->query("select * from agenda where idpengajuan = '".$d['idpengajuan']."' order by waktu asc")->getResultArray();
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
                                    <a class="icon" href="#" data-bs-toggle="dropdown" title="Klik untuk membuat laporan agenda"><i class="bi bi-journal-bookmark" style="font-size: 1.5em;"></i></a>
                                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                                       <li class="dropdown-header text-start">
                                          <h6>Pilih Agenda</h6>
                                       </li>
                                       <?php
                                       foreach ($ag as $a) {
                                          $cek = $db->query("select ifnull(count(*),0) as jumlah from laporan where idagenda = '".$a['idagenda']."'")->getRowArray()['jumlah'];
                                          ?>
                                          <li>
                                             <?php if($cek == 0){ ?>
                                                <a class="dropdown-item" href="#laporan<?php echo $a['idagenda'] ?>" data-bs-toggle="modal"><?php echo date('d-m-Y', strtotime($a['waktu'])) ?></a>
                                             <?php }else{ ?>
                                                <a class="dropdown-item" href="<?php echo base_url('o/laporan/l/c/'.$a['idagenda']) ?>" target="blank"><?php echo date('d-m-Y', strtotime($a['waktu'])) ?></a>
                                             <?php } ?>
                                          </li>
                                       <?php } ?>
                                    </ul>
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
<?php
foreach ($data as $d) {
   $agenda = $db->query("select * from agenda where idpengajuan = '".$d['idpengajuan']."'")->getResultArray();
   foreach ($agenda as $a) {
      ?>
      <div class="modal fade" id="laporan<?php echo $a['idagenda'] ?>" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Buat Laporan Agenda Kegiatan</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
               </div>
               <form action="<?php echo base_url('o/laporan/l/s') ?>" method="post">
                  <input type="hidden" name="id" value="<?php echo $a['idagenda'] ?>">
                  <div class="modal-body">
                     <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Simpan Data</strong> untuk menyimpan inputan data baru</p>
                     <div class="row">
                        <div class="col-lg-4">
                           <div class="row">
                              <div class="col-sm-3"><strong>Tanggal</strong></div>
                              <div class="col-sm-9">: <?php echo date('d-m-Y', strtotime($a['waktu'])) ?></div>
                           </div>
                           <div class="row">
                              <div class="col-sm-3"><strong>Jam</strong></div>
                              <div class="col-sm-9">: <?php echo date('H:i', strtotime($a['waktu'])) ?> WIB</div>
                           </div>
                        </div>
                        <div class="col-lg-8">
                           <div class="row">
                              <div class="col-sm-12"><?php echo $a['acara'] ?></div>
                           </div>
                        </div>
                     </div>
                     <hr>
                     <div class="row">
                        <div class="col-lg-6">
                           <div class="row mb-2">
                              <div class="col-12">
                                 <label class="form-label">Instansi / Lembaga</label>
                                 <input type="text" class="form-control" name="klien" placeholder="Nama Instansi / Lembaga" maxlength="63" required>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-12">
                                 <label class="form-label">Alamat Lokasi</label>
                                 <textarea class="form-control" name="lokasi" placeholder="Alamat Lokasi" rows="3" style="resize: none;" required></textarea>
                              </div>
                           </div>
                           <div class="row mb-2">
                              <div class="col-12">
                                 <label class="form-label">PIC</label>
                                 <input type="text" class="form-control" name="pic" placeholder="Penanggung Jawab" maxlength="63" required>
                              </div>
                           </div>
                           <div class="row mb-2">
                              <div class="col-12">
                                 <label class="form-label">ID PIC (jika ada)</label>
                                 <input type="text" class="form-control" name="idpic" placeholder="ID Penanggung Jawab" maxlength="21">
                              </div>
                           </div>
                           <div class="row mb-2">
                              <div class="col-12">
                                 <label class="form-label">Jabatan PIC</label>
                                 <input type="text" class="form-control" name="jabatanpic" placeholder="Jabatan Penanggung Jawab" maxlength="27" required>
                              </div>
                           </div>
                        </div>
                        <div class="col-lg-6">
                           <div class="row">
                              <div class="col-12">
                                 <label class="form-label">Materi</label>
                                 <textarea class="form-control" name="materi" placeholder="Uraian Materi / Pembahasan" rows="6" style="resize: none;" required></textarea>
                              </div>
                           </div>
                           <div class="row">
                              <div class="col-12">
                                 <label class="form-label">Solusi</label>
                                 <textarea class="form-control" name="solusi" placeholder="Uraian Solusi" rows="8" style="resize: none;" required></textarea>
                              </div>
                           </div>
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
<?php } ?>
</html>