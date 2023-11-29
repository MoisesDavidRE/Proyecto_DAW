<h1>Reservación Especificaciones</h1>

<h5>Atracción reservada</h5>
<p><?= $reservacion->atraccion_animal ?></p>

<h5>Usuario que reservó</h5>
<p><?= $reservacion->usuario ?></p>


<h5>Fecha reservada</h5>
<p><?= $reservacion->fechaReservada ?></p>

<h5>Hora de inicio</h5>
<p><?= $reservacion->horaInicio ?></p>

<h5>Hora de finalización</h5>
<p><?= $reservacion->horaFin ?></p>

<h5>Estatus de la reservación</h5>
<p><?= $reservacion->estatus ?></p>

<h5>Monto total de la reservación</h5>
<p><?= $reservacion->costoTotal ?></p>

<h5>Comentarios adicionales de la reservación</h5>
<p><?= $reservacion->comentariosAdicionales ?></p>