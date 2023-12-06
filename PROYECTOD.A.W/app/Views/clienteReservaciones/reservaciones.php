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
            if (isset($mensajeEliminar) && $usr != null) {
                $query = "SELECT nombre, apellido_Paterno, apellido_Materno FROM usuario WHERE numeroControl = $usr";
                $resultado = $db->query($query)->getResultArray();
                $nombre = $resultado[0]["nombre"] . " " . $resultado[0]["apellido_Paterno"] . " " . $resultado[0]["apellido_Materno"];
                echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg style="width:50px;height:50px;" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>La reservación de <strong style="font-size:24px;">' . $nombre . '</strong>' . $mensajeEliminar . "</div></div>";
            }
            if (isset($mensajeEditar) && $usr != null) {
                $query = "SELECT nombre, apellido_Paterno, apellido_Materno FROM usuario WHERE numeroControl = $usr";
                $resultado = $db->query($query)->getResultArray();
                $nombre = $resultado[0]["nombre"] . " " . $resultado[0]["apellido_Paterno"] . " " . $resultado[0]["apellido_Materno"];
                echo '<div class="alert alert-warning d-flex align-items-center" role="alert">
                <svg style="width:50px;height:50px;" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>La reservación de <strong style="font-size:24px;">' . $nombre . '</strong>' . $mensajeEditar . "</div></div>";
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
                    <?php $session = \Config\Services::session(); foreach ($reservaciones as $reservacion): ?>
                        <?php if($session->get('idUsuario')==$reservacion->usuario):?>
                        <tr>
                            <td>
                                <?php
                                $session = \Config\Services::session();
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
                            <td><a href="<?= base_url('/Cliente/reservacionEspecificaciones/' . $reservacion->idReservacion); ?>"
                                    style="display:flex;justify-content:center;max-width:50px;margin-right: -100px;">
                                    <img src="\icons\especs.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Cliente/editReservacion/' . $reservacion->idReservacion); ?>">
                                    <img src="\icons\editar.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Cliente/delReservacion/' . $reservacion->idReservacion); ?>">
                                    <img src="\icons\del.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                        </tr>

                    <?php endif; endforeach; ?>
                </tbody>
            </table>
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
                        <label for="atraccion" class="form-label">Nombre de la atraccion a escojer</label>
                        <select name="atraccion" class="form-control">
                            <?php foreach ($atracciones as $atraccion): ?>
                                <option value="<?= $atraccion->idAtraccion ?>">
                                    <?php $query = "SELECT nombre FROM atraccion WHERE idAtraccion = $reservacion->atraccion";
                                $resultado = $db->query($query)->getResultArray();
                                echo $resultado[0]["nombre"]; ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="usuario" class="form-label">Usuario</label>
                        <select name="usuario" class="form-control">
                            <?php foreach ($usuarios as $usuario): ?>
                                <option value="<?= $usuario->numeroControl ?>">
                                    <?= $usuario->nombre . " " . $usuario->apellido_Paterno . " " . $usuario->apellido_Materno ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="fechaReservada" class="form-label">Fecha de reservación</label>
                        <input type="date" class="form-control" name="fechaReservada" pattern="^(Mon|Wed|Fri)$">

                    </div>

                    <div class="mb-3">
                        <label for="estatus" class="form-label">Estatus de la reservación</label>
                        <select name="estatus" class="form-control">
                            <option value="Confirmado">Confirmado</option>
                            <option value="En revisión">En revisión</option>
                        </select>
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