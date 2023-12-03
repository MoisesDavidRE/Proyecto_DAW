<h1 class="mb-5" align="center">Usuario Especificaciones</h1>
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
            <td>Número de control</td>
            <td><?= $usuario->numeroControl ?></td>
          </tr>
          <tr>
            <td>Nombre completo</td>
            <td><?= $usuario->nombre . " " .$usuario->apellido_Paterno . " " . $usuario->apellido_Materno ?></td>
          </tr>
          <tr>
            <td>Nombre de usuario</td>
            <td><?= $usuario->nombreUsuario ?></td>
          </tr>
          <tr>
            <td>Perfil de usuario</td>
            <td><?= $usuario->perfilUsuario ?></td>
          </tr>
          <tr>
            <td>Correo electrónico</td>
            <td><?= $usuario->correoElectronico ?></td>
          </tr>
          <tr>
            <td>Fecha de nacimiento</td>
            <td><?= $usuario->fechaNacimiento ?></td>
          </tr>
          <tr>
            <td>Comentarios o preferencias adicionales</td>
            <td><?= $usuario->comentarioPreferencias ?></td>
          </tr>
          <tr>
            <td>Foto de perfil</td>
            <td><img src="/avatar/<?= $usuario->imagenUsuario ?>" class="img-fluid rounded mb-2" alt="..." style="heigth:300px; width:300px"></td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>
