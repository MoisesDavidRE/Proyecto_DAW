<h1 class="mb-5" align="center">Especificaciones del empleado</h1>
<div class="container">
  <div class="row">
    <div class="col-12">
      <table class="table table-bordered table-striped">
        <thead>
          <tr>
            <th style="background-color: #2596be;font-size:20px;">Detalle</th>
            <th style="background-color: #2596be;font-size:20px;">Valor</th>
          </tr>
        </thead>
        <tbody>
          <tr>
            <td>Nombre completo</td>
            <td><?= $empleado->nombre . " " .$empleado->apellido_Paterno . " " . $empleado->apellido_Materno ?></td>
          </tr>
          <tr>
            <td>Correo electrónico</td>
            <td><?= $empleado->correoElectronico ?></td>
          </tr>
          <tr>
            <td>Teléfono</td>
            <td><?= $empleado->telefono ?></td>
          </tr>
          <tr>
            <td>Fecha de nacimiento</td>
            <td><?= $empleado->fechaNacimiento ?></td>
          </tr>
          <tr>
            <td>Imagen del empleado</td>
            <td><img src="<?= $empleado->imagenEmpleado ?>" width="100" alt="Imagen del empleado"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
