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
            <i class="bi bi-journal-text"></i><span>Pengajuan</span><i class="bi bi-chevron-down ms-auto"></i>
         </a>
         <ul id="master-nav" class="nav-content collapse " data-bs-parent="#sidebar-nav">
            <li><a href="<?php echo base_url('b/pengajuan') ?>"><i class="bi bi-circle"></i><span>Detail Data</span></a></li>
            <li><a href="<?php echo base_url('b/laporan/l') ?>"><i class="bi bi-circle"></i><span>Laporan</span></a></li>
         </ul>
      </li>
   </ul>
</aside>