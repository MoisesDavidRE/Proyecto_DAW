
<style>
  .Btn {
    position: relative;
    display: flex;
    align-items: center;
    justify-content: flex-start;
    width: 150px;
    height: 45px;
    border: none;
    padding: 0px 20px;
    background-color: rgb(82, 193, 218, 255);
    color: black;
    font-weight: 500;
    cursor: pointer;
    border-radius: 10px;
    box-shadow: 5px 5px 0px rgb(35, 139, 187, 255);
    transition-duration: .3s;
    display: block;
    margin: auto;
  }

  .svg {
    width: 13px;
    position: absolute;
    right: 0;
    margin-right: 20px;
    fill: black;
    transition-duration: .3s;
  }

  .Btn:hover {
    color: transparent;
  }

  .Btn:hover svg {
    top: 35%;
    right: 42%;
    margin: 0;
    padding: 0;
    border: none;
    transition-duration: .3s;
  }

  .Btn:active {
    transform: translate(3px, 3px);
    transition-duration: .3s;
    box-shadow: 2px 2px 0px rgb(140, 32, 212);
  }
</style>

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
    border-left: 1px solid black;
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

  h1 {
    align: center;
  }
</style>

<h1 class="mb-5" align="center">Especificaciones de la atracción <?= $atraccion->nombre ?></h1>
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
                            <?= $atraccion->horaInicio . " " . $atraccion->horaFin ?>
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

<div class="contenedor-botones" style="display:flex; justify-content:center;">

    <a href="<?= base_url('/Cliente/atraccionesTabla') ?>" style="text-decoration:none;">
        <button class="noselect" style="background-color:#96be25;"><span class="text">Regresar</span><span
                class="icon"><img src="\icons\volver.png" style="width:20px; height: 20px;"></span></button>
    </a>
</div>