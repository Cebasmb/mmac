<?php 

use PHPUnit\Framework\TestCase;

use modelo\roles_permisos;

class modificar_rolesTest extends TestCase{
    private $rol;

    public function setUp():void{
        $this->rol = new roles_permisos();
    }

    public function testModificarRol(){

        $this->rol->set_nombre('371283?¡?¡?');
        $this->rol->set_descripcion('3123¡?¡?');

        $modificar = $this->rol->modificar('1','29831184','9');
        $this->assertEquals('ingrese datos correctamente', $modificar);
    }
}

?>