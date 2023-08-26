<?php  
namespace modelo;
use modelo\conexion as conexion;
use PDO;
use Exception;

class gestionar_eventos extends conexion{
 
	//atributos privados
	private $nombre_evento;
	private $fecha_evento;
	private $hora_evento;
	private $club_responsable_evento;
	private $monto_evento;
	private $direccion_evento;
	private $juez1;
	private $juez2;
	private $juez3;
 
	private $permiso;
 
	//accedera atributos mediante metodos get y set

	//set = escribir

	public function set_nombre_evento($valor){
		$this->nombre_evento = $valor;
	}

	public function set_fecha_evento($valor){
		$this->fecha_evento = $valor;
	}

	public function set_hora_evento($valor){
		$this->hora_evento = $valor;
	}

	public function set_club_responsable_evento($valor){
		$this->club_responsable_evento = $valor;
	}

	public function set_monto_evento($valor){
		$this->monto_evento = $valor;
	}

	public function set_direccion_evento($valor){
		$this->direccion_evento = $valor;
	}

	public function set_juez1($valor){
		$this->juez1 = $valor;
	}

	public function set_juez2($valor){
		$this->juez2 = $valor;
	}

	public function set_juez3($valor){
		$this->juez3 = $valor;
	}

	
	function set_permiso($valor){
		$this->permiso = $valor;
	}

	//get = leer/escribir

	public function get_nombre_evento($valor){
		return $this->nombre_evento;
	}

	public function get_fecha_evento($valor){
		return $this->fecha_evento;
	}

	public function get_hora_evento($valor){
		return $this->hora_evento;
	}

	public function get_club_responsable_evento($valor){
		return $this->club_responsable_evento;
	}

	public function get_monto_evento($valor){
		return $this->monto_evento;
	}

	public function get_direccion_evento($valor){
		return $this->direccion_evento;
	}

	public function get_juez1($valor){
		return $this->juez1;
	}

	public function get_juez2($valor){
		return $this->juez2;
	}

	public function get_juez3($valor){
		return $this->juez3;
	}

	function get_permiso(){
		return $this->permiso;
	}
 
	public function registrar($rol_usuario, $cedula_bitacora,$modulo){

		$valor = $this->permisos($rol_usuario); //rol del usuario
		if ($valor[1]=="true") {
			if($this->validar()){
				if(!$this->existe($this->nombre_evento)){
				
					$co = $this->conecta();
					$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					//se añaden atributos a la conección para poder controlar los errores
					//atributos para poder manejar los posibles errores

					try {

						$resultado = $co->prepare("INSERT into eventos(
								nombre,
								fecha,
								hora,
								id_club,
								monto,
								direccion,
								juez1,
								juez2,
								juez3)
								Values(
								:nombre_evento,
								:fecha_evento,
								:hora_evento,
								:club_responsable_evento,
								:monto_evento,
								:direccion_evento,
								:juez1,
								:juez2,
								:juez3)");

						$resultado->bindParam(':nombre_evento',$this->nombre_evento);
						$resultado->bindParam(':fecha_evento',$this->fecha_evento);
						$resultado->bindParam(':hora_evento',$this->hora_evento);
						$resultado->bindParam(':club_responsable_evento',$this->club_responsable_evento);
						$resultado->bindParam(':monto_evento',$this->monto_evento);
						$resultado->bindParam(':direccion_evento',$this->direccion_evento);
						$resultado->bindParam(':juez1',$this->juez1);
						$resultado->bindParam(':juez2',$this->juez2);
						$resultado->bindParam(':juez3',$this->juez3);

						$resultado->execute();

						$accion= "Ha regitrado un nuevo Evento";

						parent::registrar_bitacora($cedula_bitacora, $accion, $modulo);

						return  $this->consultar($rol_usuario,  $cedula_bitacora,$modulo);
						
					} catch (Exception $e) {
						return $e->getMessage();
					}

				}
				else{
					return "Ya existe evento con este nombre";
				}
			}else{
				return "ingrese datos correctamente";
			}
		}else {
			return "no tiene permiso para registrar";
		}
	
	}

	public function modificar($rol_usuario, $cedula_bitacora,$modulo){
		$valor = $this->permisos($rol_usuario); //rol del usuario
		if ($valor[2]=="true") {
			if($this->validar()){
				if($this->existe($this->nombre_evento)){

					$co = $this->conecta();
					$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					

					try {

						$resultado = $co->prepare("UPDATE eventos set
							nombre = :nombre_evento,
							fecha = :fecha_evento,
							hora = :hora_evento,
							id_club = :club_responsable_evento,
							monto = :monto_evento,
							direccion = :direccion_evento,
							juez1 = :juez1,
							juez2 = :juez2,
							juez3 = :juez3
							where nombre = :nombre_evento");

						$resultado->bindParam(':nombre_evento',$this->nombre_evento);
						$resultado->bindParam(':fecha_evento',$this->fecha_evento);
						$resultado->bindParam(':hora_evento',$this->hora_evento);
						$resultado->bindParam(':club_responsable_evento',$this->club_responsable_evento);
						$resultado->bindParam(':monto_evento',$this->monto_evento);
						$resultado->bindParam(':direccion_evento',$this->direccion_evento);
						$resultado->bindParam(':juez1',$this->juez1);
						$resultado->bindParam(':juez2',$this->juez2);
						$resultado->bindParam(':juez3',$this->juez3);

						$resultado->execute();

						$accion= "Ha modificado un Evento";

						parent::registrar_bitacora($cedula_bitacora, $accion, $modulo);

						return  $this->consultar($rol_usuario, $cedula_bitacora,$modulo);
						
					} catch (Exception $e) {
						return $e->getMessage();
					}
					
				}
				else{
					return "Evento no registrado";
				}	
			}else{
				return "ingrese datos correctamente";
			}
		}else {
			return "no tiene permiso para modificar";
		}
	} 

	public function eliminar($cedula_bitacora,$modulo,$rol_usuario){
		$valor = $this->permisos($rol_usuario); //rol del usuario
		if ($valor[3]=="true") {
			if(preg_match_all('/^[A-Za-z0-9 ]{5,40}$/',$this->nombre_evento)){
				if($this->existe($this->nombre_evento)){

					$co = $this->conecta();
					$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
					

					try {

						$resultado = $co->prepare("Delete from eventos where nombre = :nombre_evento");

						$resultado->bindParam(':nombre_evento',$this->nombre_evento);

						$resultado->execute();

						
						if ($resultado) {
							$accion= "Ha eliminado un Evento";

							parent::registrar_bitacora($cedula_bitacora, $accion, $modulo);
							return "eliminado";
						}
						else{
							return "no eliminado";
						}
						
					} catch (Exception $e) {
						return $e->getMessage();
					}
					
				} 
				else{
					return "Evento no registrado";
				}
			}else{
				return "ingrese datos correctamente";
			}
		}else {
			return "no tiene permiso para eliminar";
		}
	}

	public function consultar($rol_usuario,  $cedula_bitacora,$modulo){

		$co = $this->conecta();
		$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		try{

			$resultado = $co->prepare("SELECT b.id, a.nombre, a.fecha,a.hora, a.monto, b.nombre, a.direccion, a.juez1, a.juez2, a.juez3 from eventos as a, clubes as b where a.id_club = b.id");

			$resultado->execute();
			
			if($resultado){

				$respuesta = '';
				
				foreach($resultado as $r){
					
					$valor = $this->permisos($rol_usuario); //rol del usuario
					if ($valor[0]=="true") {
						$respuesta = $respuesta."<tr>";

							$respuesta = $respuesta."<td style='display:none;'>";
								$respuesta = $respuesta.$r[0];
							$respuesta = $respuesta."</td>";

							$respuesta = $respuesta."<td>";
								$respuesta = $respuesta.$r[1];
							$respuesta = $respuesta."</td>";

							$respuesta = $respuesta."<td>";
								$respuesta = $respuesta.$r[2];
							$respuesta = $respuesta."</td>";

							$respuesta = $respuesta."<td>";
								$respuesta = $respuesta.$r[3];
							$respuesta = $respuesta."</td>";

							$respuesta = $respuesta."<td>";
								$respuesta = $respuesta.$r[4];
							$respuesta = $respuesta."</td>";

							$respuesta = $respuesta."<td>";
								$respuesta = $respuesta.$r[5];
							$respuesta = $respuesta."</td>";

							$respuesta = $respuesta."<td>";
								$respuesta = $respuesta.$r[6];
							$respuesta = $respuesta."</td>";

							$respuesta = $respuesta."<td>";
								$respuesta = $respuesta.$r[7];
							$respuesta = $respuesta."</td>";

							$respuesta = $respuesta."<td>";
								$respuesta = $respuesta.$r[8];
							$respuesta = $respuesta."</td>";

							$respuesta = $respuesta."<td>";
								$respuesta = $respuesta.$r[9];
							$respuesta = $respuesta."</td>";

							$respuesta = $respuesta."<td class='d-flex'>";
								if ($valor[2]=="true") {
									$respuesta = $respuesta."<button type='button' class='btn btn-primary mb-1 mr-1' data-toggle='modal' data-target='#modal_gestion' onclick='modalmodificar(this)' id='boton_modificar'><i class='bi bi-pencil-fill'></i></button>";
								}
								if ($valor[3]=="true"){
									$respuesta = $respuesta."<button type='button' class='btn btn-danger mb-1 ' onclick='elimina(this)'><i class='bi bi-x-lg'></i></button>";
								}
							$respuesta = $respuesta."</td>";
							

						$respuesta = $respuesta."</tr>";
					}
				}
				$accion= "Ha consultado la tabla de Eventos";

				parent::registrar_bitacora($cedula_bitacora, $accion, $modulo);
				return $respuesta;
			}
			else {
				return '';
			}

		}catch(Exception $e) {
			return $e->getMessage();
		}
	}
 
	private function existe($nombre_evento){
		$co = $this->conecta();
		$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		try {

			
			$resultado = $co->prepare("SELECT * from eventos where nombre = :nombre_evento");

			$resultado->bindParam(':nombre_evento',$nombre_evento);

			$resultado->execute();

			//se convierte el resultado en un arreglo asociativo 
			//y se asigna a la variable $fila
			$fila = $resultado->fetchAll(PDO::FETCH_BOTH);
			if($fila){ //si $fila, significa que encontro el nombre

				return true; //retorna verdadero
			    
			}
			else{
				
				return false; //retorna falso en caso de que no consiga el nombre
			}
			
		}catch(Exception $e){
			//si estra aca es que hubo algun error por lo que tambien me retornara que
			//no la encontro
			return false;
		}
	}
 
	public function consulta_clubes(){

		$co = $this->conecta();
		$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

		try{
 
			$resultado = $co->prepare("SELECT * from clubes");
			$resultado->execute();
			if($resultado){

				$respuesta = '';
				//ciclo foreach se usa casi siempre para recorrer los resultados de las consultas
				foreach($resultado as $r){
					$respuesta = $respuesta."<option value=".$r['id']. 
					">".$r['nombre']."</option>";
				}
				return $respuesta;
			}
			else {
				return '';
			}

		}catch(Exception $e) {
			return $e->getMessage();
		}
	}

	public function permisos($rol){
		
		$co = $this->conecta();
		$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{
			
			
			$resultado = $co->prepare("SELECT consultar, registrar, modificar, eliminar FROM intermediaria WHERE id_rol = :rol and id_modulos = '6' ");
			
			$resultado->bindParam(':rol',$rol);
			$resultado->execute();
			
			$consultar="";
			$registrar="";
			$modificar="";
			$eliminar="";
			
			foreach($resultado as $r){
				$consultar = $r['consultar'];
				$registrar = $r['registrar'];
				$modificar = $r['modificar'];
				$eliminar = $r['eliminar'];
			}
			
			$respuesta_permiso=[];
			
			$respuesta_permiso[0]=$consultar;
			$respuesta_permiso[1]=$registrar;
			$respuesta_permiso[2]=$modificar;
			$respuesta_permiso[3]=$eliminar;	
			
			if(!empty($respuesta_permiso)){
			
				return $respuesta_permiso;

			}else{
				return "ha ocurrido un error";
			}
			
		}catch(Exception $e){
			
			return false;
		}
	}

	public function validar(){

        $this->club_responsable_evento = trim($this->club_responsable_evento);
        
		$this->nombre_evento = trim($this->nombre_evento);
		$this->monto_evento = trim($this->monto_evento);
		$this->fecha_evento = trim($this->fecha_evento);
		$this->juez1 = trim($this->juez1);
		$this->juez2 = trim($this->juez2);
		$this->juez3 = trim($this->juez3);
		$this->hora_evento = trim($this->hora_evento);
		$this->direccion_evento = trim($this->direccion_evento);

		if(!preg_match_all('/^[A-Za-z0-9 ]{5,30}$/',$this->nombre_evento)){
			return false;
		}
		else if(!preg_match_all('/^(19|20)(((([02468][048])|([13579][26]))-02-29)|(\d{2})-((02-((0[1-9])|1\d|2[0-8]))|((((0[13456789])|1[012]))-((0[1-9])|((1|2)\d)|30))|(((0[13578])|(1[02]))-31)))$/',$this->fecha_evento)){
			return false;
		}
		else if (!preg_match_all('/^(([0-1]\d)|(2[0-3])):[0-5]\d$/',$this->hora_evento)){
			return false;
		}
		else if (!preg_match_all('/^[0-9\b]{1,10}$/',$this->club_responsable_evento)){
			return false;
		}
		else if(!preg_match_all('/^[0-9]{1,11}[.,]{0,1}[0-9]{0,2}[bsB$]{0,2}$/',$this->monto_evento)){
			return false;
		}
		else if(!preg_match_all('/^[A-Za-záéíóúÁÉÍÓÚñÑ0-9,# -]{3,30}$/',$this->direccion_evento)){
			return false;
		}
		else if(!preg_match_all('/^[A-Za-záéíóúÁÉÍÓÚñÑ ]{3,50}$/',$this->juez1)){
			return false;
		}
		else if(!preg_match_all('/^[A-Za-záéíóúÁÉÍÓÚñÑ ]{3,50}$/',$this->juez2)){
			return false;
		}
		else if(!preg_match_all('/^[A-Za-záéíóúÁÉÍÓÚñÑ ]{3,50}$/',$this->juez3)){
			return false;
		}
		else{
			return true;
		}
	}

}

?>