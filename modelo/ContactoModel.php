<?php

include_once "ModeloBase.php";

class ContactoModel extends ModeloBase{

    private $idEmpleado;

    public function __construct($idEmpleado)
    {
        $this->idEmpleado = $idEmpleado;
        parent::__construct("contacto");
    }

    public function obtenerRegistros($condicionales = array())
    {
        $consulta = "select * from contacto c inner join catalogo_contacto cc on cc.id = c.catalogo_contacto_id where empleado_id = ".$this->idEmpleado;
        //$registros = $this->consultaRegistros("contacto",array('empleado_id' => $this->idEmpleado));
        $registros = $this->obtenerRegistrosArray($consulta);
        return $registros;
    }

}
