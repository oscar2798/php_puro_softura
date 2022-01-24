<?php

//header('Content-Type: application/json; charset=utf-8');

include_once "../controlador/CatalogosController.php";
include_once "../controlador/EmpleadosController.php";

$peticion = $_GET['peticion'];
$funcion = $_GET['funcion'];
$data = $_POST;

$catalogoController = new CatalogosController();
$empleadoController = new EmpleadosController();

if(isset($_GET['peticion']) && $_GET['peticion'] != '' && isset($_GET['funcion']) && $_GET['funcion'] != ''){
    switch ($peticion){
        //peticion para obtener los catalogos
        case 'catalogos':
            switch ($funcion){
                //rutas de contacto
                case 'contacto':
                    $resultado = $catalogoController->catalogoContacto();
                    echo json_encode($resultado);
                    break;
                case 'guardar_contacto':
                    $resultado = $catalogoController->actualizarCatalogoContacto($data);
                    echo json_encode($resultado);
                    break;
                case 'estado':
                    $resultado = $catalogoController->catalogoEstado();
                    echo json_encode($resultado);
                    break;
                default:
                    echo json_encode(array(
                        'success' => false,
                        'msg' => array(
                            'Error, no encontre la peticion solicitada'
                        )
                    ));
                    break;
            }
            break;
        //peticion para obtener y realizar las funciones correspondientes a los empleados
        case 'empleados':
            switch ($funcion){
                case 'listado':
                    $resultado = $empleadoController->obtenerEmpleados();
                    echo json_encode($resultado);
                    break;
                case 'nuevoActualizar':
                    //realizar las funciones correspondientes de guardar un empleados
                    //considerar validaciones de campos
                    //http_response_code(201);
                    $resultado = $empleadoController->guardarEmpleado($data);
                    //$resultado['success'] ? http_response_code(201) : http_response_code(400);
                    echo json_encode($resultado);
                    break;
                case 'eliminar':
                    //realizar las funciones para eliminar un empleado
                    $resultado = $empleadoController->eliminarEmpleado($data);
                    echo json_encode($resultado);
                    break;
                default:
                    http_response_code(404);
                    echo json_encode(array(
                        'success' => false,
                        'msg' => array(
                            'Error, no encontre la peticion solicitada'
                        )
                    ));
                    break;
            }
            break;

        default:
            http_response_code(404);
            echo json_encode(array(
                'success' => false,
                'msg' => array(
                    'Error, no encontre la peticion solicitada'
                )
            ));
            break;
    }
}else{
    http_response_code(404);
    echo json_encode(array(
        'success' => false,
        'msg' => array(
            'Error, no encontre la peticion solicitada'
        )
    ));
}


