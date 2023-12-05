<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check-circle-fill" viewBox="0 0 16 16">
        <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
</svg>


<h1 class="mb-5" align="center">Atracciones registradas</h1>

<div class="container ">
    <div class="row">
        <div class="col-12">
        <div class="container mb-3" style="background-color:white;height:40px; border-radius:7px;">
                <div class="row">
                    <div class="col-2">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#formAgregar" style="position:absolute;left:16.2%;">
                            Registrar nueva atracción
                        </button>
                        <a href="<?= base_url('/reporteAtracciones'); ?>" style="position:absolute;left:63.5%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Descargar reporte de atracciones
                            </button>
                        </a>
                        <a href="<?= base_url('/Administrador/buscarAtraccion'); ?>" style="position:absolute;left:77.5%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Buscar atraccion
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
                <div>La atracción <strong style="font-size:24px;">' . '"'.$nombre .'"'. '</strong>' . $mensaje . "</div></div>";
            }
            ?>
            
            <table class='table table-stripped'>
                <thead>
                    <tr>
                        <td style="background-color: #fa6900;">Nombre</td>
                        <td style="background-color: #fa6900;">Animal</td>
                        <td style="background-color: #fa6900;">Tipo</td>
                        <td style="background-color: #fa6900;">Costo</td>
                        <td style="background-color: #fa6900;">Capacidad máxima</td>
                        <td style="background-color: #fa6900;">Especificaciones</td>
                        <td style="background-color: #fa6900;">Editar</td>
                        <td style="background-color: #fa6900;">Eliminar</td>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($atracciones as $atraccion): ?>
                        <tr>
                            <td>
                                <?= $atraccion->nombre ?>
                            </td>
                            <td>
                                <?php
                                $db = \Config\Database::connect();
                                $query = "SELECT nombre FROM animal WHERE numeroIdentificador = $atraccion->animal";
                                $resultado = $db->query($query)->getResultArray();
                                echo $resultado[0]["nombre"];
                                ?>
                            </td>
                            <td>
                                <?= $atraccion->tipo ?>
                            </td>
                            <td>
                                <?= $atraccion->costo ?>
                            </td>
                            <td>
                                <?= $atraccion->capacidadMax . " habitantes" ?>
                            </td>
                            <td><a href="<?= base_url('/Administrador/especificacionesAtraccion/' . $atraccion->idAtraccion); ?>"
                                    style="display:flex;justify-content:center;max-width:50px;margin-right: -100px;">
                                    <img src="\icons\especs.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Administrador/editAtraccion/' . $atraccion->idAtraccion); ?>">
                                <img src="\icons\editar.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Administrador/delAtraccion/' . $atraccion->idAtraccion); ?>">
                                <img src="\icons\del.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            Se muestran <?=count($atracciones) ?> registros de un total de <?=$registros?>
            <?= $pager->links(); ?>

        </div>
    </div>
</div>


<!-- Modal para AGREGAR un registro -->

<div class="modal fade" id="formAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar animal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/Administrador/atraccionesTabla" method="post" action="cargar.php"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label class="form-label">Animal</label>
                        <select name="animal" class="form-control">
                            <?php foreach ($animales as $animal): ?>
                                <option value="<?= $animal->numeroIdentificador ?>">
                                    <?= $animal->nombre ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Área</label>
                        <select name="idArea" class="form-control">
                            <?php foreach ($areas as $area): ?>
                                <option value="<?= $area->idArea ?>">
                                    <?= $area->nombre ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <div class="col-sm-12">
                            <label class="form-label" for="nombre">Nombre</label>
                            <input type="text" class="form-control" name="nombre">
                        </div> 
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" value="">
                    </div>

                    <div class="mb-3">
                        <label for="edad" class="form-label">Tipo</label>
                        <select name="tipo" class="col-12">
                            <option value="Exhibición">Exhibición</option>
                            <option value="Interactiva">Interactiva</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="horarios" class="form-label">Horario</label>
                        <input type="text" name="horarios">
                    </div>

                    <div class="mb-3">
                        <label for="costo" class="form-label">Costo de la atracción por persona</label>
                        <input type="text" name="costo">
                    </div>

                    <div class="mb-3">
                        <label for="capacidadMax" class="form-label">Capacidad máxima de habitantes</label>
                        <input type="number" name="capacidadMax"class="form-control" value="">
                    </div>

                    <div class="mb-3">
                        <label for="duracionAprox" class="form-label">Duración aproximada de la atracción</label>
                        <input type="time" name="duracionAprox" class="form-control" value="">
                    </div>

                    <div class="mb-3">
                        <label for="restriccionesDeSalud" class="form-label">Restricciones de salud</label>
                        <input type="text" name="restriccionesDeSalud" class="form-control">
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