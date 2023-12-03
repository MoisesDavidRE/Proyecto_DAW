<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check-circle-fill" viewBox="0 0 16 16">
        <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
</svg>

<h1 class="mb-5" align="center">Reservaciones registradas</h1>

<div class="container ">
    <div class="row">
        <div class="col-12">

            <div class="container mb-3" style="background-color:white;height:40px; border-radius:7px;">
                <div class="row">
                    <div class="col-2">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#formAgregar" style="position:absolute;left:16.2%;">
                            Registrar nueva reservación
                        </button>
                        <a href="<?= base_url('/reporteReservaciones'); ?>" style="position:absolute;left:59.5%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Descargar reporte de reservaciones
                            </button>
                        </a>
                        <a href="<?= base_url('/Administrador/buscarReservacion'); ?>"
                            style="position:absolute;left:75.5%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Buscar reservación
                            </button>
                        </a>
                    </div>
                </div>
            </div>
            <?php
            $db = \Config\Database::connect();
            if (isset($validation)) {
                print $validation->listErrors();
            }
            if (isset($mensaje)) {
                $query = "SELECT nombre, apellido_Paterno, apellido_Materno FROM usuario WHERE numeroControl = $usr";
                $resultado = $db->query($query)->getResultArray();
                $nombre = $resultado[0]["nombre"] . " " . $resultado[0]["apellido_Paterno"] . " " . $resultado[0]["apellido_Materno"];
                echo '<div class="alert alert-success d-flex align-items-center" role="alert">
                <svg style="width:50px;height:50px;" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>La reservación de <strong style="font-size:24px;">' . $nombre . '</strong>' . $mensaje . "</div></div>";
            }
            ?>
            <table class='table table-stripped'>
                <thead>
                    <tr>
                        <th style="background-color: #fa6900;">Usuario que reservó</th>
                        <th style="background-color: #fa6900;">Estatus de la reservación</th>
                        <th style="background-color: #fa6900;">Fecha reservada</th>
                        <th style="background-color: #fa6900;">Especificaciones</th>
                        <th style="background-color: #fa6900;">Editar</th>
                        <th style="background-color: #fa6900;">Eliminar</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($reservaciones as $reservacion): ?>
                        <tr>
                            <td>
                                <?php
                                $query = "SELECT nombre, apellido_Paterno, apellido_Materno FROM usuario WHERE numeroControl = $reservacion->usuario";
                                $resultado = $db->query($query)->getResultArray();
                                echo $resultado[0]["nombre"] . " " . $resultado[0]["apellido_Paterno"] . " " . $resultado[0]["apellido_Materno"]; ?>
                            </td>
                            <td>
                                <?= $reservacion->estatus ?>
                            </td>
                            <td>
                                <?= $reservacion->fechaReservada ?>
                            </td>
                            <td><a href="<?= base_url('/Administrador/reservacionEspecificaciones/' . $reservacion->idReservacion); ?>"
                                    style="display:flex;justify-content:center;max-width:50px;margin-right: -100px;">
                                    <img src="\icons\especs.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Administrador/editReservacion/' . $reservacion->idReservacion); ?>">
                                    <img src="\icons\editar.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Administrador/delReservacion/' . $reservacion->idReservacion); ?>">
                                    <img src="\icons\del.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            Se muestran
            <?= count($reservaciones) ?> registros de un total de
            <?= $registros ?>
            <?= $pager->links(); ?>
        </div>
    </div>
</div>


<!-- Modal para AGREGAR un registro -->

<div class="modal fade" id="formAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar área</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/Administrador/reservacionesTabla" method="post" action="cargar.php"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="atraccion_animal" class="form-label">Nombre de la atraccion a escojer</label>
                        <select name="atraccion_animal" class="form-control">
                            <?php foreach ($atraccionesAnimal as $atraccionAn): ?>
                                <option value="<?= $atraccionAn->id ?>">
                                    <?= $atraccionAn->nombre ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <select name="usuario" class="form-control">
                            <?php foreach ($usuarios as $atraccion): ?>
                                <option value="<?= $atraccion->numeroControl ?>">
                                    <?= $atraccion->nombre . " " . $atraccion->apellido_Paterno . " " . $atraccion->apellido_Materno ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fechaReservada" class="form-label">Fecha de reservación</label>
                        <input type="date" name="fechaReservada" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="horaInicio" class="form-label">Hora de inicio</label>
                        <input type="time" name="horaInicio" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="horaFin" class="form-label">Hora de finalización</label>
                        <input type="time" name="horaFin" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="estatus" class="form-label">Nivel de acceso</label>
                        <select name="estatus" class="form-control">
                            <option value="Confirmado">Confirmado</option>
                            <option value="En revisión">En revisión</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="costoTotal" class="form-label">Monto total de la reservación</label>
                        <input type="text" name="costoTotal">
                    </div>

                    <div class="mb-3">
                        <label for="comentariosAdicionales" class="form-label">Comentarios adicionales</label>
                        <input type="text" name="comentariosAdicionales" class="form-control">
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