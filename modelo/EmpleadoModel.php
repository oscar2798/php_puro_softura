<?php

include_once "ModeloBase.php";

/**
 * consumir las funciones del modelo base
 */

class EmpleadoModel extends ModeloBase {

    function __construct()
    {
        parent::__construct("empleado");
    }

}