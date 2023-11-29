<h1>Especificaciones del empleado</h1>

<h5>Nombre completo</h5>
<p><?= $empleado->nombre . " " .$empleado->apellido_Paterno . " " . $empleado->apellido_Materno ?></p>

<h5>Correo electrónico</h5>
<p><?= $empleado->correoElectronico ?></p>

<h5>Teléfono</h5>
<p><?= $empleado->telefono ?></p>

<h5>Fecha de nacimiento</h5>
<p><?= $empleado->fechaNacimiento ?></p>

<h5>Imagen del empleado</h5>
<p><?= $empleado->imagenEmpleado ?></p>