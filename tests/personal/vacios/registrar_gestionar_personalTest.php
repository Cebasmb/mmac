<?php 

use PHPUnit\Framework\TestCase;

use modelo\conexion;
use modelo\gestionar_clubes;
use modelo\gestionar_personal;

class registrar_gestionar_personalTest extends TestCase{
    private $personal;
    protected static $pdo;

    public function setUp():void{
        
        $this->personal = new gestionar_personal();
    }

    public function testRegistrarPersonal(){

        $this->personal->set_club_personal('');
        $this->personal->set_cedula_personal('');
        $this->personal->set_nombres_personal('');
        $this->personal->set_apellidos_personal('');
        $this->personal->set_telefono_personal('');
        $this->personal->set_cargo_personal('');
        $this->personal->set_direccion_personal('');

        $registro = $this->personal->registrar('1','29831184','2');

        $this->assertEquals('ingrese datos correctamente', $registro);
    }
}

?>