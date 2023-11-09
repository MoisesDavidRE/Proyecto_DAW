<h1>Animales registrados</h1>

<div class="container">
    <div class="row">
        <div class="col-8">
            <table class='table table-stripped'>
                <thead>
                    <tr>
                        <td>Número identificador</td>
                        <td>Nombre</td>
                        <td>Especie</td>
                        <td>Especificaciones</td>
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
                                </a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>