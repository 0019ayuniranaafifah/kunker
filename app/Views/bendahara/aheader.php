<?php
$db = db_connect();
$p = $db->query("select * from pengguna where idpengguna = '".session()->get('b')."'")->getRowArray();
$fp = base_url('assets/gambar/logo.png');
if($p['foto'] != ''){
   $fp = base_url('assets/gambar/profil/'.$p['foto']);
}
?>
<header id="header" class="header fixed-top d-flex align-items-center">
   <div class="d-flex align-items-center justify-content-between">
      <a href="<?php echo base_url('') ?>" class="logo d-flex align-items-center">
         <img src="<?php echo base_url('assets/gambar/logo.png') ?>" alt="">
         <span class="d-none d-lg-block">siKunKer</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
   </div>
   <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
         <li class="nav-item d-block d-lg-none">
            <a class="nav-link nav-icon search-bar-toggle " href="#">
               <i class="bi bi-search"></i>
            </a>
         </li>
         <li class="nav-item dropdown pe-3">
            <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
               <img src="<?php echo $fp ?>" alt="Profile" class="rounded-circle">
               <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $p['username'] ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
               <li class="dropdown-header">
                  <h6><?php echo $p['nama'] ?></h6>
                  <span>Bendahara</span>
               </li>
               <li>
                  <hr class="dropdown-divider">
               </li>
               <li>
                  <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('b/profil') ?>">
                     <i class="bi bi-person"></i>
                     <span>Profil</span>
                  </a>
               </li>
               <li><hr class="dropdown-divider"></li>
               <li>
                  <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('b/akses') ?>">
                     <i class="bi bi-key"></i>
                     <span>Akses</span>
                  </a>
               </li>
               <li><hr class="dropdown-divider"></li>
               <li>
                  <a class="dropdown-item d-flex align-items-center" href="<?php echo base_url('logout') ?>">
                     <i class="bi bi-box-arrow-right"></i>
                     <span>Log Out</span>
                  </a>
               </li>
            </ul>
         </li>
      </ul>
   </nav>
</header>