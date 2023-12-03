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
                <div><strong style="font-size:24px;">' . $nombre . '</strong>' . $mensaje . "</div></div>";
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
                            <td style="width:130px"><a href="<?= base_url('/Administrador/especificacionesArea/' . $area->idArea); ?>"
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
            Se muestran <?=count($areas) ?> registros de un total de <?=$registros?>
            <?= $pager->links(); ?>
        </div>
    </div>
</div>


<!-- Modal para AGREGAR un registro -->

<div class="modal fade" id="formAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel" align="center">Registrar área</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/Administrador/areasTabla" method="post" action="cargar.php" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="encargado" class="form-label">Encargado</label>
                        <select name="encargado" class="form-control">
                            <?php foreach ($empleados as $empleado): ?>
                                <option value="<?= $empleado->idEmpleado ?>">
                                    <?= $empleado->nombre . " " . $empleado->apellido_Paterno . " " . $empleado->apellido_Materno ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="col-sm-12">
                        <label class="form-label" for="ilustracion">Ilustración del animal</label>
                        <input type="file" class="form-control" name="ilustracion">
                    </div>


                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="tamanio" class="form-label">Tamaño en M²</label>
                        <input type="text" name="tamanio" id="tamanio" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="temperatura" class="form-label">Temperatura en grados Celcius</label>
                        <input type="text" name="temperatura" id="temperatura" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="nivelAcceso" class="form-label">Nivel de acceso</label>
                        <select name="nivelAcceso" id="nivelAcceso" class="form-control">
                            <option value="Privado">Privado</option>
                            <option value="Público">Público</option>
                            <option value="Solo personal">Solo personal</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select name="estado" id="estado" class="form-control">
                            <option value="Mantenimiento">Privado</option>
                            <option value="Remodelación">Público</option>
                            <option value="Limpieza">Solo personal</option>
                            <option value="Disponible">Disponible</option>
                            <option value="Ocupado">Ocupado</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="horaMantenimiento" class="form-label">Hora de mantenimiento</label>
                        <input type="time" name="horaMantenimiento" id="horaMantenimiento" class="form-control">
                    </div>


                    <div class="mb-3">
                        <label for="phPromedio" class="form-label">PH Promedio</label>
                        <input type="text" name="phPromedio" id="phPromedio" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="iluminacion" class="form-label">Iluminación utilizada</label>
                        <input type="text" name="iluminacion" id="iluminacion" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="filtracionAgua" class="form-label">Tipo de filtración del agua</label>
                        <input type="text" name="filtracionAgua" id="filtracionAgua" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="noHabitantesMax" class="form-label">Número máximo de habitantes admitidos</label>
                        <input type="number" name="noHabitantesMax" id="noHabitantesMax" class="form-control">
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