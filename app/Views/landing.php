<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>SIKUNKER - Sistem Informasi Pengelolaan Kunjungan Kerja :: Akses Pimpinan</title>
    <meta content="" name="description">
    <meta content="" name="keywords">
    <link rel="shortcut icon" href="<?php echo base_url('assets/gambar/logo.png') ?>" />
    <link href="https://fonts.gstatic.com" rel="preconnect">
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/bootstrap/css/bootstrap.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/bootstrap-icons/bootstrap-icons.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/boxicons/css/boxicons.min.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/quill/quill.snow.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/quill/quill.bubble.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/remixicon/remixicon.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/vendor/simple-datatables/style.css') ?>" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/style.css') ?>" rel="stylesheet">
</head>
<body>
    <main>
        <div class="container">
            <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">
                            <div class="card mb-3">
                                <div class="card-body">
                                    <div class="pt-4 pb-2">
                                        <p style="text-align: center;">
                                            <img src="<?php echo base_url('assets/gambar/logo.png') ?>" width="20%">
                                        </p>
                                        <h5 class="card-title text-center pb-0 fs-4">Selamat Datang Pengguna</h5>
                                        <p class="text-center small">Masukkan Username dan Password akses akun</p>
                                    </div>
                                    <form class="row g-3 needs-validation" method="post" action="<?php echo base_url('login') ?>">
                                        <div class="col-12">
                                            <label for="yourUsername" class="form-label">Username</label>
                                            <div class="input-group has-validation">
                                                <span class="input-group-text" id="inputGroupPrepend">@</span>
                                                <input type="text" name="username" class="form-control" id="yourUsername" placeholder="Username Akun" autofocus required>
                                                <div class="invalid-feedback">Masukkan username akun</div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <label for="yourPassword" class="form-label">Password</label>
                                            <input type="password" name="password" class="form-control" id="yourPassword" placeholder="Password Akun" required>
                                            <div class="invalid-feedback">Please enter your password!</div>
                                        </div>
                                        <?php if(session()->getFlashdata('gagal')){ ?>
                                            <div class="col-12 text-center">
                                                <code><?php echo session()->getFlashdata('gagal') ?></code>
                                            </div>
                                        <?php } ?>
                                        <div class="col-12">
                                            <button class="btn btn-primary w-100" type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
    <script src="<?php echo base_url('assets/vendor/apexcharts/apexcharts.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/chart.js/chart.umd.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/echarts/echarts.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/quill/quill.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/simple-datatables/simple-datatables.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/tinymce/tinymce.min.js') ?>"></script>
    <script src="<?php echo base_url('assets/vendor/php-email-form/validate.js') ?>"></script>
    <script src="<?php echo base_url('assets/js/main.js') ?>"></script>
</body>
</html>