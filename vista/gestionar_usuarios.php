<!DOCTYPE html>
<html lang="es">
<head>
	<?php require_once('comunes/cabecera.php') ?>
</head>
<body>

	<!--Div oculta para colocar el mensaje a mostrar-->
	<div id="mensajes" style="display:none">
		<?php
			if(!empty($mensaje)){
				echo $mensaje;
			}
		?>	
	</div>
	
	<?php require_once('comunes/menu.php') ?>
	<?php require_once('comunes/modal.php') ?>

	<div class="container-fluid border my-4 shadow bg-white rounded" style="width:90%;">

		<div class="container-fluid mt-4 mb-3">
			<div class="row">
				<div class="col-md-9 mb-2">
					<div class="h4 text-dark">Gestionar Usuarios</div>
				</div>
				<div class="col-md-3">
					<?php 
						if($permisos[1] == "true"){
					?>
						<button type="button" class="btn btn-success"  data-toggle="modal" data-target="#modal_gestion" id="boton_nuevo" onclick="modalregistrar()">
							<i class="bi bi-plus-circle mr-1"></i>Nuevo registro
						</button>
					<?php 
						}
					?>
				</div>
			</div>
		</div>
		
		<div class="container-fluid">
			<div class="row">
				<div class="col-md-12" >
					<div class="table-responsive">
						<table class="table table-striped table-hover table-borderless" id="tablaconsulta">
							<thead class="thead-dark">
								<th>Cedula</th>
								<th>Nombre</th>
								<th>Contraseña</th>
								<th style="display:none">Confirmacion Contraseña</th>
								<th>Rol Usuario</th>
								<th style="display:none">id_rol</th>
								<th>Acciones</th>
							</thead>
							<tbody id="resultadoconsulta">
								<?php 
									if(!empty ($listaconsulta)){
										echo $listaconsulta;
									}else{
								?>
									<tr>
										<td colspan="6">No hay informacion</td>
										<td style="display:none"></td>
										<td style="display:none"></td>
										<td style="display:none"></td>
										<td style="display:none"></td>
										<td style="display:none"></td>
									</tr>
								<?php 
									}
								?>
							</tbody>
						</table>
					</div>
					
				</div>
			</div>
		</div>
		
	</div>

	<!--Modal-->
	<div class="modal fade" id="modal_gestion" tabindex="-1" aria-labelledby="modal_gestionlabel" aria-hidden="true">
		<div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
			<div class="modal-content">
				<div class="modal-header text-light bg-dark">
					<h5 class="modal-title" id="modal_gestionlabel"></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<i class="bi bi-x"></i><span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="container-fluid">
						<div class="row">
							<div class="col-md-12">
								<label for="cedula_usuarios">Cedula</label>
								<input class="form-control" maxlength="8" type="text" name="cedula_usuarios" id="cedula_usuarios" placeholder="Ej: &quot;15345987&quot;">
								<span id="scedula_usuarios" style="color: #ff0000;"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<label for="nombre_usuarios">Nombre</label>
								<input type="text" maxlength="25" class='form-control' id='nombre_usuarios' name='nombre_usuarios'>
								<span id="snombre_usuarios" style="color: #ff0000;"></span>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label for="contrasena_usuarios">Contraseña</label>
								<input class="form-control" maxlength="70" type="password" name="contrasena_usuarios" id="contrasena_usuarios">
								<span id="scontrasena_usuarios" style="color: #ff0000;"></span>
							</div>

							<div class="col-md-6">
								<label for="contrasena2_usuarios">Confirmar Contraseña</label>
								<input class="form-control" maxlength="70" type="password" name="contrasena2_usuarios" id="contrasena2_usuarios">
								<span id="scontrasena2_usuarios" style="color: #ff0000;"></span>
							</div>
						</div> 

						<div class="row">
							<div class="col-md-12">
								<label for="rol_usuario">Rol de Usuario</label>
								<select class="form-control" name="rol_usuario" id="rol_usuario">
									<option value="" hidden="" selected="hidden">Seleccionar Opcion</option>
									<?php
										if(!empty($consulta_roles)){
											echo $consulta_roles;
										}
									?>
								</select>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<?php 
						if($permisos[1] == "true"){
					?>
					<button type="button" class="btn btn-danger" id="registrar_usuarios" name="registrar_usuarios"><i class="bi bi-check-lg mr-1"></i>Registrar</button>
					<?php
						}
						if($permisos[2] == "true"){
					?>
					<button type="button" class="btn btn-danger" id="modificar_usuarios" name="modificar_usuarios"><i class="bi bi-pencil-fill mr-1"></i>Modificar</button>
					<?php 
						}
					?>
				
					<button type="button" class="btn btn-dark" data-dismiss="modal">Cancelar</button>
							
				</div>
			</div>
		</div>
	</div>
	<!--Fin Modal regitro-->
	<?php require_once('comunes/scripts.php')?>
	<script type="text/javascript" src="js/gestionar_usuarios.js"></script>
	
</body>
</html>