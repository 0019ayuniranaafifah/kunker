<?php
$db = db_connect();
$pangkat = $db->query("select pangkat from pegawai group by pangkat asc")->getResultArray();
$golongan = $db->query("select golongan from pegawai group by golongan asc")->getResultArray();
$jabatan = $db->query("select jabatan from pegawai group by jabatan asc")->getResultArray();
?>
<!DOCTYPE html>
<html lang="en">
<?php echo view('pimpinan/ahead') ?>
<body>
   <?php echo view('pimpinan/aheader') ?>
   <?php echo view('pimpinan/aaside') ?>
   <main id="main" class="main">
      <div class="pagetitle">
         <h1>Master Pegawai</h1>
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo base_url('') ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Pengolahan Data Master Pegawai</li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-body">
                     <a href="#tambah" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3" style="float: right;"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                     <h5 class="card-title">Data Pegawai</h5>
                     <p>pilih tombol <strong>Tambah Data</strong> untuk menambahkan data baru. pilih tombol <strong><i class="bi bi-pencil-square"></i></strong> untuk mengubah detail data. pilih tombol <strong><i class="bi bi-x-octagon"></i></strong> untuk menghapus data</p>
                     <table class="table datatable">
                        <thead>
                           <tr>
                              <th>*</th>
                              <th>Nama / NIP</th>
                              <th>Jekel</th>
                              <th>Pangkat</th>
                              <th>Golongan</th>
                              <th>Jabatan</th>
                              <th>Status</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $n = 1;
                           foreach ($data as $d) {
                              $cek = $db->query("select ifnull(count(*),0) as jumlah from utusan where idpegawai = '".$d['idpegawai']."'")->getRowArray()['jumlah'];
                              ?>
                              <tr>
                                 <td><?php echo $n++ ?></td>
                                 <td>
                                    <?php echo $d['nama'] ?><br>
                                       <small><?php echo $d['nip'] ?></small>
                                    </td>
                                 <td><?php echo $d['jekel'] ?></td>
                                 <td><?php echo $d['pangkat'] ?></td>
                                 <td><?php echo $d['golongan'] ?></td>
                                 <td><?php echo $d['jabatan'] ?></td>
                                 <td>
                                    <?php if($d['status'] == '0'){ ?>
                                       <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> nonaktif</span>
                                    <?php }else{ ?>
                                       <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> aktif</span>
                                    <?php } ?>
                                 </td>
                                 <td>
                                    <a href="<?php echo base_url('p/pegawai/d/'.$d['idpegawai']) ?>"><i class="bi bi-pencil-square" style="font-size: 1.2em;"></i></a>
                                    <?php if($cek == 0){ ?>
                                       &nbsp;
                                       <a href="#hapus<?php echo $d['idpegawai'] ?>" data-bs-toggle="modal"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
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
   <?php echo view('pimpinan/ascript') ?>
</body>
<div class="modal fade" id="tambah" tabindex="-1" aria-hidden="true">
   <div class="modal-dialog modal-dialog-centered modal-lg">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Tambah Data Baru</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
         </div>
         <form action="<?php echo base_url('p/pegawai/s') ?>" method="post">
            <div class="modal-body">
               <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Simpan Data</strong> untuk menyimpan inputan data baru</p>
               <hr>
               <div class="row mb-4">
                  <label for="inputText" class="col-sm-3 col-form-label">NIP</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control" placeholder="Nomor Induk Pegawai" name="nip" maxlength="21">
                  </div>
               </div>
               <div class="row mb-4">
                  <label for="inputText" class="col-sm-3 col-form-label">Nama</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control" placeholder="Nama Pengguna" name="nama" maxlength="63" required>
                  </div>
               </div>
               <div class="row mb-4">
                  <label for="inputText" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                  <div class="col-sm-9">
                     <select class="form-control" name="jekel" required>
                        <option>Pria</option>
                        <option>Wanita</option>
                     </select>
                  </div>
               </div>
               <div class="row mb-4">
                  <label for="inputText" class="col-sm-3 col-form-label">Alamat</label>
                  <div class="col-sm-9">
                     <textarea class="form-control" placeholder="Alamat Lengkap" name="alamat" rows="3" style="resize: none;" required></textarea>
                  </div>
               </div>
               <div class="row mb-4">
                  <label for="inputText" class="col-sm-3 col-form-label">Pangkat</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control" placeholder="Pangkat Pegawai" name="pangkat" maxlength="27" list="daftarpangkat" required>
                     <datalist id="daftarpangkat">
                        <?php foreach ($pangkat as $p) {?>
                           <option><?php echo $p['pangkat'] ?></option>
                        <?php } ?>
                     </datalist>
                  </div>
               </div>
               <div class="row mb-4">
                  <label for="inputText" class="col-sm-3 col-form-label">Golongan</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control" placeholder="Golongan Pegawai" name="golongan" maxlength="9" list="daftargolongan" required>
                     <datalist id="daftargolongan">
                        <?php foreach ($golongan as $g) {?>
                           <option><?php echo $g['golongan'] ?></option>
                        <?php } ?>
                     </datalist>
                  </div>
               </div>
               <div class="row mb-4">
                  <label for="inputText" class="col-sm-3 col-form-label">Jabatan</label>
                  <div class="col-sm-9">
                     <input type="text" class="form-control" placeholder="Jabatan Pegawai" name="jabatan" maxlength="99" list="daftarjabatan" required>
                     <datalist id="daftarjabatan">
                        <?php foreach ($jabatan as $j) {?>
                           <option><?php echo $j['jabatan'] ?></option>
                        <?php } ?>
                     </datalist>
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
<?php foreach ($data as $d) {?>
   <div class="modal fade" id="hapus<?php echo $d['idpegawai'] ?>" tabindex="-1" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <h5 class="modal-title">Hapus Data</h5>
               <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
               <p style="text-align: justify;">apakah anda yakin untuk menghapus data <?php echo $d['nama'] ?>? jika anda yakin, pilih tombol <strong>Hapus Data</strong> untuk menghapus data selamanya</p>
            </div>
            <div class="modal-footer">
               <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal"><i class="bi bi-x-lg"></i> Batal</button>
               <a href="<?php echo base_url('p/pegawai/h/'.$d['idpegawai']) ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i> Hapus Data</a>
            </div>
         </div>
      </div>
   </div>
<?php } ?>
</html>