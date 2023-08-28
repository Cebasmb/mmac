<?php 
	
	use modelo\inicio_sesion;

	if(is_file("vista/".$pagina.".php")){
 
		$objeto = new inicio_sesion();

		if(isset($_POST['accion_inicio_sesion'])){
			
			if(preg_match_all('/^[0-9\b]{7,8}$/',$_POST['cedula_inicio'])){

				$objeto->set_cedula_inicio($_POST['cedula_inicio']);
				
				$cedula = $objeto->busca_cedula();
				$contraseña_encontrada = $objeto->busca_contrasena();
				
				//lo que viene de la vista
				$captcha = $_POST['g-recaptcha-response'];
				//llave secreta del captcha
				$secretKeyCaptcha = '6LcEU7wnAAAAABojeM9Y4v4b3Jh1Vz7g998kCqPU';
				
				//respuesta de google
				$respuestaCaptcha = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretKeyCaptcha&response=$captcha");

				$atributosRespuesta = json_decode($respuestaCaptcha,TRUE);
				
				if($atributosRespuesta['success']){

					if(isset($_COOKIE["block".$cedula])){
						$mensaje = "El usuario ha sido bloqueado por 1 minuto";
					}else{

						if(!$objeto->buscaSolicitud()){

							if(preg_match_all('/^[A-Za-z0-9ñÑ_.@$!%*?&#\/\b-]{6,70}$/',$_POST['contrasena_inicio'])){
		
								$verifica=password_verify($_POST['contrasena_inicio'],$contraseña_encontrada);
								//condicion para saber si coinciden los datos correctos
								if ($cedula!="Error en datos ingresados" and $verifica==1) {
			
									$rol = $objeto->busca_id_rol();
			
									$nombre = $objeto->busca_nombre();
			
									session_start();
									$_SESSION['cedula'] = $cedula;
									$_SESSION['rol'] = $rol;
									$_SESSION['nombre'] = $nombre;
			
									$objeto->set_rol($rol);
			
									$modulo = $objeto->busca_modulo();
									
									$_SESSION['modulo'] = $modulo;
									
									$mensaje= "ok";//el ok e para el envio ajax
								} 
								//si no coinciden manda el mensaje de datos incorrectos
								else{
			
									if (isset($_COOKIE["$cedula"])){
										$contador = $_COOKIE["$cedula"];
										$contador++;
										setcookie($cedula,$contador,time()+ 120);
			
										if($contador >= 3){
											
											setcookie("block".$cedula,$contador,time()+ 60);
											echo $objeto->solicitarCambioContrasena();
										}
			
									}else{
										setcookie($cedula,1,time()+120);
									}
									$mensaje = "Datos Incorrectos";//mensaje que mostrara si no existe usuario registrado
								}
							}else{
								$mensaje = 'Ingrese contraseña correctamente';
							}
						}else{
							$mensaje = 'Debe restaurar su contraseña';
						}
						
					}

				}else{
					$mensaje = 'Error al comprobar el Captcha';
				}

			}else{
				$mensaje = 'ingrese cedula correctamente';
			}
			
			echo $mensaje;
			  
			exit;
		}
		
		require_once("vista/".$pagina.".php");
	} 
	else{
		echo "PAGINA EN CONSTRUCCION";
	}
?>