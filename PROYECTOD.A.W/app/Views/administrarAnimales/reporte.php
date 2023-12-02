<!DOCTYPE html>
<html lang="en">
<head>
    
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    <style>
    table {
        border-collapse: collapse;
        border-spacing: 1;
        width: 100%;
        margin: 0 auto;
        font-family: Arial;
        text-align: center;
    }

    th {
        font-family: Arial;
    }

    td {
        font-family: Verdana;
    }

    th {
        background-color: #fa6900;
        padding: 10px;
        font-weight: bold;
        font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }

    td {
        font-family:Arial, Helvetica, sans-serif;
        padding: 10px;
        text-align: center;
    }
    h1{
        font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
    }
</style>

</head>
<body>
<h1 class="mb-3" align="center" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">Animales registrados</h1>
<h5 align="left" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;"><?= date("Y-m-d") ?></h5>
<table class='table'>
    <thead>
        <tr>
            <th>No. identificador</th>
            <th>Nombre</th>
            <th>Fecha de nacimiento</th>
            <th>Especie</th>
            <th>Área</th>
            <th>Edad</th>
            <th>Sexo</th>
            <th>Dieta</th>
            <th>Expectativa de Vida</th>
        </tr>
    </thead>
    <tbody class="table-group-divider">
        <?php foreach ($animales as $animal): ?>
            <tr>
                <td style="width: 50px;">
                    <p style="display:flex;justify-content:center;color:red;font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                        <?= $animal->numeroIdentificador ?>
                    </p>
                </td>
                <td>
                    <?= $animal->nombre ?>
                </td>
                <td style="width: 130px;">
                    <?= $animal->fechaNacimiento ?>
                </td>
                <td>

                    <?php
                    $db = \Config\Database::connect();
                    $query = "SELECT nombre FROM especie WHERE idEspecie = $animal->especie";
                    $resultado = $db->query($query)->getResultArray();
                    echo $resultado[0]["nombre"]; ?>

                </td>
                <td style="width: 130px;">
                    <?php
                    $db = \Config\Database::connect();
                    $query = "SELECT nombre FROM area WHERE idArea = $animal->area";
                    $resultado = $db->query($query)->getResultArray();
                    echo $resultado[0]["nombre"]; ?>
                </td>
                
                <td >
                <?= $animal->edad ?>
                </td>
                <td >
                <?= $animal->sexo ?>
                </td>
                <td>
                <?= $animal->dieta ?>
                </td>
                <td>
                <?= $animal->expectativaDeVida ?> años
                </td>
                
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
</div>
</div>
</div>


</body>

<script src="https://cdn.lordicon.com/lordicon-1.2.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
    crossorigin="anonymous"></script>
</html>