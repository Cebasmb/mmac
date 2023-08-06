<!DOCTYPE html>
<html lang="es">
<head>
	<?php require_once('comunes/cabecera.php') ?>
</head>
<body> 
 
	<?php require_once('comunes/modal.php') ?>
 
	<div id="wrapper">

		<?php require_once('comunes/menu-sidebar.php')?>

		<div id="content-wrapper" class="d-flex flex-column">
			<div id="content">

				<?php require_once('comunes/menu-topbar.php')?>
				
				<div class="container-fluid border mt-4 shadow p-3 mb-4 bg-white rounded" style="width:95%;">
			
					<div class="container-fluid text-center h4 text-dark mb-4">
						Reporte de Resultado de eventos
					</div>
					<form method="post" action="" id="formulario_reporte_resultados" target="_blank">
			
						<div class="row">
							<div class="col-md-12">
								<label for="evento_reporte_resultados">Evento</label>
								<select class="selectpicker form-control" name="evento_reporte_resultados" id="evento_reporte_resultados" data-live-search="true" title="Seleccione Opcion">
									<option value="" hidden="" selected="hidden">Seleccione un evento</option> 
									<option value=""></option>
									<?php
										if(!empty($consulta_eventos)){
											echo $consulta_eventos;
										}
									?>
								</select>
							</div>
			
						</div>
			
						<div class="row">
							<div class="col-md-12 text-center mb-3">
								<hr>
							</div>
						</div>
			
						<div class="row mb-2 justify-content-center">
							<div class="col-md-3">
								<button type="submit" class="btn btn-danger w-100" id="generar_reporte_personal" name="generar_reporte_resultados">GENERAR REPORTE</button>
							</div>
						</div>
						
						
					</form>
				</div>
			</div>
		</div>
	</div>
	<?php require_once('comunes/scripts.php')?>
</body>
</html>