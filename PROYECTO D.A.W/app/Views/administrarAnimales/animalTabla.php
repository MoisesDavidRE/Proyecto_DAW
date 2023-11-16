<h1>Animales registrados</h1>

<div class="container">
    <div class="row">
        <div class="col-8">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#formAgregar">
                Registrar nuevo animal
            </button>
            <table class='table table-stripped'>
                <thead>
                    <tr>
                        <td>Número identificador</td>
                        <td>Nombre</td>
                        <td>Especie</td>
                        <td>Especificaciones</td>
                        <td>Acciones</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($animales as $animal): ?>
                        <tr>
                            <td>
                                <?= $animal->numeroIdentificador ?>
                            </td>
                            <td>
                                <?= $animal->nombre ?>
                            </td>
                            <td>
                                <?= $animal->especie ?>
                            </td>
                            <td><a
                                    href="<?= base_url('/Administrador/especificacionesAnimal/' . $animal->numeroIdentificador); ?>">
                                    <lord-icon src="https://cdn.lordicon.com/rwtswsap.json" trigger="hover"
                                        colors="primary:#3080e8" style="width:50px;height:50px">
                                    </lord-icon>
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Administrador/delAn/' . $animal->numeroIdentificador); ?>">
                                    <lord-icon src="https://cdn.lordicon.com/skkahier.json" trigger="hover"
                                        colors="primary:#3080e8" style="width:50px;height:50px">
                                    </lord-icon>
                                </a>
                                <a href="<?= base_url('/Administrador/edit/' . $animal->numeroIdentificador); ?>"><button>
                                        Ediar información
                                    </button></a>
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
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar animal</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/Administrador/ins" method="post" action="cargar.php" enctype="multipart/form-data">
                    <?= csrf_field() ?>
                    <div class="mb-3">
                        <label for="idEspecie" class="form-label">Especie</label>
                        <select name="idEspecie" id="idEspecie" class="form-control">
                            <?php foreach ($especies as $especie): ?>
                                <option value="<?= $especie->idEspecie ?>">
                                    <?= $especie->nombre ?>
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
                        <input type="text" name="nombre" id="nombre" class="form-control" value="">
                    </div>

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripcion</label>
                        <input type="text" name="descripcion" id="descripcion" class="form-control" value="">
                    </div>

                    <div class="mb-3">
                        <label for="edad" class="form-label">Edad</label>
                        <input type="number" name="edad" id="edad" class="form-control" value="">
                    </div>

                    <div class="mb-3">
                        <label for="sexo" class="form-label">Sexo</label>
                        <select name="sexo" id="Sexo" class="form-control">
                            <option value="MACHO">MACHO</option>
                            <option value="HEMBRA">HEMBRA</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="area" class="form-label">Área</label>
                        <select name="area" id="area" class="form-control">
                            <?php foreach ($areas as $area): ?>
                                <option value="<?= $area->idArea ?>">
                                    <?= $area->nombre ?>
                                </option>
                            <?php endforeach ?>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="dieta" class="form-label">Describe la dieta del animal</label>
                        <input type="text" name="dieta" id="dieta" class="form-control" value="">
                    </div>

                    <div class="mb-3">
                        <label for="expectativaDeVida" class="form-label">Expectativa de Vida</label>
                        <input type="number" name="expectativaDeVida" id="expectativaDeVida" class="form-control"
                            value="">
                    </div>

                    <div class="mb-3">
                        <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="historialMedico" class="form-label">Historial médico</label>
                        <input type="text" name="historialMedico" id="historialMedico" class="form-control">
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



<button type="button" class="btn btn-primary" id="liveToastBtn">Show live toast</button>

<div class="toast" role="alert" aria-live="assertive" aria-atomic="true">
    <div class="toast-header">
        <img src="..." class="rounded me-2" alt="...">
        <strong class="me-auto">Bootstrap</strong>
        <small class="text-body-secondary">11 mins ago</small>
        <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
    </div>
    <div class="toast-body">
        Hello, world! This is a toast message.
    </div>
</div>