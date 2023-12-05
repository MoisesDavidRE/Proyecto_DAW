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

<h1 class="mb-3" align="center">Animales registrados</h1>

<div class="container ">
    <div class="row">
        <div class="col-12">
            <div class="container mb-3" style="background-color:white;height:40px; border-radius:7px;">
                <div class="row">
                    <div class="col-2">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#formAgregar" style="position:absolute;left:16.2%;">
                            Registrar nuevo animal
                        </button>
                        <a href="<?= base_url('/reporteAnimales'); ?>" style="position:absolute;left:63.5%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Descargar reporte de animales
                            </button>
                        </a>
                        <a href="<?= base_url('/Administrador/buscarAn'); ?>" style="position:absolute;left:77.5%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Buscar animal
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
            if (isset($mensajeEliminar) && $nombre != null) {
                echo '<div class="alert alert-danger d-flex align-items-center" role="alert">
                <svg style="width:50px;height:50px;" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                <div>El registro de <strong style="font-size:24px;">' . $nombre . '</strong>' . $mensajeEliminar . "</div></div>";
            }
            if (isset($mensajeEditar) && $nombre != null) {
                echo '<div class="alert alert-warning d-flex align-items-center" role="alert">
                <svg style="width:50px;height:50px;" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>El registro de <strong style="font-size:24px;">' . $nombre . '</strong>' . $mensajeEditar . "</div></div>";
            }
            ?>

            <table class='table table-bordered  table-striped' style="border-radius: 7px;">
                <thead>
                    <tr>
                        <th style="background-color: #fa6900;">Número identificador</th>
                        <th style="background-color: #fa6900;">Nombre</th>
                        <th style="background-color: #fa6900;">Fecha de nacimiento</th>
                        <th style="background-color: #fa6900;">Especie</th>
                        <th style="background-color: #fa6900;">Área</th>
                        <th style="background-color: #fa6900;">Especif.</th>
                        <th style="background-color: #fa6900;">Editar</th>
                        <th style="background-color: #fa6900;">Eliminar</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($animales as $animal): ?>
                        <tr>
                            <td style="width: 50px;">
                                <p style="display:flex;justify-content:center;">
                                    <?= $animal->numeroIdentificador ?>
                                </p>
                            </td>
                            <td>
                                <?= $animal->nombre ?>
                            </td>
                            <td style="width: 250px;">
                                <?= $animal->fechaNacimiento ?>
                            </td>
                            <td>

                                <?= $animal->especie ?>

                            </td>
                            <td style="width: 250px;">
                                <?php
                                $db = \Config\Database::connect();
                                $query = "SELECT nombre FROM area WHERE idArea = $animal->area";
                                $resultado = $db->query($query)->getResultArray();
                                echo $resultado[0]["nombre"]; ?>
                            </td>
                            <td style="width: 50px;"><a
                                    href="<?= base_url('/Administrador/especificacionesAnimal/' . $animal->numeroIdentificador); ?>"
                                    style="display:flex;justify-content:center;max-width:50px;">
                                    <img src="\icons\especs.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                            <td style="width: 50px;">
                                <a href="<?= base_url('/Administrador/editAn/' . $animal->numeroIdentificador); ?>">

                                    <img src="\icons\editar.png" style="width:30px; height: 30px;">

                                </a>
                            </td>
                            <td style="width: 50px;">
                                <a href="<?= base_url('/Administrador/delAn/' . $animal->numeroIdentificador); ?>">
                                    <img src="\icons\del.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            Se muestran
            <?= count($animales) ?> registros de un total de
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar animal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/Administrador/animalTabla" method="post" action="cargar.php"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Información básica</legend>
                                <div class="mb-3">
                                    <label for="especie" class="form-label">Especie</label>
                                    <input type="text" name="especie" class="form-control" pattern="[a-z - A-Z 0-9 \s]{5,25}">
                                </div>
                                <div class="mb-3">
                                    <label for="nombre" class="form-label">Nombre</label>
                                    <input type="text" name="nombre" class="form-control">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Características</legend>
                                <div class="mb-3">
                                    <label for="sexo" class="form-label">Sexo</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sexo" value="MACHO"
                                            id="sexoMacho">
                                        <label class="form-check-label" for="sexoMacho">Macho</label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="sexo" value="HEMBRA"
                                            id="sexoHembra">
                                        <label class="form-check-label" for="sexoHembra">Hembra</label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Información adicional</legend>
                                <div class="mb-3">
                                    <label for="edad" class="form-label">Edad</label>
                                    <input type="number" name="edad" id="edad" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="fechaNacimiento" class="form-label">Fecha de nacimiento</label>
                                    <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="dieta" class="form-label">Dieta</label>
                                    <input type="text" name="dieta" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label for="area" class="form-label">Área</label>
                                    <select name="area" class="form-control">
                                        <?php foreach ($areas as $area): ?>
                                            <option value="<?= $area->idArea ?>">
                                                <?= $area->nombre ?>
                                            </option>
                                        <?php endforeach ?>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Expectativa de vida</label>
                                    <input type="number" name="expectativaDeVida" class="form-control">
                                </div>
                            </fieldset>
                        </div>
                        <div class="col-sm-6">
                            <fieldset>
                                <legend>Historial médico</legend>
                                <textarea name="historialMedico" id="historialMedico" class="form-control"
                                    rows="5"></textarea>
                            </fieldset>
                            <fieldset>
                                <legend>Ilustración del animal</legend>
                                <input type="file" class="form-control" name="ilustracion">
                            </fieldset>
                            <fieldset>
                                <legend>Descripción</legend>
                                <textarea name="descripcion" class="form-control" rows="5"></textarea>
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