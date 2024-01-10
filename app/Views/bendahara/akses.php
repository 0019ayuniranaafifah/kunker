<!DOCTYPE html>
<html lang="en">
<?php echo view('bendahara/ahead') ?>
<body>
   <?php echo view('bendahara/aheader') ?>
   <?php echo view('bendahara/aaside') ?>
   <main id="main" class="main">
      <div class="pagetitle">
         <h1>Kelola Pengguna</h1>
         <nav>
            <ol class="breadcrumb">
               <li class="breadcrumb-item"><a href="<?php echo base_url('') ?>">Dashboard</a></li>
               <li class="breadcrumb-item active">Akses Pengguna</li>
            </ol>
         </nav>
      </div>
      <section class="section">
         <div class="row">
            <div class="col-lg-12">
               <div class="card">
                  <form action="<?php echo base_url('b/akses/u') ?>" method="post">
                     <div class="card-body">
                        <h5 class="card-title">Akses Pengguna</h5>
                        <p style="text-align: justify;">masukkan detail data sesuai dengan format inputan data, lalu pilih tombol <strong>Simpan Perubahan Data</strong> untuk menyimpan inputan data baru</p>
                        <hr>
                        <div class="row mb-4">
                           <label for="inputText" class="col-sm-3 col-form-label">Password Sekarang</label>
                           <div class="col-sm-9">
                              <input type="password" class="form-control" placeholder="Password Sekarang" name="p1" required>
                           </div>
                        </div>
                        <div class="row mb-4">
                           <label for="inputText" class="col-sm-3 col-form-label">Password Baru</label>
                           <div class="col-sm-9">
                              <input type="password" class="form-control" placeholder="Password Baru" name="p2" required>
                           </div>
                        </div>
                        <div class="row mb-4">
                           <label for="inputText" class="col-sm-3 col-form-label">Password Baru Ulang</label>
                           <div class="col-sm-9">
                              <input type="password" class="form-control" placeholder="Password Baru Ulang" name="p3" required>
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
   <?php echo view('bendahara/ascript') ?>
</body>
</html>