

<h1 class="mb-5" align="center">Animales del acuario</h1>

<div class="container ">
    <div class="row">
        <div class="col-12">
            

            <table class='table table-stripped'>
                <thead>
                    <tr>
                        <th>Número identificador</th>
                        <th>Nombre</th>
                        <th>Especie</th>
                        <th>Especificaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($animales as $animal): ?>
                        <tr>
                            <td>
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
                            <td><a href="<?= base_url('/Cliente/especificacionesAnimal/' . $animal->numeroIdentificador); ?>"
                                    style="display:flex;justify-content:center;max-width:50px;margin-right: -100px;">
                                    <lord-icon src="https://cdn.lordicon.com/rwtswsap.json" trigger="hover"
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

