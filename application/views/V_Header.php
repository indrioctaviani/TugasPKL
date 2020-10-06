<?php
defined('BASEPATH')OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
<head>
  <title>Beranda</title>

      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css') ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">
      
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/datatablecss.css') ?>">
      <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/datatablecss.min.css') ?>">

      <script type="text/javascript" src="<?php echo base_url('assets/datatable/datatable.js') ?>"></script>
      <script type="text/javascript" src="<?php echo base_url('assets/datatable/datatable.min.js') ?>"></script>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
      <a class="navbar-brand" href="#">RPL LAUNDRY</a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="navbarSupportedContent" aria-control="navbaraSupportedContent" aria-expanded="false" aria-label="Toggle navigaton">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar nav mr-auto">
          <li class="navbar-item">
            
            <a class="nav-link" href="<?= site_url('CApp/CTampilMember') ?>">Member <span class="sr-only">(current)</span> </a>
          </li>
          <li class="navbar-item">
            <a class="nav-link" href="<?= site_url('CApp/CTampilService')?>">Service</a>
          </li>
          <li class="navbar-item">
            <a class="nav-link" href="<?= site_url('CApp/CTampilKeranjang') ?>">Keranjang</a>
          </li>
          <li class="navbar-item">
            <a class="nav-link" href="<?= site_url('CApp/CTampilPembayaran') ?>">Pembayaran</a>
          </li>
          <li class="navbar-item">
            <a class="nav-link" href="<?= site_url('CApp/CTampilLaporan') ?>">Laporan</a>
          </li>
        </ul>

        <form class="form-inline my-2 my-lg-0">
          <a class="btn btn-outline-success ml-1" href="<?=site_url('CApp/CLogout') ?>">LogOut</a>
        </form>
      </div>
    </nav>

    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js') ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>

</body>
</html>