<h1 class="mb-5" align="center">Especificaciones de la atracción <?=$atraccion->nombre?></h1>
<div class="container">
    <div class="row">
        <div class="col-12">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="background-color: #2596be;font-size:20px;">Detalle</th>
                        <th style="background-color: #2596be;font-size:20px;">Valor</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Animal</td>
                        <td>
                        <?php
                            $db = \Config\Database::connect();
                            $query = "SELECT nombre FROM animal WHERE numeroIdentificador = $atraccion->animal";
                            $resultado = $db->query($query)->getResultArray();
                            echo $resultado[0]["nombre"];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Área</td>
                        <td>
                            <?php
                            $db = \Config\Database::connect();
                            $query = "SELECT nombre FROM area WHERE idArea = $atraccion->idArea";
                            $resultado = $db->query($query)->getResultArray();
                            echo $resultado[0]["nombre"];
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Nombre de la atracción</td>
                        <td>
                            <?= $atraccion->nombre ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Tipo de atracción</td>
                        <td>
                            <?= $atraccion->tipo ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Descripción de la atracción</td>
                        <td>
                            <?= $atraccion->descripcion ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Horarios de la atracción</td>
                        <td>
                            <?= $atraccion->horarios ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Costo</td>
                        <td>
                            <?= $atraccion->costo ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Capacidad máxima de habitantes</td>
                        <td>
                            <?= $atraccion->capacidadMax ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Duración aproximada de la atracción</td>
                        <td>
                            <?= $atraccion->duracionAprox ?>
                        </td>
                    </tr>
                    <tr>
                        <td>Restricciones de salud</td>
                        <td>
                            <?= $atraccion->restriccionesDeSalud ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>