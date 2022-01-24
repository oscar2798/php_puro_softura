$(document).ready(function () {

    //selector por tag <button>, por id
    $(document).on('click','#btnAgregarEmpleado',function(){
        $('#contenedorFormEmpleado').fadeIn();
        $('#tableroEmpleados').fadeOut();
        //llamar la funcion del js de catalogo -> obtener estado
        //Catalogos.obtener_catalogo_estado();
        $('#tituloFormEmpleado').html('Registrar un empleado');
        $('#formEmpleado')[0].reset();
        $('#inputIdEmpleado').val(0);
    });

    $(document).on('click','#btnGuardarEmpleado',function(){
        Empleados.guardarEmpleado();
    });

    $(document).on('click','#btnCancelarEmpleado',function(){
        $('#contenedorFormEmpleado').fadeOut();
        $('#tableroEmpleados').fadeIn();
    });

    //para el boton de modificar
    $(document).on('click','.btnModificarEmpleado',function(){
        var botonModificar = $(this);
        $('#contenedorFormEmpleado').fadeIn();
        $('#tableroEmpleados').fadeOut();
        //llamar la funcion del js de catalogo -> obtener estado
        //Catalogos.obtener_catalogo_estado();
        $('#tituloFormEmpleado').html('Modificar empleado');
        var empleado = JSON.parse(atob(botonModificar.data('str_empleado_obj')));
        $('#inputIdEmpleado').val(empleado.id);
        $('#inputClave').val(empleado.clave);
        $('#inputNombre').val(empleado.nombres);
        $('#inputPaterno').val(empleado.apellido_paterno);
        $('#inputMaterno').val(empleado.apellido_materno);
        $('#inputDireccion').val(empleado.direccion);
        $('#sltInputEstado').val(empleado.catalogo_estado_id);
    });

    //para abrir la modal
    $(document).on('click','.btnAgregarDatosContacto',function (){
        var botonModificar = $(this);
        $('#tbodyDatosContactoEmpleado').html('');
        var id_empleado = botonModificar.data('id_empleado');

        var nombre_empleado = botonModificar.data('nombre_empleado');
        var datosContacto = JSON.parse(atob(botonModificar.data('datos_contacto')));
        var html = '';
        datosContacto.forEach(function(item) {
            html = '<tr>' +
            '<td>' +
            '<select class="form-select slt_cat_contacto" id="slt_contacto_'+id_empleado+'_'+item.id+'">' +
                Catalogos.html_catalogo_contacto +
            '</select>' +
            '</td>' +
            '<td><input type="text" class="form-control" id="slt_input_contacto'+id_empleado+'_'+item.id+'" placeholder="Dato de contacto"></td>' +
            '<td>' +
                '<button type="button" class="btn btn-danger">eliminar</button>' +
            '</td>' +
        '</tr>';
        $('#tbodyDatosContactoEmpleado').append(html);
        $('#slt_contacto_'+id_empleado+'_'+item.id).val(item.catalogo_contacto_id);
        $('#slt_input_contacto'+id_empleado+'_'+item.id).val(item.dato_contacto);
        });
        $('#nombreEmpleado').html(nombre_empleado);
        //alert(nombre_empleado);
    });

    $(document).on('click','#agregarDatoContacto',function (){
        var html = '<tr>' +
                '<td>' +
                '<select class="form-select slt_cat_contacto">' +
                    Catalogos.html_catalogo_contacto +
                '</select>' +
                '</td>' +
                '<td><input type="text" class="form-control" placeholder="Dato de contacto"></td>' +
                '<td>' +
                    '<button type="button" class="btn btn-danger">eliminar</button>' +
                '</td>' +
            '</tr>';
        $('#tbodyDatosContactoEmpleado').append(html);
    });


    $(document).on('click','.btnEliminarEmpleado',function(){
        var botonEliminar = $(this);
        var id_empleado = botonEliminar.data('id_empleado_eliminar');
        Swal.fire({
            title: '¡Espera!',
            text: "¿Estas seguro/a de eliminar al empleado?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '¡Si, eliminar!',
            cancelButtonText: 'No, cancelar!',
          }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    type : 'POST', //tipo
                    url : host_backend+'peticion=empleados&funcion=eliminar',
                    data : {id:id_empleado},
                    dataType : 'json', //html, texto, xml, htm, json
                    success : function (respuestaAjax){
                          if(respuestaAjax.success) {
                            Swal.fire(
                                '¡Eliminado!',
                                'Se elimino el empleado correctamente',
                                'success'
                              )
                            Empleados.listadoEmpleados();
                        }else{
                            var html_mensajes = '';
                            respuestaAjax.msg.forEach(function(mensaje){
                                html_mensajes += '<li>'+mensaje+'</li>';
                            });
                            $('#divMensajesSistema').html(html_mensajes).fadeIn();
                            setTimeout(function(){
                                $('#divMensajesSistema').html('').fadeOut();
                            },10000);
                        }
                        
                    },error : function (err){
                        
        
                        alert('error en la peticion de catalogos');
                    }
                });
              
            }
          })
            
        
    });

    Empleados.listadoEmpleados();

});

var Empleados = {

    listadoEmpleados : function(){
        $('#tbodyResultadosEmpleados').html('<tr><td colspan="5" class="text-center">Procesando...</td></tr>');
        $.ajax({
            type : 'POST', //tipo
            url : host_backend+'peticion=empleados&funcion=listado',
            //data : $('#formEmpleado').serialize(),
            data : {},
            dataType : 'json', //html, texto, xml, htm, json
            success : function (respuestaAjax){
                if(respuestaAjax.success) {
                    var html_registros_empleados = '';
                    respuestaAjax.data.empleados.forEach(function(empleado){
                        var strEmpleadoObj = btoa(JSON.stringify(empleado));
                        var strEmpleadoContacto = btoa(JSON.stringify(empleado.datos_contacto));
                        var strDatoscontado = '';
                        empleado.datos_contacto.forEach(function(contacto){
                            strDatoscontado += '<li> '+contacto.tipo+': '+contacto.dato_contacto+'</li>';
                        });
                        html_registros_empleados += '<tr>' +
                                '<td>'+empleado.clave+'</td>' +
                                '<td>'+empleado.nombres+' '+empleado.apellido_paterno+' '+empleado.apellido_materno+'</td>' +
                                '<td>'+empleado.direccion+'</td>' +
                                '<td>'+
                                    '<button type="button" class="btn btn-secondary btnAgregarDatosContacto" ' +
                                    'data-bs-toggle="modal" data-bs-target="#modalFormDatosContacto"' +
                                    'data-id_empleado="'+empleado.id+'" data-nombre_empleado="'
                                    +empleado.nombres+' '+empleado.apellido_paterno+' '+empleado.apellido_materno +
                                    '" data-datos_contacto="'+strEmpleadoContacto+'">Visualizar datos</button>'+
                                '</td>' +
                                '<td>' +
                                    '<button type="button" data-str_empleado_obj="'+strEmpleadoObj+'"' +
                                        'class="btn btn-warning btnModificarEmpleado" style="margin-right: 10px;">Modificar</button>' +
                                    '<button type="button" data-id_empleado_eliminar="'+empleado.id+'" ' +
                                    'class="btn btn-danger btnEliminarEmpleado" id="id_empleado_delete'+empleado.id+'" data-str_empleado_id="'+strEmpleadoObj+'">Eliminar</button>' +
                                '</td>' +
                            '</tr>';
                    });
                    $('#tbodyResultadosEmpleados').html(html_registros_empleados);
                }
            },error : function (err){
                alert('error en la peticion de catalogos');
            }
        });
    },

    guardarEmpleado : function(){
        $.ajax({
            type : 'post', //tipo
            url : host_backend+'peticion=empleados&funcion=nuevoActualizar',
            // data : {
            //     id : $('#inputIdEmpleado').val(),
            //     clave : $('#inputClave').val(),
            //     nombres : $('#inputNombre').val(),
            //     apellido_paterno : $('#inputPaterno').val(),
            //     apellido_materno : $('#inputMaterno').val(),
            //     direccion : $('#inputDireccion').val(),
            //     catalogo_estado_id : $('#sltInputEstado').val()
            // },//datos del formulario o body-postman
            data : $('#formEmpleado').serialize(),
            dataType : 'json', //html, texto, xml, htm, json
            success : function (respuestaAjax){
                if(respuestaAjax.success) {
                    $('#contenedorFormEmpleado').fadeOut();
                    $('#tableroEmpleados').fadeIn();
                    Empleados.listadoEmpleados();
                }else{
                    var html_mensajes = '';
                    respuestaAjax.msg.forEach(function(mensaje){
                        html_mensajes += '<li>'+mensaje+'</li>';
                    });
                    $('#divMensajesSistema').html(html_mensajes).fadeIn();
                    setTimeout(function(){
                        $('#divMensajesSistema').html('').fadeOut();
                    },10000);
                }
            },error : function (err){
                alert('error en la peticion de catalogos');
            }
        });
    },

    
}
