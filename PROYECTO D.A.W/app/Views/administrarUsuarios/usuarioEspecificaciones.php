<h1>Usuario Especificaciones</h1>

<h5>Nombre completo</h5>
<p><?= $usuario->nombre . " " .$usuario->apellido_Paterno . " " . $usuario->apellido_Materno ?></p>

<h5>Nombre de usuario</h5>
<p><?= $usuario->nombreUsuario ?></p>

<h5>Perfil de usuario</h5>
<p><?= $usuario->perfilUsuario ?></p>

<h5>Correo electrónico</h5>
<p><?= $usuario->correoElectronico ?></p>

<h5>Fecha de nacimiento</h5>
<p><?= $usuario->fechaNacimiento ?></p>

<h5>Comentarios o preferencias adicionales</h5>
<p><?= $usuario->comentarioPreferencias ?></p>