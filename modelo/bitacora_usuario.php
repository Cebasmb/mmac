<?php 
namespace modelo;
use modelo\conexion as conexion;
use PDO;
use Exception;

class bitacora_usuario extends conexion{

    private $permiso;

    function set_permiso($valor){
		$this->permiso = $valor;
	}

    function get_permiso(){
		return $this->permiso;
	}

    public function consultar($rol_usuario){

        $co = $this->conecta();
		$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        try{
			$valor = $this->permisos($rol_usuario); //rol del usuario
			if ($valor[0]=="true") {

				$stmt = $co->prepare("SELECT b.cedula_usuario as cedula,u.nombre as nombre, m.nombre as modulo, DATE_FORMAT(b.fecha_registro, '%d/%m/%Y') as fecha, TIME_FORMAT(b.hora_registro, '%r') as hora, b.accion_realizada as accion from bitacora_usuario as b, modulos as m, usuarios as u where u.cedula = b.cedula_usuario and m.id = b.id_modulo ORDER BY b.id DESC");

				$stmt->execute();

				$resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);
				
				$datos = array();

				foreach($resultado as $fila){

					$subarray=array();
					$subarray['cedula']=$fila['cedula'];
					$subarray['nombre']=$fila['nombre'];
					$subarray['modulo']=$fila['modulo'];
					$subarray['fecha']=$fila['fecha'];
					$subarray['hora']=$fila['hora'];
					$subarray['accion']= parent::desencriptar($fila['accion']);
					
					$datos[] = $subarray;
					
				}

				$json = array(
					"data" => $datos
				);

				return json_encode($json);
			}else{
				return "No tiene permiso para realizar esta tarea";
			}

		}catch(Exception $e) {
			return $e->getMessage();
		}
    }

    public function permisos($rol){
		
		$co = $this->conecta();
		$co->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		
		try{
			
			
			$stmt = $co->prepare("SELECT consultar, registrar, modificar, eliminar FROM intermediaria WHERE id_rol = :rol and id_modulos = '8' ");
			
			$stmt->bindParam(':rol',$rol);
			$stmt->execute();
			
			$consultar="";
			$registrar="";
			$modificar="";
			$eliminar="";
			
			foreach($stmt as $r){
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

}

?>