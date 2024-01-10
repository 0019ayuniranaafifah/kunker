<aside id="sidebar" class="sidebar">
   <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
         <a class="nav-link collapsed" href="<?php echo base_url('') ?>">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
         </a>
      </li>
      <li class="nav-item">
         <a class="nav-link collapsed" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
            <i class="bi bi-menu-button-wide"></i><span>Master</span><i class="bi bi-chevron-down ms-auto"></i>
         </a>
         <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li><a href="<?php echo base_url('p/pengguna') ?>"><i class="bi bi-circle"></i><span>Akses Pengguna</span></a></li>
            <li><a href="<?php echo base_url('p/pegawai') ?>"><i class="bi bi-circle"></i><span>Pegawai</span></a></li>
         </ul>
      </li>
      <li class="nav-item">
         <a class="nav-link collapsed" href="<?php echo base_url('p/verifikasi') ?>">
            <i class="bi bi-journal-text"></i>
            <span>Verifikasi Pengajuan</span>
         </a>
      </li>
   </ul>
</aside>