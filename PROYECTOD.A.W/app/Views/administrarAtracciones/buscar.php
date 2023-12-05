<style>
    .editBtn {
        width: 45px;
        height: 45px;
        border-radius: 20px;
        border: none;
        background-color: rgb(52, 132, 236);
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.123);
        cursor: pointer;
        position: relative;
        overflow: hidden;
        transition: all 0.3s;
    }

    .editBtn::before {
        content: "";
        width: 200%;
        height: 200%;
        background-color: rgb(102, 102, 141);
        position: absolute;
        z-index: 1;
        transform: scale(0);
        transition: all 0.3s;
        border-radius: 50%;
        filter: blur(10px);
    }

    .editBtn:hover::before {
        transform: scale(1);
    }

    .editBtn:hover {
        box-shadow: 0px 5px 10px rgba(0, 0, 0, 0.336);
    }

    .editBtn svg {
        height: 17px;
        fill: white;
        z-index: 3;
        transition: all 0.2s;
        transform-origin: bottom;
    }

    .editBtn:hover svg {
        transform: rotate(-15deg) translateX(5px);
    }

    .editBtn::after {
        content: "";
        width: 25px;
        height: 1.5px;
        position: absolute;
        bottom: 19px;
        left: -5px;
        background-color: white;
        border-radius: 2px;
        z-index: 2;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.5s ease-out;
    }

    .editBtn:hover::after {
        transform: scaleX(1);
        left: 0px;
        transform-origin: right;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-12">
            <h1 align="center">Buscar animal</h1>

            <form action="<?= base_url('/Administrador/buscarAtraccion'); ?>" method="GET">

                <div class="col-5 mb-3">
                    <label for="Buscador">Buscar por: </label>
                    <select name="Buscador" class="form-control">
                        <option value="Todo">Mostrar todo</option>
                        <option value="Nombre">Nombre</option>
                        <option value="exhibición">Atracciones de exhibición</option>
                        <option value="interactiva">Atracciones interactivas</option>
                        <option value="Costo">Costo de la atracción</option>
                        <option value="capacidadMax">Capacidad máxima</option>
                    </select>
                </div>

                <div class="col-5 mb-3">
                    <label for="Valor">Ingresa alguna semejanza:</label>
                    <input type="text" class="form-control" name="Valor" maxlength="30"
                        pattern="[a-z - A-Z 0-9 \s]{1,15}">
                </div>

                <input type="submit" class="btn btn-outline-success" value="Buscar">

            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <h2>Animales</h2>
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

        </div>
    </div>

</div>