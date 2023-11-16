<h1>Empleados tabla</h1>

<div class="container">
    <div class="row">
        <div class="col-8">
            <table class='table table-bordered-stripped'>
                <thead>
                    <tr>
                        <td>Nombre completo</td>
                        <td>Correo electrónico</td>
                        <td>Teléfono de contacto</td>
                        <td>Mostrar especificaciones</td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($empleados as $empleado): ?>
                        <tr>
                            <td>
                                <?= $empleado->nombre . " " . $empleado->apellido_Paterno . " " . $empleado->apellido_Materno ?>
                            </td>
                            <td>
                                <?= $empleado->correoElectronico ?>
                            </td>
                            <td>
                                <?= $empleado->telefono ?>
                            </td>
                            <td><a href="/Administrador/empleadoEspecificaciones/">Especificaciones</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>