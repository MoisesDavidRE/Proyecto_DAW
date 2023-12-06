<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

<h1 align="center" class="mb-3" >Conoce los animales que habitan en el acuario</h1>
<div class="container" style="padding-left:200px">
    <div class="row">

        <?php foreach ($animales as $animal): ?>
            <div class="card col-4">
                <?php if (isset($animal->ilustracion)): ?>
                    <img class="card_image" src="\img\<?= $animal->ilustracion ?>" width="100%" height="100%">
                <?php else: ?>
                    <h3><?= $animal->nombre ?></h3>
                    <h6><?=$animal->descripcion?></h6>
                <?php endif ?>
                <div class="card__content">
                    <p class="card__title"><?=$animal->nombre?></p>
                    <h6><?= $animal->descripcion?></h6>
                    <button type="button" class="btn btn-outline-primary"
                        onclick="location.href='/publico/animalEspecs/<?= $animal->numeroIdentificador?>'">Ver especificaciones</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div> 
</div>


<script src="https://cdn.lordicon.com/lordicon-1.2.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>