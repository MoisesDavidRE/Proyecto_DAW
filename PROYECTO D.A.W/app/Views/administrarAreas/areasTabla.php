


<h1>Áreas tabla</h1>

<div class="container">
    <div class="row">
        <div class="col-8">
            <table class='table table-bordered-stripped'>
                <thead>
                    <tr>
                        <th>Área</th>
                        <th>Temperatura</th>
                        <th>Estatus</th>
                        <th>Nivel de acceso</th>
                        <th>Especificaciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($areas as $area): ?>
                    <tr>
                        <td><?= $area->nombre ?></td>
                        <td><?= $area->temperatura . " ºC" ?></td>
                        <td><?= $area->estado ?></td>
                        <td><?= $area->nivelAcceso ?></td>
                        <td><a href="/Administrador/especificacionesArea">Especificaciones</a></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

        </div>
    </div>
</div>



