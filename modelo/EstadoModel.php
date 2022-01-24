<?php

include_once 'ModeloBase.php';

/**
 * crear clase correspondiente y hacer herencia de la clase BaseDeDatos
 */
class EstadoModel extends ModeloBase {

    function __construct()
    {
        parent::__construct("catalogo_estado");
    }

}