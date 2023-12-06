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

<div class="card mb-3" style="max-width:100%;">
    <div class="row g-0">
        <div class="col-md-8">
            <div class="card-body">
                <h4 class="card-title" align="center">
                    Especificaciones de
                    <?= $animal->nombre ?>
                </h4>
                <div class="row g-0 mb-3">
                    <div class="col-md-3 border">
                        <h5>Área</h5>
                        <p class="card-text">
                            <?php $db = \Config\Database::connect();
                            $query = "SELECT nombre FROM area WHERE idArea = $animal->area";
                            $resultado = $db->query($query)->getResultArray();
                            echo $resultado[0]["nombre"]; ?>
                        </p>
                    </div>
                    <div class="col-md-3 border">
                        <h5>Especie</h5>
                        <p class="card-text">
                            <?= $animal->especie ?>
                        </p>
                    </div>
                    <div class="col-md-3 border">
                        <h5>Dieta</h5>
                        <p class="card-text">
                            <?= $animal->dieta ?>
                        </p>
                    </div>
                    <div class="col-md-3 border">
                        <h5>Edad</h5>
                        <p class="card-text">
                            <?= $animal->edad . " año(s)" ?>
                        </p>
                    </div>
                </div>
                <div class="row g-0 mb-3">
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
                    
                    <div class="col-md-3 border">
                        <h5>Historial médico</h5>
                        <p class="card-text">
                            <?= $animal->historialMedico ?>
                        </p>
                    </div>
                </div>
                <div class="row g-0">
                    <div class="col-md-12 border">
                        <h5>Descripción</h5>
                        <p class="card-text">
                            <?= $animal->descripcion ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <?php if (isset($animal->ilustracion)): ?>
                <img src="/img/<?= $animal->ilustracion ?>" class="img-fluid rounded-end mb-2"
                    alt="Fotografía de <?= $animal->nombre ?>" style="height: 100%;">
                <p style="font-size:20px;text-align:center;">
                    Fotografía de
                    <?= $animal->nombre ?>
                </p>
            <?php else: ?>
                <p>
                    El animal
                    <?= "<strong>" . $animal->nombre . "</strong>" ?> no cuenta con una ilustración por el momento.
                </p>
            <?php endif ?>
        </div>
    </div>
</div>

<div class="contenedor-botones" style="display:flex; justify-content:center;">
    <a href="<?= base_url('/publico/animales') ?>" style="text-decoration:none;">
        <button class="noselect" style="background-color:#96be25;"><span class="text">Regresar</span><span
                class="icon"><img src="\icons\volver.png" style="width:20px; height: 20px;"></span></button>
    </a>
</div>