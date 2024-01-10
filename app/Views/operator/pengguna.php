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
         <h1>Master Akses Pengguna</h1>
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo base_url('') ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Pengolahan Data Master Akses Pengguna</li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <div class="card-body">
                     <a href="#tambah" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3" style="float: right;"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                     <h5 class="card-title">Data Akses Pengguna</h5>
                     <p>pilih tombol <strong>Tambah Data</strong> untuk menambahkan data baru. pilih tombol <strong><i class="bi bi-pencil-square"></i></strong> untuk mengubah detail data. pilih tombol <strong><i class="bi bi-x-octagon"></i></strong> untuk menghapus data</p>
                     <table class="table datatable">
                        <thead>
                           <tr>
                              <th>*</th>
                              <th>Nama</th>
                              <th>Jekel</th>
                              <th>Level</th>
                              <th>Username</th>
                              <th>Status</th>
                              <th></th>
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                           $n = 1;
                           foreach ($data as $d) {
                              $cek = $db->query("select ifnull(count(*),0) as jumlah from pengajuan where idpengguna = '".$d['idpengguna']."'")->getRowArray()['jumlah'];
                              if($cek == 0){
                                 $cek = $db->query("select ifnull(count(*),0) as jumlah from bayar where idpengguna = '".$d['idpengguna']."'")->getRowArray()['jumlah'];
                              }
                              ?>
                              <tr>
                                 <td><?php echo $n++ ?></td>
                                 <td><?php echo $d['nama'] ?></td>
                                 <td><?php echo $d['jekel'] ?></td>
                                 <td>
                                    <?php
                                    if($d['level'] == 'b'){
                                       echo "Akses Bendahara";
                                    }else{
                                       echo "Akses Staf Operator / Pelayanan";
                                    }
                                    ?>
                                 </td>
                                 <td><?php echo $d['username'] ?></td>
                                 <td>
                                    <?php if($d['status'] == '0'){ ?>
                                       <span class="badge bg-danger"><i class="bi bi-exclamation-octagon me-1"></i> nonaktif</span>
                                    <?php }else{ ?>
                                       <span class="badge bg-success"><i class="bi bi-check-circle me-1"></i> aktif</span>
                                    <?php } ?>
                                 </td>
                                 <td>
                                    <a href="<?php echo base_url('p/pengguna/d/'.$d['idpengguna']) ?>"><i class="bi bi-pencil-square" style="font-size: 1.2em;"></i></a>
                                    <?php if($cek == 0){ ?>
                                       &nbsp;
                                       <a href="#hapus<?php echo $d['idpengguna'] ?>" data-bs-toggle="modal"><i class="bi bi-x-octagon" style="font-size: 1.2em;"></i></a>
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
         <form action="<?php echo base_url('p/pengguna/s') ?>" method="post">
            <div class="modal-body">
               <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Simpan Data</strong> untuk menyimpan inputan data baru</p>
               <hr>
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
                  <label for="inputText" class="col-sm-3 col-form-label">Level Akses</label>
                  <div class="col-sm-9">
                     <select class="form-control" name="level" required>
                        <option value="b">Bendahara</option>
                        <option value="o">Staf Operator / Pelayanan</option>
                     </select>
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
   <div class="modal fade" id="hapus<?php echo $d['idpengguna'] ?>" tabindex="-1" aria-hidden="true">
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
               <a href="<?php echo base_url('p/pengguna/h/'.$d['idpengguna']) ?>" class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i> Hapus Data</a>
            </div>
         </div>
      </div>
   </div>
<?php } ?>
</html>