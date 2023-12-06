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
                        <a href="<?= base_url('/reporteAtracciones'); ?>" style="position:absolute;left:63.5%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Descargar reporte de atracciones
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
            <table class='table table-striped'>
                <thead>
                    <tr>
                        <th style="background-color: #fa6900;">Nombre</th>
                        <th style="background-color: #fa6900;">Animal</th>
                        <th style="background-color: #fa6900;">Tipo</th>
                        <th style="background-color: #fa6900;">Costo</th>
                        <th style="background-color: #fa6900;">Capacidad máxima</th>
                        <th style="background-color: #fa6900;">Especificaciones</th>
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
                            <td><a href="<?= base_url('/Cliente/especificacionesAtraccion/' . $atraccion->idAtraccion); ?>"
                                    style="display:flex;justify-content:center;max-width:50px;margin-right: -100px;">
                                    <img src="\icons\especs.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
           

        </div>
    </div>
</div>
