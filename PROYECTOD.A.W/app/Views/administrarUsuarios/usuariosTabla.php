<svg xmlns="http://www.w3.org/2000/svg" class="d-none">
    <symbol id="check-circle-fill" viewBox="0 0 16 16">
        <path
            d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z" />
    </symbol>
</svg>

<h1 class="mb-5" align="center">Usuarios registrados</h1>

<div class="container ">
    <div class="row">
        <div class="col-12">
            <div class="container mb-3" style="background-color:white;height:40px; border-radius:7px;">
                <div class="row">
                    <div class="col-2">

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#formAgregar" style="position:absolute;left:16.2%;">
                            Registrar nuevo usuario
                        </button>
                        <a href="<?= base_url('/reporteUsuarios'); ?>" style="position:absolute;left:63.5%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Descargar reporte de usuarios
                            </button>
                        </a>
                        <a href="<?= base_url('/Administrador/buscarUsuario'); ?>"
                            style="position:absolute;left:77%;">
                            <button type="button" class="btn btn-outline-success mb-5" data-bs-toggle="modal">
                                Buscar usuario
                            </button>
                        </a>
                    </div>
                </div>
            </div>

            <?php
            if (isset($validation)) {
                print $validation->listErrors();
            }
            if (isset($mensaje)) {
                echo '<div class="alert alert-success d-flex align-items-center" role="alert">
                <svg style="width:50px;height:50px;" class="bi flex-shrink-0 me-2" role="img" aria-label="Success:"><use xlink:href="#check-circle-fill"/></svg>
                <div>El usuario <strong style="font-size:24px;">' . $nombre . '</strong>' . $mensaje . "</div></div>";
            }
            ?>
            <table class='table table-stripped'>
                <thead>
                    <tr>
                        <th style="background-color: #fa6900;">Número de control</th>
                        <th style="background-color: #fa6900;">Usuario</th>
                        <th style="background-color: #fa6900;">Correo</th>
                        <th style="background-color: #fa6900;">Especificaciones</th>
                        <th style="background-color: #fa6900;">Editar</th>
                        <th style="background-color: #fa6900;">Eliminar</th>
                    </tr>
                </thead>
                <tbody class="table-group-divider">
                    <?php foreach ($usuarios as $usuario): ?>
                        <tr>
                            <td>
                                <?= $usuario->numeroControl ?>
                            </td>
                            <td>
                                <?= $usuario->nombre . " " . $usuario->apellido_Paterno . " " . $usuario->apellido_Materno ?>
                            </td>
                            <td>
                                <?= $usuario->correoElectronico ?>
                            </td>
                            <td><a href="<?= base_url('/Administrador/especificacionesUsuario/' . $usuario->numeroControl); ?>"
                                    style="display:flex;justify-content:center;max-width:50px;margin-right: -100px;">
                                    <img src="\icons\especs.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Administrador/editUsr/' . $usuario->numeroControl); ?>">
                                    <img src="\icons\editar.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                            <td>
                                <a href="<?= base_url('/Administrador/delUsr/' . $usuario->numeroControl); ?>">
                                    <img src="\icons\del.png" style="width:30px; height: 30px;">
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            Se muestran
            <?= count($usuarios) ?> registros de un total de
            <?= $registros ?>
            <?= $pager->links(); ?>
        </div>
    </div>
</div>


<!-- Modal para AGREGAR un registro -->

<div class="modal fade" id="formAgregar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Registrar usuario</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="/Administrador/usuariosTabla" method="post" action="cargar.php"
                    enctype="multipart/form-data">
                    <?= csrf_field() ?>

                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="nombre">Nombre</label>
                        <input type="text" class="form-control" name="nombre">
                    </div>

                    <div class="mb-3">
                        <label for="apellido_Paterno" class="form-label">Apellido Paterno</label>
                        <input type="text" name="apellido_Paterno" class="form-control" value="">
                    </div>

                    <div class="mb-3">
                        <label for="apellido_Materno" class="form-label">Apellido Materno</label>
                        <input type="text" name="apellido_Materno" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="nombreUsuario" class="form-label">Nombre de usuario</label>
                        <input type="text" name="nombreUsuario" class="form-control" value="">
                    </div>

                    <div class="mb-3">
                        <label for="contrasenia" class="form-label">Contraseña</label>
                        <input type="password" name="contrasenia">
                    </div>

                    <div class="mb-3">
                        <label for="perfilUsuario" class="form-label">Perfil del usuario</label>
                        <select name="perfilUsuario">
                            <option value="cliente">Cliente</option>
                            <option value="administrador">Administrador</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="correoElectronico" class="form-label">Correo electrónico</label>
                        <input type="text" name="correoElectronico" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="fechaNacimiento" class="form-label">Fecha de Nacimiento</label>
                        <input type="date" name="fechaNacimiento" id="fechaNacimiento" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label for="comentarioPreferencias" class="form-label">Comentarios o preferencias
                            adicionales</label>
                        <input type="text" name="comentarioPreferencias" class="form-control">
                    </div>

                    <div class="col-sm-12 mb-3">
                        <label class="form-label" for="ilustracion" enctype="multipart/form-data">Foto de perfil</label>
                        <input type="file" class="form-control" name="ilustracion">
                    </div>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
            <div class="modal-footer">

            </div>
        </div>
    </div>
</div>