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
               <li class="breadcrumb-item"><a href="<?php echo base_url('p/pengguna') ?>">Pengolahan Data Master Akses Pengguna</a></li>
               <li class="breadcrumb-item active">Detail Data <?php echo $data['nama'] ?></li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <form action="<?php echo base_url('p/pengguna/u') ?>" method="post">
                     <input type="hidden" name="id" value="<?php echo $data['idpengguna'] ?>">
                     <div class="card-body">
                        <a href="#tambah" data-bs-toggle="modal" class="btn btn-primary btn-sm mt-3" style="float: right;"><i class="bi bi-plus-circle"></i> Tambah Data</a>
                        <h5 class="card-title">Data Akses Pengguna</h5>
                        <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Simpan Data</strong> untuk menyimpan inputan data baru</p>
                        <hr>
                        <div class="row mb-4">
                           <label for="inputText" class="col-sm-3 col-form-label">Nama</label>
                           <div class="col-sm-9">
                              <input type="text" class="form-control" value="<?php echo $data['nama'] ?>" disabled>
                           </div>
                        </div>
                        <div class="row mb-4">
                           <label for="inputText" class="col-sm-3 col-form-label">Username</label>
                           <div class="col-sm-9">
                              <input type="text" class="form-control" value="<?php echo $data['username'] ?>" disabled>
                           </div>
                        </div>
                        <div class="row mb-4">
                           <label for="inputText" class="col-sm-3 col-form-label">Jenis Kelamin</label>
                           <div class="col-sm-9">
                              <select class="form-control" disabled>
                                 <option <?php if($data['jekel'] == 'Pria'){echo "selected";} ?>>Pria</option>
                                 <option <?php if($data['jekel'] == 'Wanita'){echo "selected";} ?>>Wanita</option>
                              </select>
                           </div>
                        </div>
                        <div class="row mb-4">
                           <label for="inputText" class="col-sm-3 col-form-label">Level Akses</label>
                           <div class="col-sm-9">
                              <select class="form-control" name="level" required>
                                 <option <?php if($data['level'] == 'b'){echo "selected";} ?> value="b">Bendahara</option>
                                 <option <?php if($data['level'] == 'o'){echo "selected";} ?> value="o">Staf Operator / Pelayanan</option>
                              </select>
                           </div>
                        </div>
                        <div class="row mb-4">
                           <label for="inputText" class="col-sm-3 col-form-label">Status Akun</label>
                           <div class="col-sm-9">
                              <select class="form-control" name="status" required>
                                 <option <?php if($data['status'] == '1'){echo "selected";} ?> value="1">Aktif</option>
                                 <option <?php if($data['status'] == '0'){echo "selected";} ?> value="0">Nonaktif</option>
                              </select>
                           </div>
                        </div>
                     </div>
                     <div class="card-footer">
                        <a href="<?php echo base_url('p/pengguna') ?>" class="btn btn-secondary btn-sm"><i class="bi bi-x-lg"></i> Kembali</a>
                        <button type="submit" class="btn btn-primary btn-sm" style="float: right;"><i class="bi bi-download"></i> Simpan Perubahan Data</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>
      </section>
   </main>
   <?php echo view('pimpinan/ascript') ?>
</body>
</html>