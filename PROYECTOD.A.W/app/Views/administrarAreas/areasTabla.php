<style>
    .editBtn {
        width: 55px;
        height: 55px;
        border-radius: 20px;
        border: none;
        background-color: rgb(52, 132, 236);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.123);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
    }

    .editBtn::before {
        content: "";
        width: 200%;
        height: 200%;
        background-color: rgb(102, 102, 141);
        position: absolute;
        z-index: 1;
        transform: scale(0);
        transition: all 0.3s;
        border-radius: 50%;
        filter: blur(10px);
    }

    .editBtn:hover::before {
        transform: scale(1);
    }

    .editBtn:hover {
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.336);
    }

    .editBtn svg {
        height: 17px;
        fill: white;
        z-index: 3;
        transition: all 0.2s;
        transform-origin: bottom;
    }

    .editBtn:hover svg {
        transform: rotate(-15deg) translateX(5px);
    }

    .editBtn::after {
        content: "";
        width: 25px;
        height: 1.5px;
        position: absolute;
        bottom: 19px;
        left: -5px;
        background-color: white;
        border-radius: 2px;
        z-index: 2;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.5s ease-out;
    }

    .editBtn:hover::after {
        transform: scaleX(1);
        left: 0px;
        transform-origin: right;
    }
</style>
<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check-circle-fill" viewBox="0 0 16 16">
        <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
    <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
        <path
            d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z" />
    </symbol>
</svg>
<h1 class="mb-5" align="center">Áreas registradas</h1>

<div class="container ">
    <div class="row">
        <div class="col-12">

            <div class="container mb-3" style="background-color:white;height:40px; border-radius:7px;">
                <div class="row">
                    <div class="col-2">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#formAgregar" style="position:absolute;left:16.2%;">
                            Registrar nueva área
                        </button>
                        <a href="<?= base_url('/reporteAreas'); ?>" style="position:absolute;left:65.5%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Descargar reporte de áreas
                            </button>
                        </a>
                        <a href="<?= base_url('/Administrador/buscarArea'); ?>" style="position:absolute;left:78%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Buscar área
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <?php
            if (isset($validation)) {
                print $validation->listErrors();
            }
            if (isset($mensaje)) {
                echo '<div class="alert alert-success d-flex align-items-center" role="alert">
                <svg style="width:50px;height:50px;" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>El área <strong style="font-size:24px;">' . $nombre . '</strong>' . $mensaje . "</div></div>";
            }
            if (isset($mensajeEditar) && $nombre != null) {
                echo '<div class="alert alert-warning d-flex align-items-center" role="alert">
                <svg style="width:50px;height:50px;" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>El área <strong style="font-size:24px;">' . $nombre . '</strong>' . $mensajeEditar . "</div></div>";
            }
            if (isset($mensajeEliminar) && $nombre != null) {
                echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg style="width:50px;height:50px;" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>El área <strong style="font-size:24px;">' . $nombre . '</strong>' . $mensajeEliminar . "</div></div>";
            }
            ?>
            <table class='table table-stripped'>
                <thead>
                    <tr>
                        <th style="background-color: #fa6900;">Encargado</th>
                        <th style="background-color: #fa6900;">Nombre</th>
                        <th style="background-color: #fa6900;">Nivel de acceso</th>
                        <th style="background-color: #fa6900;">Estado</th>
                        <th style="background-color: #fa6900;">Especificaciones</th>
                        <th style="background-color: #fa6900;">Editar</th>
                        <th style="background-color: #fa6900;">Eliminar</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($areas as $area): ?>
                        <tr>
                            <td>
                                <?php $db = \Config\Database::connect();
                                $query = "SELECT nombre, apellido_Paterno, apellido_Materno FROM empleados WHERE idEmpleado = $area->encargado";
                                $resultado = $db->query($query)->getResultArray();
                                echo $resultado[0]["nombre"] . " " . $resultado[0]["apellido_Paterno"] . " " . $resultado[0]["apellido_Materno"]; ?>
                            </td>
                            <td>
                                <?= $area->nombre ?>
                            </td>
                            <td>
                                <?= $area->nivelAcceso ?>
                            </td>
                            <td>
                                <?= $area->estado ?>
                            </td>
                            <td style="width:130px"><a
                                    href="<?= base_url('/Administrador/especificacionesArea/' . $area->idArea); ?>"
                                    style="display:flex;justify-content:center;max-width:50px;margin-right: -100px;">
                                    <img src="\icons\especs.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Administrador/editArea/' . $area->idArea); ?>">
                                    <img src="\icons\editar.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Administrador/delArea/' . $area->idArea); ?>">
                                    <img src="\icons\del.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            Se muestran
            <?= count($areas) ?> registros de un total de
            <?= $registros ?>
            <?= $pager->links(); ?>
        </div>
    </div>
</div>


<!-- Modal para AGREGAR un registro -->

<div class="modal fade" id="formAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar área</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/Administrador/areasTabla" method="post" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Encargado</legend>
                                <div class="mb-3">
                                    <select name="encargado" class="form-control">
                                        <?php foreach ($empleados as $empleado): ?>
                                            <option value="<?= $empleado->idEmpleado ?>">
                                                <?= $empleado->nombre . " " . $empleado->apellido_Paterno . " " . $empleado->apellido_Materno ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Ilustración del área</legend>
                                <div class="mb-3">
                                    <input type="file" class="form-control" name="imagen">
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Nombre y descripción</legend>
                                <div class="mb-3">
                                    <label for="nombre">Nombre del área</label>
                                    <input type="text" name="nombre" id="nombre" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="descripcion">Descripción</label>
                                    <textarea name="descripcion" id="descripcion" class="form-control"
                                        rows="3"></textarea>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Características</legend>
                                <div class="mb-3">
                                    <label for="tamanio">Tamaño en M²</label>
                                    <input type="text" name="tamanio" id="tamanio" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="temperatura">Temperatura (°C)</label>
                                    <input type="text" name="temperatura" id="temperatura" class="form-control">
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Acceso y estado</legend>
                                <div class="mb-3">
                                    <label for="nivelAcceso">Nivel de acceso:</label>
                                    <select name="nivelAcceso" id="nivelAcceso" class="form-control">
                                        <option value="Privado">Privado</option>
                                        <option value="Público">Público</option>
                                        <option value="Solo personal">Solo personal</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="estado">Estado:</label>
                                    <select name="estado" id="estado" class="form-control">
                                        <option value="Disponible">Disponible</option>
                                        <option value="Ocupado">Ocupado</option>
                                        <option value="Mantenimiento">Mantenimiento</option>
                                        <option value="Remodelación">Remodelación</option>
                                        <option value="Limpieza">Limpieza</option>
                                    </select>
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Mantenimiento</legend>
                                <div class="mb-3">
                                    <label for="horaMantenimiento">Hora de mantenimiento:</label>
                                    <input type="time" name="horaMantenimiento" id="horaMantenimiento"
                                        class="form-control">
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Características ambientales</legend>
                                <div class="mb-3">
                                    <label for="phPromedio">PH promedio:</label>
                                    <input type="text" name="phPromedio" id="phPromedio" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="iluminacion">Iluminación utilizada:</label>
                                    <input type="text" name="iluminacion" id="iluminacion" class="form-control">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Otros datos</legend>
                                <div class="mb-3">
                                    <label for="filtracionAgua">Tipo de filtración del agua:</label>
                                    <input type="text" name="filtracionAgua" id="filtracionAgua" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="noHabitantesMax">Número máximo de habitantes admitidos:</label>
                                    <input type="number" name="noHabitantesMax" id="noHabitantesMax"
                                        class="form-control">
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
            <div class="modal-footer">
            </div>
        </div>
    </div>
</div>