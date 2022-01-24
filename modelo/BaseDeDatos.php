<?php

include_once 'ConfigBD.php';

/*
 * consultas
 * nuevos registros
 * modificar registros
 * eliminar registros
 * CRUD
 */

class BaseDeDatos
{

    private $dbConfig;
    private $mysqli;

    private $errors;

    function __construct()
    {
        //manejo de errores
        try {
            $this->dbConfig = ConfigBD::getConfig();
            $this->mysqli = new mysqli(
                $this->dbConfig['host'],
                $this->dbConfig['user'],
                $this->dbConfig['password'],
                $this->dbConfig['database'],
                $this->dbConfig['port']
            );
            if ($this->mysqli->connect_errno) {
                echo "Error en la conexion de BD " . $this->mysqli->connect_error;
            }
            $this->errors = array();
        } catch (Exception $ex) {
            //mostrar mensaje de error de constructor de BaseDeDatos
            echo 'Error en el constructor de BaseDeDatos';
            die;
        }
    }

//    public function consultaRegistros($querySQL)
//    { //consuta_registros
//        $consulta = $this->mysqli->query($querySQL);
//        $indexRegistro = 0;
//        $array_registros = array();
//        while ($registro = $consulta->fetch_assoc()){
//            foreach ($registro as $columna => $valor){
//                $array_registros[$indexRegistro][$columna] = utf8_encode($valor);
//            }
//            $indexRegistro++;
//        }
//        return $array_registros;
//    }

    public function consultaRegistros($tabla,$condicionales = array())
    {
        $sqlWheres = $this->obtenerCondicionalesAnd($condicionales);
        $consultaSelect = "SELECT * FROM ".$tabla." ".$sqlWheres;
        $consultaSql = $this->mysqli->query($consultaSelect);
        $indexRegistro = 0;
        $array_registros = array();
        while ($registro = $consultaSql->fetch_assoc()){
            foreach ($registro as $columna => $valor){
                $array_registros[$indexRegistro][$columna] = utf8_encode($valor);
            }
            $indexRegistro++;
        }
        return $array_registros;
    }

    public function obtenerRegistrosArray($querySQL){
        $consultaSql = $this->mysqli->query($querySQL);
        $indexRegistro = 0;
        $array_registros = array();
        while ($registro = $consultaSql->fetch_assoc()){
            foreach ($registro as $columna => $valor){
                $array_registros[$indexRegistro][$columna] = utf8_encode($valor);
            }
            $indexRegistro++;
        }
        return $array_registros;
    }

    /**
     * @param $tabla string nombre de la tabla a actualizar
     * @param $valoresUpdate recibir un arreglo de datos que contenga el nombre de la columna y su valor
     * @param $condicionales recibir un arreglo de datos que contenga el nombre de la columna y su valor
     * update $tabla set $valores where $condicionales
     */
    public function actualizarRegistro($tabla, $valoresUpdate, $condicionales)
    { //funcion1,
        $sqlSets = $this->obtenerValoresUpdate($valoresUpdate);
        $sqlWhere = $this->obtenerCondicionalesAnd($condicionales);
        $consultaUpdate = "UPDATE $tabla $sqlSets $sqlWhere";
        //var_dump($consultaUpdate);exit;
        return $this->queryNativa($consultaUpdate);
    }

    /**
     * @param $tabla
     * @param $valoresInsert
     * INSERT INTO tabla(columna1, columna2, ... ,columnaN) VALUES (valor1,valor2,...,valorN)
     */
    public function insertarRegistro($tabla, $valoresInsert)
    { //funcion2
        $valoresColumnas = $this->insertarValoresColumnas($valoresInsert);
        $queryInsert = "INSERT INTO " . $tabla . " (" . $valoresColumnas['columnas'] . ") VALUES (" . $valoresColumnas['valores'] . ")";
        return $this->queryNativa($queryInsert);
    }

    public function ultimoIdInsertado(){
        return $this->mysqli->insert_id;
    }

    /**
     * @param $tabla
     * @param $condionales
     * DELETE FROM $tabla WHERE condicionales
     */
    public function eliminarRegistro($tabla, $condionales)
    {
        $sqlWheres = $this->obtenerCondicionalesAnd($condionales);
        $consultaDelete = "DELETE FROM ".$tabla." ".$sqlWheres;
        return $this->queryNativa($consultaDelete);
    }

    public function queryNativa($querySQL)
    {
        try {
            $queryExecutada = $this->mysqli->query($querySQL);
            if($queryExecutada !== true){
                $this->errors = $this->mysqli->error_list;
            }
            return $queryExecutada;
        } catch (Exception $ex) {
            return false;
        }
    }

    public function getMsgErrors(){
        $msgErrors = array();
        foreach ($this->errors as $e){
            $msgErrors[] = "Code error: ".$e['errno']." Explicacion: ".$e['error'];
        }
        return $msgErrors;
    }

    //funcion privada para formatear los datos que se van actualizar en una tabla "SET"
    // array ('clave' => 'ecorona','nombres' => 'Luis Enrique') ----->
    // array(
    //    nombre_columna => valor,
    //    nombre_columna2 => valor,
    //    nombre_columna3 => valor,
    //    nombre_columna4 => valor,
    //    nombre_columna5 => valor
    //)
    // return "clave = 'ecorona', nombres = 'Luis Enrique'"
    private function obtenerValoresUpdate($valoresUpdate)
    {
        $sets = " SET";
        $index = 1;
        $max = sizeof($valoresUpdate);
        foreach ($valoresUpdate as $columna => $valor) {
            $valor = utf8_decode($valor);
            if ($index < $max) {
                $sets .= " $columna = '$valor',";
            } else {
                $sets .= " $columna = '$valor'";
            }
            $index++;
        }
        return $sets;
    }

    private function obtenerCondicionalesAnd($condicionales)
    {
        $condiciones = ' where 1=1';
        $index = 1;
        $max = sizeof($condicionales);
        foreach ($condicionales as $columna => $valor) {
            if ($index <= $max) {
                if (strpos($valor, '%') !== false) {
                    $condiciones .= " AND $columna LIKE '$valor'";
                } else {
                    $condiciones .= " AND $columna = '$valor'";
                }
            }
            $index++;
        }
        return $condiciones;
    }

    private function insertarValoresColumnas($valoresInsert)
    {
        $retorno = array();
        $nombres_columnas = "";
        $valores_columnas = "";
        $iteracion_campos = 1;
        $max_it_campos = sizeof($valoresInsert);
        foreach ($valoresInsert as $columna => $valor) {
            $nombres_columnas .= $columna;
            $valores_columnas .= "'" . $valor . "'";
            if ($iteracion_campos < $max_it_campos) {
                $nombres_columnas .= ",";
                $valores_columnas .= ",";
            }
            $iteracion_campos++;
        }
        $retorno['columnas'] = $nombres_columnas;
        $retorno['valores'] = $valores_columnas;
        return $retorno;
    }

}

/*$configDB = ConfigBD::getConfig();
$conexion = new mysqli(
    $configDB['host'],$configDB['user'],$configDB['password'],$configDB['database'],$configDB['port']
);

//$update = $conexion->query("UPDATE catalogo_contacto SET tipo = 'Redes sociales' WHERE id=3");
//$delete = $conexion->query("DELETE FROM catalogo_contacto WHERE id=4");
$insert = $conexion->query("INSERT INTO catalogo_contacto(tipo) values ('Nuevo cat')");
$consulta = $conexion->query("select * from catalogo_contacto");

$indexRegistro = 0;
$array_registros = array();
while ($registro = $consulta->fetch_assoc()){
    foreach ($registro as $columna => $valor){
        $array_registros[$indexRegistro][$columna] = $valor;
    }
    $indexRegistro++;
}

var_dump($array_registros);
*/
