<html lang="es">
<style>
  table thead tr th {
    background-color: #fa6900;
  }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<nav class="navbar navbar-expand-lg mb-3 " style="background-color:#22ccdb">
<h5 style="position:absolute;padding-left:50px;"><?php $session = \Config\Services::session(); echo $session->get('Nombre')." ".$session->get('ApellidoPaterno')." ".$session->get('ApellidoMaterno')?></h5>
  <div class="container-fluid"
    style="background-color:#79f3e9; width:68%;height: 50px; border-radius:7px;display:flex;justify-content:center;align-items:center;">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav navbar-brand   mb-lg-0">
        <li class="nav-item" style="position:absolute; left:23%;top:10%">
          <a class="nav-link active" aria-current="page" href="/Cliente/vistaGeneral">
          <img src="\icons\pagina-de-inicio.png" style="width:40px; height: 40px;"> Inicio</a>
        </li>
        <li class="nav-item" style="position:absolute; left:37%;top:10%">
          <a class="nav-link active" aria-current="page" href="/Cliente/animalesTabla">
            
            <img src="\icons\tortuga.png" style="width:40px; height: 40px;"> Animales
          </a>
        </li>
        <li class="nav-item" style="position:absolute; left:53%;top:10%">
          <a class="nav-link active" aria-current="page" href="/Cliente/reservacionesTabla">
            <img src="\icons\reserva.png" style="width:40px; height: 40px;"> Reservaciones</a>
        </li>
        <li class="nav-item" style="position:absolute; right:23%;top:10%;">
          <a class="nav-link active" aria-current="page" href="/Cliente/atraccionesTabla">
            <img src="\icons\atr.png" style="width:40px; height: 40px;"> Atracciones</a>
        </li>
        <li class="nav-item" style="position:absolute;right:2%;">
          <a class="nav-link active" aria-current="page" href="/cerrarSesion"
            style="position:absolute; top:-28px; right:2%;">
            <img src="\icons\cerrar-sesion (1).png" style="width:40px; height: 40px;">Cerrar Sesión</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
<script src="https://cdn.lordicon.com/lordicon-1.2.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>