<?php

$arreglo = array(
    //columa  => valor
    'id' => 1,
    'nombre' => 'enrique',
    'apellido_paterno' => 'corona'
);
/** valores update */
var_dump($arreglo);
$concatenar_str = 'SET';
$iteracion_campos = 1;$max_campos = sizeof($arreglo);
var_dump($max_campos);
foreach ($arreglo as $indece => $valor){
    //$concatenar_str .= '--- INDICE: '.$indece.' VALOR: '.$valor;
    $concatenar_str .= ' '.$indece . ' = '."'".$valor."'";
    //terna: es una expresion booleana como el if pero sin necesidad de poner el if ni el else
    //condicion ? valor_verdadero : valor si falso
    //$index == $max ? var_dump('llegue al final') : var_dump('hay mas datos despues');
    $iteracion_campos < $max_campos ? $concatenar_str .= ', ' : false;
    $iteracion_campos++;
}
echo $concatenar_str;
var_dump($concatenar_str);

/** sql para el insert */
$valores = array(
    'clave' => 'chernandez',
    'nombres' => 'Carla',
    'apellido_paterno' => 'Hernandez',
    'direccion' => 'no se, se que vive en apizaco'
);

$nombres_columnas = "";
$valores_columnas = "";
$iteracion_campos = 1; $max_it_campos = sizeof($valores);
foreach ($valores as $columna => $valor){
    $nombres_columnas .= $columna;
    $valores_columnas .= "'".$valor."'";
    if($iteracion_campos < $max_it_campos){
        $nombres_columnas .= ",";
        $valores_columnas .= ",";
    }
    $iteracion_campos++;
}

$sql_insert = "INSERT INTO empleado(".$nombres_columnas.") VALUES (".$valores_columnas.")";
var_dump($valores,$sql_insert);

//JSON, es un texto plano STRING; lenguajes de programacion se trata como un objecto de datos (muy grande)
//clave => valor
//CLAVE => PUEDEN SER numeros, palabra
//valor => numero, string, decimal, bits, array, objeto
/**
 * iniciar con una llave y cerrar con una llave, entre clave y valor entrar los dos puntos ":"
 */
$json = json_encode($valores);
var_dump($json);
$json_decodificado_obj = json_decode($json);
$json_decodificado_array = json_decode($json,true);
var_dump($json_decodificado_obj,$json_decodificado_array);