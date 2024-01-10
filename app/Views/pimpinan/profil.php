<!DOCTYPE html>
<html lang="en">
<?php echo view('pimpinan/ahead') ?>
<body>
   <?php echo view('pimpinan/aheader') ?>
   <?php echo view('pimpinan/aaside') ?>
   <main id="main" class="main">
      <div class="pagetitle">
         <h1>Kelola Pengguna</h1>
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo base_url('') ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Profil Pengguna</li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <form action="<?php echo base_url('p/profil/u') ?>" method="post">
                     <div class="card-body">
                        <h5 class="card-title">Profil Pengguna</h5>
                        <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Simpan Perubahan Data</strong> untuk menyimpan inputan data baru</p>
                        <hr>
                        <div class="row mb-4">
                           <label for="inputText" class="col-sm-3 col-form-label">Nama</label>
                           <div class="col-sm-9">
                              <input type="text" class="form-control" placeholder="Nama Pengguna" name="nama" maxlength="63" value="<?php echo $data['nama'] ?>" required>
                           </div>
                        </div>
                        <div class="row mb-4">
                           <label for="inputText" class="col-sm-3 col-form-label">Username</label>
                           <div class="col-sm-9">
                              <input type="text" class="form-control" placeholder="Username Pengguna" name="username" maxlength="99" value="<?php echo $data['username'] ?>" required>
                           </div>
                        </div>
                     </div>
                     <div class="card-footer">
                        <button type="submit" class="btn btn-primary btn-sm"><i class="bi bi-download"></i> Simpan Perubahan Data</button>
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