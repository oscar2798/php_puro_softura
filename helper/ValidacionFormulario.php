<?php

class ValidacionFormulario{

    public static function validarFormEmpleado($datosFormulario){
        $validacion['status'] = true;
        $validacion['msg'] = array();
        if(!isset($datosFormulario['id'])){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El identificador del empleado es requerido';
        }if(!isset($datosFormulario['clave']) || $datosFormulario['clave'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El clave del empleado es requerido';
        }if(!isset($datosFormulario['nombres']) || $datosFormulario['nombres'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El nombre(s) del empleado es requerido';
        }if(!isset($datosFormulario['apellido_paterno']) || $datosFormulario['apellido_paterno'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El apellido paterno del empleado es requerido';
        }if(!isset($datosFormulario['apellido_materno']) || $datosFormulario['apellido_materno'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El apellido materno del empleado es requerido';
        }if(!isset($datosFormulario['direccion']) || $datosFormulario['direccion'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El campo direccion del empleado es requerido';
        }if(!isset($datosFormulario['catalogo_estado_id']) || $datosFormulario['catalogo_estado_id'] == ''){
            $validacion['status'] = false;
            $validacion['msg'][] = 'El campo estado del empleado es requerido';
        }
        return $validacion;
    }

}