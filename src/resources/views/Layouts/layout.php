<?php

?>
<!DOCTYPE html>
<html lang="es" data-theme="dark" data-bs-theme="dark">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?= $this->e($title) ?></title>
	<!-- PICO CSS descargado -->
	<!--link rel="stylesheet" href="/assets/css/pico.min.css"-->

	<!-- BOOSTRAP DESCARGADO -->
	<link rel="stylesheet" href="<?= RESORUCES_URL; ?>bootstrap/css/bootstrap.min.css">
	<!-- BOOSTRAP CDN -->
	<!--link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous"-->

	<!-- SWEET ALERT DESCARGADO -->
	<link rel="stylesheet" href="<?= RESORUCES_URL; ?>sweetalert2/sweetalert2.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" crossorigin="anonymous">
	<!-- SWEET ALERT CDN -->
	<!--link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.min.css" integrity="sha256-VJuwjrIWHWsPSEvQV4DiPfnZi7axOaiWwKfXaJnR5tA=" crossorigin="anonymous"-->
	<?php if (isset($useDataTablesResources) && $useDataTablesResources) : ?>
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" />
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css" />
		<?= $datatable->autoLoadCSSResources(); ?>
	<? endif; ?>
	<link rel="icon" type="image/x-icon" href="/favicon.ico">
	<?php echo $this->section('styles') ?>
</head>

<body>
	<main class="container">
		<section class="row mb-5">
			<?= $this->insert("Sections/Nav/mainMenuNav");
			?>
		</section>
		<div class="clearfix"></div>
		<header class="row">
			<h1 class="mt-5"><?= $h1; ?></h1>
		</header>
		<?= $this->section("content"); ?>
	</main>
	<footer>
		<?= $this->section('footerLinks'); ?>
	</footer>
	<script src="https://code.jquery.com/jquery-3.7.0.js"></script>
	<script src="<?= RESORUCES_URL; ?>bootstrap/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>

	<!-- SWEET ALERT DESCARGADO -->
	<script src="<?= RESORUCES_URL; ?>sweetalert2/sweetalert2.all.min.js"></script>
	<!-- SWEET ALERT CDN -->
	<!--script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js" integrity="sha256-S/HO+Ru8zrLDmcjzwxjl18BQYDCvFDD7mPrwJclX6U8=" crossorigin="anonymous"></script-->
	<?php if (isset($useDataTablesResources) && $useDataTablesResources) : ?>
		<!-- <script src="https://cdn.datatables.net/autofill/2.6.0/js/dataTables.autoFill.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
		<script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
		<script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script> -->
		<?= $datatable->autoLoadJsResources(); ?>
		<?= $datatable->autoLoadDatatableJS(); ?>
		<script>
			$(document).ready(function() {
				$(document).on('click', '.btn-danger', function(e) {
					e.preventDefault();
					var href = $(this).attr('href');

					Swal.fire({
						title: '¿Estás seguro?',
						text: "No podrás revertir esto!",
						icon: 'warning',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Sí, bórralo!'
					}).then((result) => {
						if (result.isConfirmed) {
							window.location.href = href;
						}
					})
				});
			});
		</script>
	<? endif; ?>

	<?php echo $this->section('scripts') ?>
</body>

</html>