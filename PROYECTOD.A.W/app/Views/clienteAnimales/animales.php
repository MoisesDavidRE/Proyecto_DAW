

<h1 class="mb-5" align="center">Animales del acuario</h1>

<div class="container ">
    <div class="row">
        <div class="col-12">
        <div class="container mb-3" style="background-color:white;height:40px; border-radius:7px;">
                <div class="row">
                    <div class="col-2">
                        <a href="<?= base_url('/tablaAnimales'); ?>" style="position:absolute;left:63.5%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Descargar tabla de animales
                            </button>
                        </a>
                        <a href="<?= base_url('/Cliente/buscarAn'); ?>" style="position:absolute;left:77.5%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Buscar animal
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <table class='table table-bordered table-striped'>
                <thead>
                    <tr>
                        <th style="background-color: #fa6900;">No. identificador</th>
                        <th style="background-color: #fa6900;">Nombre</th>
                        <th style="background-color: #fa6900;">Especie</th>
                        <th style="background-color: #fa6900;">Dieta</th>
                        <th style="background-color: #fa6900;">Fecha de nacimiento</th>
                        <th style="background-color: #fa6900;">Edad</th>
                        <th style="background-color: #fa6900;">Especificaciones</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($animales as $animal): ?>
                        <tr>
                            <td style="width:150px">
                                <p >
                                    <?= $animal->numeroIdentificador ?>
                                </p>
                            </td>
                            <td>
                                <?= $animal->nombre ?>
                            </td>
                            <td>
                                <?php $db = \Config\Database::connect();
                                $query = "SELECT nombre FROM especie WHERE idEspecie = $animal->especie";
                                $resultado = $db->query($query)->getResultArray();
                                echo $resultado[0]["nombre"]; ?>
                            </td>
                            <td>
                                <p >
                                    <?= $animal->dieta ?>
                                </p>
                            </td>
                            <td>
                                <p >
                                    <?= $animal->fechaNacimiento ?>
                                </p>
                            </td>
                            <td>
                                <p >
                                    <?= $animal->edad ?> años
                                </p>
                            </td>
                            <td style="width:150px"><a href="<?= base_url('/Cliente/especificacionesAnimal/' . $animal->numeroIdentificador); ?>"
                                    style="display:flex;justify-content:center;max-width:50px;margin-right: -100px;">
                                    <lord-icon src="https://cdn.lordicon.com/rwtswsap.json" trigger="hover"
                                        colors="primary:#22ccdb" style="width:50px;height:50px">
                                    </lord-icon>
                                </a>
                            </td>
                            
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            Se muestran <?=count($animales) ?> registros de un total de <?=$registros?>
            <?= $pager->links(); ?>
        </div>
    </div>
</div>

