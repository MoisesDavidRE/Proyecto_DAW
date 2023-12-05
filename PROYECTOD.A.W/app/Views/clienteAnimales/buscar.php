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

            <form action="<?= base_url('/Cliente/buscarAn'); ?>" method="GET">

                <div class="col-5 mb-3">
                    <label for="Buscador">Buscar por: </label>
                    <select name="Buscador" class="form-control">
                        <option value="Todo">Mostrar todo</option>
                        <option value="numeroIdentificador">Número identificador</option>
                        <option value="Nombre">Nombre</option>
                        <option value="Especie">Especie</option>
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
            <table class=" table table-bordered-stripped border-primary">
                <thead>
                    <th>Número identificador</th>
                    <th>Nombre</th>
                    <th>Especie</th>
                    <th>Especificaciones</th>
                </thead>
                <tbody>
                    <?php foreach ($animales as $animal): ?>
                        <tr>
                            <td>
                                <?= $animal->numeroIdentificador ?>
                            </td>

                            <td>
                                <?= $animal->nombre ?>
                            </td>

                          
                                    <td>De la especie:
                                        <?php
                                        $db = \Config\Database::connect();
                                        $query = "SELECT nombre FROM especie WHERE idEspecie = $animal->especie";
                                        $resultado = $db->query($query)->getResultArray();
                                        echo $resultado[0]["nombre"]; 
                                          ?>
                                    </td>
                               

                            <td>
                                <a href="<?= base_url('/Cliente/especificacionesAnimal/' . $animal->numeroIdentificador); ?>"
                                    style="display:flex;justify-content:center;max-width:50px;margin-right: -100px;">
                                    <lord-icon src="https://cdn.lordicon.com/rwtswsap.json" trigger="hover"
                                        colors="primary:#3080e8" style="width:50px;height:50px">
                                    </lord-icon>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>


        </div>
    </div>

</div>