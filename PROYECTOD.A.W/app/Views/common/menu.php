<html lang="es">
<style>
  table thead tr th {
    background-color: #fa6900;
  }
</style>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
  integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <style>
  .Btn-salir  {
  display: flex;
  align-items: center;
  justify-content: flex-start;
  width: 45px;
  height: 45px;
  border: none;
  border-radius: 50%;
  cursor: pointer;
  position: relative;
  overflow: hidden;
  transition-duration: 0.3s;
  box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.199);
  background-color: #22ccdb;
}

/* plus sign */
.sign-salir {
  width: 100%;
  transition-duration: 0.3s;
  display: flex;
  align-items: center;
  justify-content: center;
}

.sign-salir svg {
  width: 18px;
}

.sign-salir svg path {
  fill: black;
}
/* text */
.text-salir {
  position: absolute;
  right: 0%;
  width: 0%;
  opacity: 0;
  color: black;
  font-size: 1em;
  font-weight: 600;
  transition-duration: 0.3s;
}
/* hover effect on button width */
.Btn-salir:hover {
  width: 150px;
  border-radius: 40px;
  transition-duration: 0.3s;
}

.Btn-salir:hover .sign-salir {
  width: 30%;
  transition-duration: 0.3s;
  padding-left: 20px;
}
/* hover effect button's text */
.Btn-salir:hover .text-salir {
  opacity: 1;
  width: 70%;
  transition-duration: 0.3s;
  padding-right: 15px;
}
/* button click effect*/
.Btn-salir:active {
  transform: translate(2px, 2px);
}

  </style>
<nav class="navbar navbar-expand-lg mb-3 " style="background-color:#22ccdb">
  <a class="navbar-brand" href="/Administrador/vistaGeneral" style="position:absolute;left:5%;">
    <img src="\icons\pagina-de-inicio.png" style="width:30px; height: 30px;">
    <p style="position:absolute; left:100%;top:7px;">
      Inicio</p>
  </a>
  <div class="container-fluid"
    style="background-color:#79f3e9; width:68%;height: 50px; border-radius:7px;display:flex;justify-content:center;align-items:center;">
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav navbar-brand   mb-lg-0">
        <li class="nav-item" style="position:absolute; left:20%;top:10%">
          <a class="nav-link active" aria-current="page" href="/Administrador/animalTabla">
            <img src="\icons\tortuga.png" style="width:40px; height: 40px;"> Animales</a>
        </li>
        <li class="nav-item" style="position:absolute; left:30%;top:10%">
          <a class="nav-link active" aria-current="page" href="/Administrador/areasTabla">
            <img src="\icons\areas.png" style="width:40px; height: 40px;"> Áreas</a>
        </li>
        <li class="nav-item" style="position:absolute; left:38%;top:10%">
          <a class="nav-link active" aria-current="page" href="/Administrador/reservacionesTabla">
            <img src="\icons\reserva.png" style="width:40px; height: 40px;"> Reservaciones</a>
        </li>
        <li class="nav-item" style="position:absolute; left:50%;top:10%">
          <a class="nav-link active" aria-current="page" href="/Administrador/usuariosTabla">
            <img src="\icons\usuario.png" style="width:40px; height: 40px;"> Usuarios</a>
        </li>
        <li class="nav-item" style="position:absolute; left:60%;top:10%">
          <a class="nav-link active" aria-current="page" href="/Administrador/empleadosTabla">
            <img src="\icons\empleados.png" style="width:40px; height: 40px;"> Empleados</a>
        </li>

        <li class="nav-item" style="position:absolute; right:20%;top:10%;">
          <a class="nav-link active" aria-current="page" href="/Administrador/atraccionesTabla">
            <img src="\icons\atr.png" style="width:40px; height: 40px;"> Atracciones</a>
        </li>
        <li class="nav-item" style="position:absolute;right:2%;">


          <button class="Btn-salir" onclick="location.href='/cerrarSesion'" style="position:absolute; top:-28px; right:2%;">
            <div class="sign-salir">
              <svg viewBox="0 0 512 512">
                <path
                  d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z">
                </path>
              </svg>
            </div>
            <div class="text-salir">Salir</div>
          </button>

        </li>
      </ul>
    </div>
  </div>
</nav>
<script src="https://cdn.lordicon.com/lordicon-1.2.0.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>