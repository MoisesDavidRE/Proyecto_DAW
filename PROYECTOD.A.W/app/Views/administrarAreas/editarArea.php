<style>
    button {
        width: 150px;
        height: 50px;
        cursor: pointer;
        display: flex;
        align-items: center;
        background: red;
        border: none;
        border-radius: 10px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        background: #e62222;
    }

    button,
    button span {
        transition: 200ms;
    }

    button .text {
        transform: translateX(35px);
        color: white;
        font-weight: bold;
    }

    button .icon {
        position: absolute;
        border-left: 1px solid #c41b1b;
        transform: translateX(110px);
        height: 35px;
        width: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    button svg {
        width: 15px;
        fill: black;
    }

    button:hover {
        background: #ff3636;
    }

    button:hover .text {
        color: transparent;
    }

    button:hover .icon {
        width: 150px;
        border-left: none;
        transform: translateX(0);
    }

    button:focus {
        outline: none;
    }

    button:active .icon svg {
        transform: scale(0.8);
    }

    .contenedor-botones .Btn {
        margin-right: 20px;
    }

    .card-text {
        padding: 10px;
    }

    h5 {
        padding: 10px;
    }
</style>



<form action="<?= base_url('Administrador/editArea/' . $area->idArea); ?>" method="POST" style="margin-bottom: -50px;" enctype="multipart/form-data">
    <?= csrf_field() ?>
    <div class="card mb-3" style="max-width:100%; ">
        <div class="row g-0">

            <?php
            if (isset($validation)) {
                print $validation->listErrors();
            }
            ?>

            <input type="hidden" name="idArea" value="<?= $area->idArea ?>" />
            <input type="hidden" name="imagenActual" value="<?= $area->imagen ?>" />
            <div class="col-md-4">
                <?php if (isset($area->imagen)): ?>
                    <img src="/areas/<?= $area->imagen ?>" class="img-fluid mb-2"
                        alt="" style="border-radius:50px;padding-top:20px">
                    <p style="font-size:20px;text-align:center;">
                        Fotografía del área
                        <?= $area->nombre ?>
                    </p>
                <?php else: ?>
                    <p>
                        El área
                        <?= "<strong>" . $area->nombre . "</strong>" ?> no cuenta con una ilustración, favor de cargar una.
                    </p>
                <?php endif ?>
            </div>

            <div class="col-md-8">
                <div class="card-body">
                    <h4 class="card-title">
                        Editar área
                        <input type="text" name="nombre" value="<?= $area->nombre ?>">
                    </h4>
                    <div class="row g-0">
                        <div class="col-md-8 border">
                            <h5>Descripción</h5>
                            <textarea class="form-control" name="descripcion" class="form-control"
                                aria-label="With textarea" style="height: 50%;"><?= $area->descripcion ?></textarea>
                        </div>
                        <div class="col-md-3 border">
                            <h5>Encargado</h5>
                            <select class="form-control" name="encargado">
                                <option value="<?= $area->encargado ?>" default>
                                    <?php $db = \Config\Database::connect();
                                    $query = "SELECT nombre, apellido_Paterno, apellido_Materno FROM empleados WHERE idEmpleado = $area->encargado";
                                    $resultado = $db->query($query)->getResultArray();
                                    echo $resultado[0]["nombre"] . " " . $resultado[0]["apellido_Paterno"] . " " . $resultado[0]["apellido_Materno"]; ?>
                                </option>

                                <?php foreach ($empleados as $empleado): ?>
                                    <option value="<?= $empleado->idEmpleado ?>">
                                        <?= $empleado->nombre . " " . $empleado->apellido_Paterno . " " . $empleado->apellido_Materno ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-md-4 border">
                            <h5>Tamaño en M²</h5>
                            <input class="form-control" type="number" name="tamanio" value="<?= $area->tamanio ?>"> M²
                        </div>
                        <div class="col-md-4 border">
                            <h5>Temperatura en grados Celcius</h5>
                            <input class="form-control" type="number" name="temperatura"
                                value="<?= $area->temperatura ?>">°C
                        </div>
                        <div class="col-md-3 border">
                            <h5>Nivel de acceso</h5>
                            <select class="form-control" name="nivelAcceso" id="nivelAcceso" class="form-control">
                                <option value="<?= $area->nivelAcceso ?>" default>
                                    <?= $area->nivelAcceso ?>
                                </option>
                                <option value="Privado">Privado</option>
                                <option value="Público">Público</option>
                                <option value="Solo personal">Solo personal</option>
                            </select>
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col-md-3 border">
                            <h5>Estado</h5>
                            <select class="form-control" name="estado">
                                <option value="<?= $area->estado ?>" default>
                                    <?= $area->estado ?>
                                </option>

                                <option value="Mantenimiento">Privado</option>
                                <option value="Remodelación">Público</option>
                                <option value="Limpieza">Solo personal</option>
                                <option value="Disponible">Disponible</option>
                                <option value="Ocupado">Ocupado</option>
                            </select>
                        </div>
                        <div class="col-md-3 border">
                            <h5>Hora de mantenimiento</h5>
                            <input class="form-control" type="time" value="<?= $area->horaMantenimiento ?>"
                                name="horaMantenimiento">
                        </div>
                        <div class="col-md-5 border">
                            <h5>PH Promedio del área</h5>
                            <input class="form-control" type="number" name="phPromedio"
                                value="<?= $area->phPromedio ?>">
                        </div>
                    </div>
                    <div class="row g-0">
                        <div class="col-md-4 border">
                            <h5>Iluminación</h5>
                            <input class="form-control" type="text" name="iluminacion"
                                value="<?= $area->iluminacion ?>">
                        </div>

                        <div class="col-md-4 border">
                            <h5>Tipo de filtracion de agua</h5>
                            <input class="form-control" type="text" name="filtracionAgua"
                                value="<?= $area->filtracionAgua ?>">
                        </div>

                        <div class="col-md-3 border">
                            <h5>Número máximo de habitantes</h5>
                            <input class="form-control" type="number" name="noHabitantesMax"
                                value="<?= $area->noHabitantesMax ?>">
                        </div>
                        <h5>Actualizar la ilustración del área</h5>
                        <input class="form-control" type="file" name="imagen">
                    </div>
                    
                </div>
            </div>
        </div>
    </div>
    <div class="contenedor-botones" style="display:flex; justify-content:center;">

        <button type="submit" class="Btn" style="background-color:#96be25;">Guardar cambios
            <svg class="svg" viewBox="0 0 512 512">
                <path
                    d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                </path>
            </svg></span></button>
    </div>

</form>
<div class="contenedor-botones" style="display:flex; justify-content:center;position:absolute;right:740px">

    <a href="<?= base_url('/Administrador/especificacionesArea/' . $area->idArea) ?>" style="text-decoration:none;">
        <button class="noselect"><span class="text">Cancelar</span><span class="icon"><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path
                        d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z">
                    </path>
                </svg></span></button>
    </a>
</div>