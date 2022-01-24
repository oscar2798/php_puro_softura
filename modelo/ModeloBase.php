<?php

include_once "BaseDeDatos.php";

/**
 * realizar las operaciones basicas
 * select, insert, update, delete
 */

class ModeloBase extends BaseDeDatos{

    private $tabla;

    function __construct($tabla)
    {
        parent::__construct();
        $this->tabla = $tabla;
    }

    public function obtenerRegistros($condicionales = array()){
        //$consulta = "select * from ".$this->tabla;
        $registros = $this->consultaRegistros($this->tabla,$condicionales);
        return $registros;
    }

    public function actualizar($valoresUpdate,$condicionales){
        return $this->actualizarRegistro($this->tabla,$valoresUpdate,$condicionales);
    }

    public function insertar($valoresInsertar){
        return $this->insertarRegistro($this->tabla,$valoresInsertar);
    }

    public function eliminar($condicionalesDelete){
        return $this->eliminarRegistro($this->tabla,$condicionalesDelete);
    }

}