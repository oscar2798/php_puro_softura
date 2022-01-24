$(document).ready(function () {

    Catalogos.obtener_catalogo_contacto();
    Catalogos.obtener_catalogo_estado();

});

var Catalogos = {

    html_catalogo_contacto : '',

    obtener_catalogo_estado : function(){
        //peticion ajax
        $.ajax({
            type : 'post', //tipo
            //url : '../rutas/empleados.php?peticion=catalogos&funcion=estado',
            url : host_backend+'peticion=catalogos&funcion=estado',
            data : {},//datos del formulario o body-postman
            dataType : 'json', //html, texto, xml, htm, json
            success : function (respuestaAjax){
                if(respuestaAjax.success) {
                    var html_listado_estado = '<option value="">--Seleccione estado--</option>'
                    respuestaAjax.data.catalogo_estado.forEach(function(elemento){
                        html_listado_estado += '<option value="'+elemento.id+'">'+elemento.nombre+'</option>';
                    });
                    $('#sltInputEstado').html(html_listado_estado);
                }
            },error : function (err){
                alert('error en la peticion de catalogos');
            }
        });
    },

    obtener_catalogo_contacto : function(){
        $.ajax({
            type : 'post', //tipo
            //url : '../rutas/empleados.php?peticion=catalogos&funcion=estado',
            url : host_backend+'peticion=catalogos&funcion=contacto',
            data : {},//datos del formulario o body-postman
            dataType : 'json', //html, texto, xml, htm, json
            success : function (respuestaAjax){
                if(respuestaAjax.success) {
                    var html_listado_contacto = '<option value="">--Seleccione contacto--</option>'
                    respuestaAjax.data.catalogo_contacto.forEach(function(elemento){
                        html_listado_contacto += '<option value="'+elemento.id+'">'+elemento.tipo+'</option>';
                    });
                    Catalogos.html_catalogo_contacto = html_listado_contacto;
                }
            },error : function (err){
                alert('error en la peticion de catalogos');
            }
        });
    }

}