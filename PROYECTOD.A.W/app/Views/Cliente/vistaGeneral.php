<?php $session = \Config\Services::session(); ?>

<div class="container">
    <div class="row">

        <div class="col-12">
            <h1 align="center">¡Hola
                <?= $session->get('Nombre') ?>!
            </h1>
            <h2 align="center"></h2>
    
            <h3 align="center">Acuario Deimar te da la bienvenida</h3>
        </div>

        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Reservaciones</h5>
                    <img src="\icons\reserva (1).png"
                        width="100"><br>
                    <button type="button" class="btn btn-primary" onclick="location.href='/Cliente/reservacionesTabla'">Ir
                        a Reservaciones</button>
                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Animales</h5>
                    <img src="\icons\oceano.png" width="100"><br>
                    <button type="button" class="btn btn-primary" onclick="location.href='/Cliente/animalesTabla'">Ir a
                        Animales</button>

                </div>
            </div>
        </div>

        <div class="col-4">
            <div class="card text-center">
                <div class="card-body">
                    <h5 class="card-title">Atracciones</h5>
                    <img src="\icons\delfin.png" width="100"><br>
                    <button type="button" class="btn btn-primary"
                        onclick="location.href='/Cliente/atraccionesTabla'">Ir a Atracciones</button>
                </div>
            </div>
        </div>
    </div>
</div>