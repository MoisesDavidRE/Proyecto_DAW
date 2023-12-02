<h1 class="mb-5" align="center">Especificaciones de la reservación de <?php $db = \Config\Database::connect();
                                $query = "SELECT nombre, apellido_Paterno, apellido_Materno FROM usuario WHERE numeroControl = $reservacion->usuario";
                                $resultado = $db->query($query)->getResultArray();
                                echo $resultado[0]["nombre"] . " " . $resultado[0]["apellido_Paterno"] . " " . $resultado[0]["apellido_Materno"];?></h1>
<div class="container">
  <div class="row">
    <div class="col-12">
      <table class="table table-bordered table-striped table-light" style="background-color: #b0b0ff;">
        <thead>
          <tr>
            <th style="background-color: #2596be;font-size:20px;">Detalle</th>
            <th style="background-color: #2596be;font-size:20px;">Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Atracción reservada</td>
            <td><?php
            $db = \Config\Database::connect();
            $query = "SELECT nombre FROM atraccion_animal WHERE id = $reservacion->atraccion_animal";
            $resultado = $db->query($query)->getResultArray();
            echo $resultado[0]["nombre"]?></td>
          </tr>
          <tr>
            <td>Usuario que reservó</td>
            <td><?php $query = "SELECT nombre, apellido_Paterno, apellido_Materno FROM usuario WHERE numeroControl = $reservacion->usuario";
                                $resultado = $db->query($query)->getResultArray();
                                echo $resultado[0]["nombre"] . " " . $resultado[0]["apellido_Paterno"] . " " . $resultado[0]["apellido_Materno"]; ?></td>
          </tr>
          <tr>
            <td>Fecha reservada</td>
            <td><?= $reservacion->fechaReservada ?></td>
          </tr>
          <tr>
            <td>Hora de inicio</td>
            <td><?= $reservacion->horaInicio ?></td>
          </tr>
          <tr>
            <td>Hora de finalización</td>
            <td><?= $reservacion->horaFin ?></td>
          </tr>
          <tr>
            <td>Estatus de la reservación</td>
            <td><?= $reservacion->estatus ?></td>
          </tr>
          <tr>
            <td>Monto total de la reservación</td>
            <td><?= $reservacion->costoTotal ?></td>
          </tr>
          <tr>
            <td>Comentarios adicionales de la reservación</td>
            <td><?= $reservacion->comentariosAdicionales ?></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
