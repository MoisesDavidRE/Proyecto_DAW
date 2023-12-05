<style>
    button {
        width: 150px;
        height: 50px;
        cursor: pointer;
        display: flex;
        align-items: center;
        background: red;
        border: none;
        border-radius: 10px;
        box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.15);
        background: #e62222;
    }

    button,
    button span {
        transition: 200ms;
    }

    button .text {
        transform: translateX(35px);
        color: white;
        font-weight: bold;
    }

    button .icon {
        position: absolute;
        border-left: 1px solid #c41b1b;
        transform: translateX(110px);
        height: 35px;
        width: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    button svg {
        width: 15px;
        fill: black;
    }

    button:hover {
        background: #ff3636;
    }

    button:hover .text {
        color: transparent;
    }

    button:hover .icon {
        width: 150px;
        border-left: none;
        transform: translateX(0);
    }

    button:focus {
        outline: none;
    }

    button:active .icon svg {
        transform: scale(0.8);
    }

    .contenedor-botones .Btn {
        margin-right: 20px;
    }

    .card-text {
        padding: 10px;
    }

    h5 {
        padding: 10px;
    }
</style>
<h1 align="center">Editar usuario</h1>

<form action="<?= base_url('Administrador/editUsr/' . $usuario->numeroControl); ?>" method="POST"
    style="margin-bottom: -50px;" enctype="multipart/form-data">

    <?php
    if (isset($validation)) {
        print $validation->listErrors();
    }
    ?>

    <input type="hidden" name="numeroControl" value="<?= $usuario->numeroControl ?>">
    <input type="hidden" name="contrasenia" value="<?= $usuario->contrasenia ?>">
    <input type="hidden" name="perfilActual" value="<?= $usuario->imagenUsuario ?>">
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
            <td>Nombre</td>
            <td><input class="form-control" type="text" name="nombre" value="<?= $usuario->nombre ?>"></td>
          </tr>
          <tr>
            <td>Apellido paterno</td>
            <td><input class="form-control" type="text" name="apellido_Paterno" value="<?= $usuario->apellido_Paterno?>"></td>
          </tr>
          <tr>
            <td>Apellido materno</td>
            <td><input class="form-control" type="text" name="apellido_Materno" value="<?= $usuario->apellido_Materno?>"></td>
          </tr>
          <tr>
            <td>Nombre de usuario</td>
            <td><input class="form-control" type="text" name="nombreUsuario" value="<?= $usuario->nombreUsuario ?>"></td>
          </tr>
          <tr>
            <td>Perfil de usuario</td>
            <td><input class="form-control" type="text" name="perfilUsuario" value="<?= $usuario->perfilUsuario ?>"></td>
          </tr>
          <tr>
            <td>Correo electrónico</td>
            <td><input class="form-control" type="email" name="correoElectronico" value="<?= $usuario->correoElectronico ?>"></td>
          </tr>
          <tr>
            <td>Comentarios o preferencias adicionales</td>
            <td><textarea class="form-control" name="comentarioPreferencias"><?= $usuario->comentarioPreferencias ?></textarea></td>
          </tr>
          <tr>
            <td>Actualizar foto de perfil</td>
            <td><input class="form-control" type="file" name="ilustracion"></td>
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

    <div class="contenedor-botones" style="display:flex; justify-content:center;">

        <button type="submit" class="Btn" style="background-color:#96be25;">Guardar cambios
            <svg class="svg" viewBox="0 0 512 512">
                <path
                    d="M410.3 231l11.3-11.3-33.9-33.9-62.1-62.1L291.7 89.8l-11.3 11.3-22.6 22.6L58.6 322.9c-10.4 10.4-18 23.3-22.2 37.4L1 480.7c-2.5 8.4-.2 17.5 6.1 23.7s15.3 8.5 23.7 6.1l120.3-35.4c14.1-4.2 27-11.8 37.4-22.2L387.7 253.7 410.3 231zM160 399.4l-9.1 22.7c-4 3.1-8.5 5.4-13.3 6.9L59.4 452l23-78.1c1.4-4.9 3.8-9.4 6.9-13.3l22.7-9.1v32c0 8.8 7.2 16 16 16h32zM362.7 18.7L348.3 33.2 325.7 55.8 314.3 67.1l33.9 33.9 62.1 62.1 33.9 33.9 11.3-11.3 22.6-22.6 14.5-14.5c25-25 25-65.5 0-90.5L453.3 18.7c-25-25-65.5-25-90.5 0zm-47.4 168l-144 144c-6.2 6.2-16.4 6.2-22.6 0s-6.2-16.4 0-22.6l144-144c6.2-6.2 16.4-6.2 22.6 0s6.2 16.4 0 22.6z">
                </path>
            </svg></span></button>
    </div>

</form>

<div class="contenedor-botones" style="display:flex; justify-content:center;position:absolute;right:710px;padding-bottom: 40px;">

    <a href="<?= base_url('/Administrador/especificacionesUsuario/' . $usuario->numeroControl) ?>"
        style="text-decoration:none;">
        <button class="noselect"><span class="text">Cancelar</span><span class="icon"><svg
                    xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <path
                        d="M24 20.188l-8.315-8.209 8.2-8.282-3.697-3.697-8.212 8.318-8.31-8.203-3.666 3.666 8.321 8.24-8.206 8.313 3.666 3.666 8.237-8.318 8.285 8.203z">
                    </path>
                </svg></span></button>
    </a>
</div>