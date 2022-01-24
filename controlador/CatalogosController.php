<?php

//1.- consumir el modelo
include_once "../modelo/CatalogoContactoModel.php";
include_once "../modelo/EstadoModel.php";

class CatalogosController {

    /**
     * operaciones necesarias para poder manipular el sistema
     * obtener registros
     * insertar registrsos
     * actualizar
     * eliminar
     */
    public function catalogoContacto(){
        try{
            $catalogoContacoModel = new CatalogoContactoModel();
            $registrosCatalogo = $catalogoContacoModel->obtenerRegistros();
            $respuesta = array(
                'success' => true,
                'data' => array(
                    'catalogo_contacto' => $registrosCatalogo
                )
            );
            return $respuesta;
        }catch (Exception $ex){
            $respuesta = array(
                'success' => false,
                'msg' => array(
                    utf8_encode('Ocurrio un error en el servidor, intentar más tarde'),
                    $ex->getMessage()
                )
            );
            return $respuesta;
        }
    }

    public function actualizarCatalogoContacto($datosFormulario){
        try{
            $calogoContactoModel = new CatalogoContactoModel();
            $guardar = $calogoContactoModel->actualizar($datosFormulario,array('id' => $datosFormulario['id']));
            if($guardar){
                $respuesta = array(
                    'success' => true,
                    'msg' => array(
                        'Se actualizo el catalogo contacto correctamente'
                    )
                );
            }else{
                $respuesta = array(
                    'success' => false,
                    'msg' => array(
                        'No fue posible actualizar el catalogo contacto correctamente'
                    )
                );
            }
            return $respuesta;
        }catch (Exception $ex){
            $respuesta = array(
                'success' => false,
                'msg' => array(
                    utf8_encode('Ocurrio un error en el servidor, intentar más tarde'),
                    $ex->getMessage()
                )
            );
            return $respuesta;
        }
    }

    public function catalogoEstado(){
        try{
            $estadoModel = new EstadoModel();
            $resgistrosCatalogo = $estadoModel->obtenerRegistros();
            $respuesta = array(
                'success' => true,
                'data' => array(
                    'catalogo_estado' => $resgistrosCatalogo
                )
            );
            return $respuesta;
        }catch (Exception $ex){
            $respuesta = array(
                'success' => false,
                'msg' => array(
                    utf8_encode('Ocurrio un error en el servidor, intentar más tarde'),
                    $ex->getMessage()
                )
            );
            return $respuesta;
        }
    }

}