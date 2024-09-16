<?php $uri = service('uri'); ?>

<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url('Instalatir/home') ?>">
        <div class="sidebar-brand-icon">
            <img src="<?= base_url() ?>/Assets/img/logo.png" alt="Logo" style="height: 50px;">
        </div>
        <div class="sidebar-brand-text mx-4" style="position: relative; text-align: center;">
            <span style="display: inline-block; transform: translateX(-25%);">berita acara</span>
            <sup style="position: absolute; top: 0; right: 0; font-size: 0.7em;">pdam</sup>
        </div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Heading -->
    <div class="sidebar-heading">
        Home
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item <?= ($uri->getSegment(2) == 'home') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('Instalatir/home') ?>">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Home</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Surat Keterangan
    </div>

    <!-- Nav Item - Charts -->
    <li class="nav-item <?= ($uri->getSegment(2) == 'pemetaan_swadaya') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('Instalatir/pemetaan_swadaya') ?>">
            <i class="fas fa-fw fa-chart-area"></i>
            <span>Pemetaan Swadaya</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item <?= ($uri->getSegment(2) == 'rehab_jaringan') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('Instalatir/rehab_jaringan') ?>">
            <i class="fas fa-fw fa-table"></i>
            <span>Pemetaan Rehab Jaringan</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item <?= ($uri->getSegment(2) == 'pengembang_jaringan') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('Instalatir/pengembang_jaringan') ?>">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pemetaan Pengembangan Jaringan</span></a>
    </li>

    <!-- Nav Item - Tables -->
    <li class="nav-item <?= ($uri->getSegment(2) == 'sipil_me') ? 'active' : '' ?>">
        <a class="nav-link" href="<?= base_url('Instalatir/sipil_me') ?>">
            <i class="fas fa-fw fa-briefcase"></i>
            <span>Sipil & Me</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->