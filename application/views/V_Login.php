<?php
defined('BASEPATH') OR exit('No direct sript access allowed');
?><!DOCTYPE html>
<html>
<head>
	<title>Login</title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css')?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css') ?>">

	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/datatablecss.css') ?>">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/datatable/datatablecss.min.css') ?>">
</head>
<body>
	<div class="container mt-1">
		<?php if (!empty($this->session->flashdata('error_login'))) :?> 
			<div class="alert alert-warning">
				<p>Mohon maaf username atau password salah</p>
			</div>
		<?php endif ?>
		<?= form_open('CApp/CProsesLogin', ['method'=> 'POST']) ?>
			<div class="form-group">
				<label>nama pengguna</label>
				<input type="text" class="form-control" name="nm_pengguna" placeholder="Nama Pelanggan">
			</div>
			<div class="form-group">
				<label>password</label>
				<input type="password"class="form-control" name="pass" placeholder="password">
			</div>
			<input type="submit" class="btn btn-success" value="Login">
		<?= form_close () ?>
		
	</div>
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootsrap.js') ?>"></script>
	<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js') ?>"></script>

</body>
</html>
