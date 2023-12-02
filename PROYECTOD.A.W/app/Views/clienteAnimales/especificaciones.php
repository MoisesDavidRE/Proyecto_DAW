
<div class="card mb-3" style="max-width:100%; ">
  <div class="row g-0">
    <div class="col-md-4">
      <img src="/img/delfin2.jpg" class="img-fluid rounded-start mb-2" alt="..." style="heigth:100%;">
      <p style="text-align: center; font-size:20px;">
        <?= "Fotografía de " . $animal->nombre ?>
      </p>
    </div>
    <div class="col-md-8">
      <div class="card-body">
        <h4 class="card-title">
          <?= "Especificaciones de " . $animal->nombre ?>
        </h4>
        <div class="row g-0">
          <div class="col-md-3 border">
            <h5>Descripción</h5>
            <p class="card-text">
              <?= $animal->descripcion ?>
            </p>
          </div>
          <div class="col-md-3 border">
            <h5>Dieta</h5>
            <p class="card-text">
              <?= $animal->dieta ?>
            </p>
          </div>
          <div class="col-md-3 border">
            <h5>Área</h5>
            <p class="card-text">
              <?= $animal->area ?>
            </p>
          </div>
          <div class="col-md-3 border">
            <h5>Especie</h5>
            <p class="card-text">

              <?php
              $db = \Config\Database::connect();
              $idEspecie = $animal->especie;
              $query = "SELECT nombre FROM especie WHERE idEspecie = $idEspecie";
              $resultado = $db->query($query)->getResultArray();
              if (!$resultado) {
                // Error al conectar a la base de datos
                echo mysqli_error($db);
              } else
                echo $resultado[0]["nombre"];
              ?>

            </p>
          </div>
        </div>
        <div class="row g-0">
          <div class="col-md-3 border">
            <h5>Edad</h5>
            <p class="card-text">
              <?= $animal->edad . " año(s)" ?>
            </p>
          </div>
          <div class="col-md-3 border">
            <h5>Sexo</h5>
            <p class="card-text">
              <?= $animal->sexo ?>
            </p>
          </div>
          
          <div class="col-md-3 border">
            <h5>Fecha de nacimiento</h5>
            <p class="card-text">
              <?= $animal->fechaNacimiento ?>
            </p>
          </div>
        </div>
        <div class="row g-0">
          <div class="col-md-12 border">
            <h5>Historial médico</h5>
            <p class="card-text">
              <?= $animal->historialMedico ?>
            </p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<a href="<?= base_url('Cliente/animalesTabla')?>">
<button class="btn btn-primary" style="position:absolute;left:45%;width:150px">Regresar</button>
</a>