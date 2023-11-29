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

<h1 class="mb-5">Reservaciones registradas</h1>

<div class="container ">
    <div class="row">
        <div class="col-12">
            <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#formAgregar">
                Registrar nueva reservación
            </button>
            <?php
            if (isset($validation)) {
                print $validation->listErrors();
            }
            ?>
            <table class='table table-stripped'>
                <thead>
                    <tr>
                        <th>Usuario que reservó</th>
                        <th>Estatus de la reservación</th>
                        <th>Fecha reservada</th>
                        <th>Especificaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reservaciones as $reservacion): ?>
                        <tr>
                            <td>
                            <?php $db = \Config\Database::connect();
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
                                    <lord-icon src="https://cdn.lordicon.com/rwtswsap.json" trigger="hover"
                                        colors="primary:#3080e8" style="width:50px;height:50px">
                                    </lord-icon>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Administrador/editReservacion/' . $reservacion->idReservacion); ?>">
                                    <button class="editBtn">
                                        <svg height="1em" viewBox="0 0 512 512">
                                            <path
                                                d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                                            </path>
                                        </svg>
                                    </button>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Administrador/delReservacion/' . $reservacion->idReservacion); ?>">
                                    <lord-icon src="https://cdn.lordicon.com/skkahier.json" trigger="hover"
                                        colors="primary:#3080e8" style="width:50px;height:50px">
                                    </lord-icon>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
                <form action="/Administrador/agregarReservacion" method="post" action="cargar.php" enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="mb-3">
                        <label for="atraccion_animal" class="form-label">Nombre de la atraccion a escojer</label>
                        <select name="atraccion_animal" class="form-control">
                            <?php foreach ($atraccionesAnimal as $atraccionAn): ?>
                                <option value="<?= $atraccionAn->id?>">
                                    <?= $atraccionAn->nombre?>
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