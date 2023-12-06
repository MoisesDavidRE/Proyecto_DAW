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
            border-spacing: 1px;
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
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }

        td {
            font-family: Arial, Helvetica, sans-serif;
            padding: 10px;
            text-align: center;
        }

        h1 {
            font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
        }
    </style>

</head>

<body>
    <?php $session = \Config\Services::session(); ?>
    <h1 class="mb-3" align="center" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
        Tabla de reservaciones</h1>
    <h6 align="right" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">Fecha de
        generación del reporte:
        <?= date("Y-m-d") ?>
    </h6>
    <p align="right">Tabla generada por el usuario:
        <?= $session->get('Nombre') . " " . $session->get('ApellidoPaterno') . " " . $session->get('ApellidoMaterno') ?></p>
    <table class='table'>
        <thead>
            <tr>
                <th>ID de la reservación</th>
                <th>Reservación a nombre de:</th>
                <th>Fecha reservada</th>
                <th>Hora de inicio</th>
                <th>Hora de finalización</th>
                <th>Estatus</th>
                <th>Costo</th>
                <th>Comentarios adicionales</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php $session = \Config\Services::session(); foreach ($reservaciones as $reservacion): ?>
                <?php if($session->get('idUsuario')==$reservacion->usuario):?>   
                <tr>
                    <td style="width: 50px;">
                        <p
                            style="display:flex;justify-content:center;color:red;font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                            <?= $reservacion->idReservacion ?>
                        </p>
                    </td>
                    <td>
                        <?php
                        $db = \Config\Database::connect();
                        $query = "SELECT nombre, apellido_Paterno, apellido_Materno FROM usuario WHERE numeroControl = $reservacion->usuario";
                        $resultado = $db->query($query)->getResultArray();
                        echo $resultado[0]["nombre"] . " " . $resultado[0]["apellido_Paterno"] . " " . $resultado[0]["apellido_Materno"]; ?>
                    </td>
                    <td style="width: 130px;">
                        <?= $reservacion->fechaReservada ?>
                    </td>
                    <td>
                        <?= $reservacion->horaInicio ?>
                    </td>
                    <td>
                        <?= $reservacion->horaFin?>
                    </td>
                    <td style="width: 130px;">
                        <?= $reservacion->estatus ?>
                    </td>
                    <td>
                        <?= $reservacion->costoTotal ?>
                    </td>
                    <td>
                        <?= $reservacion->comentariosAdicionales ?>
                    </td>
                </tr>
            <?php endif; endforeach; ?>
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