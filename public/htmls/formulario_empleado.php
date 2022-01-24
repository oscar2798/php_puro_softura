<div class="row" id="contenedorFormEmpleado" style="display: none">
    <div class="col">

    </div>
    <div class="col-6">
        <div class="card">
            <div class="card-header" id="tituloFormEmpleado">
                Registrar un empleado
            </div>
            <div class="card-body">
                <form id="formEmpleado" method="post">
                    <input type="hidden" id="inputIdEmpleado" name="id" value="0">
                    <div class="mb-3">
                        <label for="inputClave" class="form-label">Clave empleado</label>
                        <input type="text" class="form-control" id="inputClave" name="clave">
                    </div>
                    <div class="mb-3">
                        <label for="inputNombre" class="form-label">Nombre completo</label>
                        <input type="text" class="form-control" id="inputNombre" name="nombres">
                    </div>
                    <div class="mb-3">
                        <label for="inputPaterno" class="form-label">Apellido paterno</label>
                        <input type="text" class="form-control" id="inputPaterno" name="apellido_paterno">
                    </div>
                    <div class="mb-3">
                        <label for="inputMaterno" class="form-label">Apellido materno</label>
                        <input type="text" class="form-control" id="inputMaterno" name="apellido_materno">
                    </div>
                    <div class="mb-3">
                        <label for="inputDireccion" class="form-label">Dirección</label>
                        <input type="text" class="form-control" id="inputDireccion" name="direccion">
                    </div>
                    <div class="mb-3">
                        <label for="sltInputEstado" class="form-label">Estado</label>
                        <select id="sltInputEstado" class="form-select" name="catalogo_estado_id">
                            <option value="">--Seleccione--</option>
                        </select>
                    </div>

                    <div class="mb-3 text-center">
                        <button type="button" class="btn btn-success" id="btnGuardarEmpleado">Guardar</button>
                        <button type="button" class="btn btn-danger" id="btnCancelarEmpleado">Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col">

    </div>
</div>
