<?php 

use PHPUnit\Framework\TestCase;

use modelo\conexion;
use modelo\gestionar_clubes;
use modelo\gestionar_atleta;

class registrar_gestionar_atletaTest extends TestCase{
    private $atleta;
    private $clubes;
    protected static $pdo;

    public static function setUpBeforeClass():void {
        try {
            $host = 'mysql:host=localhost;dbname=bdmma';
            self::$pdo = new PDO($host, 'root', '');
        } catch (\Exception $e) {
            $this->markTestSkipped('MySQL: No se pudo conectar a la base de datos.');
        }
    }

    public function setUp():void{
        
        $this->atleta = new gestionar_atleta();
        $this->clubes = new gestionar_clubes();
        
        $this->clubes->set_codigo_club('asdfgh');
        $this->clubes->set_nombre_club('aguilas luchadores 2023');
        $this->clubes->set_telefono_club('04131234567');
        $this->clubes->set_deporte_club('karate');
        $this->clubes->set_direccion_club('barquisimeto');

        $this->clubes->registrar('1','29831184','1');
    }

    public function testRegistrarAtleta(){

        $id_club = self::$pdo->query('SELECT  id from clubes where codigo="asdfgh"')->fetch(\PDO::FETCH_ASSOC)['id']; 

        $this->atleta->set_club_atleta($id_club);
        $this->atleta->set_cedula_atleta('3345123');
        $this->atleta->set_nombres_atleta('robert');
        $this->atleta->set_apellidos_atleta('james');
        $this->atleta->set_peso_atleta('66.4');
        $this->atleta->set_estatura_atleta('1.70');
        $this->atleta->set_fecha_atleta('2002-12-22');
        $this->atleta->set_telefono_atleta('04244367865');
        $this->atleta->set_sexo_atleta('masculino');
        $this->atleta->set_deporte_atleta('karate');
        $this->atleta->set_categoria_atleta('categoria 2');
        $this->atleta->set_fecha_ingreso_atleta('2023-03-01');
        $this->atleta->set_entrenador_atleta('carlos rodriguez');

        $registro = $this->atleta->registrar('1','29831184','1');

        $this->assertStringStartsWith('<tr>', $registro);
    }

    public function tearDown():void {
        $this->atleta->set_cedula_atleta('3345123');
        $this->atleta->eliminar('1','29831184','1'); 

        $this->clubes->set_codigo_club('asdfgh');
        $this->clubes->eliminar('1','29831184','1');
    }

}

?>