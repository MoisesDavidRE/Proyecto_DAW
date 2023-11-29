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
            <h5>Expectativa de vida</h5>
            <p class="card-text">
              <?= "Se estima una expectativa de vida de " . $animal->expectativaDeVida . " años" ?>
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

<div class="contenedor-botones" style="display:flex; justify-content:center;">
  <a href="<?= base_url('/Administrador/editAn/' . $animal->numeroIdentificador) ?>" style="text-decoration:none;">
    <button class="Btn">Editar
      <svg class="svg" viewBox="0 0 512 512">
        <path
          d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
        </path>
      </svg></span></button>
  </a>

  <a href="<?= base_url('/Administrador/delAn/' . $animal->numeroIdentificador) ?>" style="text-decoration:none;">
    <button class="noselect"><span class="text">Borrar</span><span class="icon"><svg xmlns="http://www.w3.org/2000/svg"
          width="24" height="24" viewBox="0 0 24 24">
          <path
            d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z">
          </path>
        </svg></span></button>
  </a>
</div>