<?php 

use PHPUnit\Framework\TestCase;

use modelo\gestionar_personal;

class modificar_gestionar_personalTest extends TestCase{
    private $personal;
    protected static $pdo;

    public function setUp():void{
        
        $this->personal = new gestionar_personal();
    }

    public function testModificarPersonal(){

        $this->personal->set_club_personal('?¡?¡?¡?¡?');
        $this->personal->set_cedula_personal('ecuatoriana');
        $this->personal->set_nombres_personal('213123?¡');
        $this->personal->set_apellidos_personal('321¡¡¡¡');
        $this->personal->set_telefono_personal('motorola');
        $this->personal->set_cargo_personal('23123121');
        $this->personal->set_direccion_personal('92273292¡¡¡');

        $modificar = $this->personal->modificar('1','29831184','2');

        $this->assertEquals('Modificado Correctamente', $modificar);
       
    }
}

?>