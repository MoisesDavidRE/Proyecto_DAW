<style>
    button {
        width: 150px;
        height: 50px;
        cursor: pointer;
        display: flex;
        align-items: center;
        background: red;
        border: none;
        border-radius: 10px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        background: #e62222;
    }

    button,
    button span {
        transition: 200ms;
    }

    button .text {
        transform: translateX(35px);
        color: white;
        font-weight: bold;
    }

    button .icon {
        position: absolute;
        border-left: 1px solid #c41b1b;
        transform: translateX(110px);
        height: 35px;
        width: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    button svg {
        width: 15px;
        fill: black;
    }

    button:hover {
        background: #ff3636;
    }

    button:hover .text {
        color: transparent;
    }

    button:hover .icon {
        width: 150px;
        border-left: none;
        transform: translateX(0);
    }

    button:focus {
        outline: none;
    }

    button:active .icon svg {
        transform: scale(0.8);
    }

    .contenedor-botones .Btn {
        margin-right: 20px;
    }

    .card-text {
        padding: 10px;
    }

    h5 {
        padding: 10px;
    }
</style>

<form action="<?= base_url('Administrador/editAtraccion/' . $atraccion->idAtraccion); ?>" method="POST"
    style="margin-bottom: -50px;">

    <?php
    if (isset($validation)) {
        print $validation->listErrors();
    }
    ?>
<h1 class="mb-5" align="center">Editar la atracción <?=$atraccion->nombre?></h1>
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
          <input type="hidden" name="idAtraccion" value="<?=$atraccion->idAtraccion?>">
          <tr>
            <td>Animal</td>
            <td>
            <select class="form-control" name="animal">
                                <option value="<?= $atraccion->animal ?>" default>
                                    <?php $db = \Config\Database::connect();
                                    $query = "SELECT nombre FROM animal WHERE numeroIdentificador = $atraccion->animal";
                                    $resultado = $db->query($query)->getResultArray();
                                    echo $resultado[0]["nombre"]; ?>
                                </option>

                                <?php foreach ($animales as $animal): ?>
                                    <option value="<?= $animal->numeroIdentificador ?>">
                                        <?= $animal->nombre?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
            </td>
          </tr>
          <tr>
            <td>Área</td>
            <td>
            <select class="form-control" name="idArea">
                                <option value="<?= $atraccion->idArea ?>" default>
                                    <?php
                                    $query = "SELECT nombre FROM area WHERE idArea = $atraccion->idArea";
                                    $resultado = $db->query($query)->getResultArray();
                                    echo $resultado[0]["nombre"]; ?>
                                </option>

                                <?php foreach ($areas as $area): ?>
                                    <option value="<?= $area->idArea ?>">
                                        <?= $area->nombre?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
            </td>
          </tr>
          <tr>
            <td>Nombre de la atracción</td>
            <td><input class="form-control" type="text" name="nombre" value="<?= $atraccion->nombre ?>"></td>
          </tr>
          <tr>
            <td>Tipo de atracción</td>
            <td>
            <select name="tipo" class="form-control">
                        <?php if($atraccion->tipo == "Exhibición"): ?>
                        <option value="Exhibición" selected>Exhibición</option>
                        <option value="Interactiva" >Interactiva</option>
                        <?php else: ?>
                        <option value="Exhibición" >Exhibición</option>
                        <option value="Interactiva" selected>Interactiva</option>
                        <?php endif ?>
                    </select>
            </td>
          </tr>
          <tr>
            <td>Descripción de la atracción</td>
            <td><textarea class="form-control" name="descripcion"><?= $atraccion->descripcion ?></textarea></td>
          </tr>
          <tr>
            <td>Horarios de la atracción</td>
            <td><input class="form-control" type="text" name="horarios" value="<?= $atraccion->horarios ?>"></td>
          </tr>
          <tr>
            <td>Costo</td>
            <td><input class="form-control" type="number" name="costo" value="<?= $atraccion->costo ?>"></td>
          </tr>
          <tr>
            <td>Capacidad máxima de habitantes</td>
            <td><input class="form-control" type="number" name="capacidadMax" value="<?= $atraccion->capacidadMax ?>"></td>
          </tr>
          <tr>
            <td>Duración aproximada de la atracción</td>
            <td><input  class="form-control" type="text" name="duracionAprox" value="<?= $atraccion->duracionAprox ?> minutos"></td>
          </tr>
          <tr>
            <td>Restricciones de salud</td>
            <td><textarea class="form-control" name="restriccionesDeSalud"><?= $atraccion->restriccionesDeSalud ?></textarea></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

    </div>
    <div class="contenedor-botones" style="display:flex; justify-content:center;">

        <button type="submit" class="Btn" style="background-color:green;">Guardar cambios
            <svg class="svg" viewBox="0 0 512 512">
                <path
                    d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                </path>
            </svg></span></button>
    </div>

</form>

<div class="contenedor-botones" style="display:flex; justify-content:center;position:absolute;right:740px">

    <a href="<?= base_url('/Administrador/especificacionesAtraccion/' . $atraccion->idAtraccion) ?>"
        style="text-decoration:none;">
        <button class="noselect"><span class="text">Cancelar</span><span class="icon"><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path
                        d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z">
                    </path>
                </svg></span></button>
    </a>
</div>