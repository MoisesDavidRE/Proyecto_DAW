<?php $session = \Config\Services::session(); ?>
<style>
    .card {
        position: relative;
        width: 340px;
        aspect-ratio: 16/9;
        background-color: #f2f2f2;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        perspective: 1000px;
        box-shadow: 0 0 0 5px #ffffff80;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card svg {
        width: 48px;
        fill: #333;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card__image {
        width: 100%;
        height: 100%;
    }

    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(255, 255, 255, 0.2);
    }

    .card__content {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        padding: 20px;
        box-sizing: border-box;
        background-color: #f2f2f2;
        transform: rotateX(-90deg);
        transform-origin: bottom;
        transition: all 0.6s cubic-bezier(0.175, 0.885, 0.32, 1.275);
    }

    .card:hover .card__content {
        transform: rotateX(0deg);
    }

    .card__title {
        margin: 0;
        font-size: 20px;
        color: #333;
        font-weight: 700;
    }

    .card:hover svg {
        scale: 0;
    }

    .card__description {
        margin: 10px 0 10px;
        font-size: 12px;
        color: #777;
        line-height: 1.4;
    }

    .card__button {
        padding: 15px;
        border-radius: 8px;
        background: #777;
        border: none;
        color: white;
    }

    .secondary {
        background: transparent;
        color: #777;
        border: 1px solid #777;
    }
</style>
<div class="col-2"></div>
<div class="container" style="padding-left:200px">
    <div class="row">
        <div>
            <h2 align="center" class="mb-5">¡Hola, acuario Deimar te da la bienvenida </h2>
            <img src="\icons\logo.png" width="300" style="position:absolute;left:5%;top:6.5%;">
        </div>
        <div class="card col-3">
            <img src="\icons\oceano.png" width="100">
            <div class="card__content">
                <p class="card__title">Animales</p>
                <p class="card__description">Aquí puedes visualizar la información de los animales que habitan en el acuario, en caso de que lo necesites puedes descargar un reporte de todos los animales</p>
                <button type="button" class="btn btn-outline-primary"
                    onclick="location.href='/publico/animales'">Ir a
                    Animales</button>
            </div>
        </div>
        
        <div class="card col-3">
            <img src="\icons\reserva (1).png" width="100">
            <div class="card__content">
                <p class="card__title">Reservaciones</p>
                <p class="card__description">Redireccionamiento al módulo de reservaciones</p>
                <button type="button" class="btn btn-outline-primary"
                    onclick="location.href='/publico/reservaciones'">Ir
                    a Reservaciones</button>
            </div>
        </div>

        <div class="card col-3">
            <img src="\icons\delfin.png" width="100">
            <div class="card__content">
                <p class="card__title">Atracciones</p>
                <p class="card__description">En este módulo puedes ver las atracciones ofertadas por el acuario.</p>
                <button type="button" class="btn btn-outline-primary"
                    onclick="location.href='/publico/atracciones'">Ir a Atracciones</button>
            </div>
        </div>

    </div>
</div>