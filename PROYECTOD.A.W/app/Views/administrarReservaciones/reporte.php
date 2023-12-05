<!DOCTYPE html>
<html lang="en">

<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        Reservaciones registradas</h1>
    <h6 align="right" style="font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">Fecha de
        generación del reporte:
        <?= date("Y-m-d") ?>
    </h6>
    <p align="right">Generó el administrador:
        <?= $session->get('Nombre') . " " . $session->get('ApellidoPaterno') . " " . $session->get('ApellidoMaterno') ?>
    </p>
    <table class='table'>
        <thead>
            <tr>
                <th>ID reservación</th>
                <th>Usuario</th>
                <th>Atracción</th>
                <th>$ Total</th>
                <th>Fecha reservada</th>
                <th>Hora de inicio - hora de fin</th>
                <th>Estatus</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php foreach ($reservaciones as $reservacion): ?>
                <tr>
                    <td style="width: 50px;">
                        <p
                            style="display:flex;justify-content:center;color:red;font-family:'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;">
                            <?= $reservacion->idReservacion ?>
                        </p>
                    </td>
                    <td>
                        <?php $db = \Config\Database::connect();
                        $query = "SELECT nombre, apellido_Paterno, apellido_Materno FROM usuario WHERE numeroControl = $reservacion->usuario";
                        $resultado = $db->query($query)->getResultArray();
                        echo $resultado[0]["nombre"] . " " . $resultado[0]["apellido_Paterno"] . " " . $resultado[0]["apellido_Materno"]; ?>
                    </td>
                    <td style="width: 130px;">
                        <?php $db = \Config\Database::connect();
                        $query = "SELECT nombre FROM atraccion WHERE idAtraccion = $reservacion->atraccion";
                        $resultado = $db->query($query)->getResultArray();
                        echo $resultado[0]["nombre"]; ?>
                    </td>
                    <td>
                        $<?= $reservacion->costoTotal ?>
                    </td>
                    <td style="width: 130px;">
                        <?= $reservacion->fechaReservada ?>
                    </td>
                    <td>
                        <?= $reservacion->horaInicio . "-" . $reservacion->horaFin ?>
                    </td>
                    <td>
                        <?= $reservacion->estatus ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    </div>
    </div>
    </div>
</body>

</html>