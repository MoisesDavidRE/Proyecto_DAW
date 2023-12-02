<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Sesión
$routes->get('/', 'SesionController::index');
$routes->post('/', 'SesionController::index');
$routes->get('/cerrarSesion','SesionController::cerrarSesion');

// Vista general
$routes->get('/Administrador/vistaGeneral', 'AdminController::vistaGeneral');

// Animales
$routes->get('/Administrador/animalTabla', 'Animal::animalTabla');
$routes->get('/Administrador/especificacionesAnimal/(:num)', 'Animal::especificacionesAnimal/$1');
$routes->post('/Administrador/insAn', 'Animal::insertarAnimal');
$routes->post('/Administrador/animalTabla', 'Animal::animalTabla');
$routes->get('/Administrador/delAn/(:num)','Animal::eliminarAnimal/$1');
$routes->get('/Administrador/editAn/(:num)', 'Animal::editarAnimal/$1');
$routes->post('/Administrador/editAn/(:num)', 'Animal::editarAnimal/$1');
$routes->post('/Administrador/updateAn', 'Animal::updateAnimal');
$routes->get('/Administrador/buscarAn', 'Animal::buscarAnimal');
$routes->get('/reporteAnimales','Animal::ReporteAnimales');

// Áreas
$routes->get('/Administrador/areasTabla', 'Area::areasTabla');
$routes->get('/Administrador/especificacionesArea/(:num)', 'Area::especificacionesArea/$1');
$routes->post('/Administrador/insArea', 'Area::insertarArea');
$routes->post('/Administrador/agregarArea', 'Area::agregarArea');
$routes->get('/Administrador/delArea/(:num)','Area::eliminarArea/$1');
$routes->get('/Administrador/editArea/(:num)', 'Area::editarArea/$1');
$routes->post('/Administrador/editArea/(:num)', 'Area::editarArea/$1');
$routes->post('/Administrador/updateArea', 'Area::updateArea');

//Atracciones
$routes->get('/Administrador/atraccionesTabla', 'Atracciones::atraccionesTabla');
$routes->get('/Administrador/especificacionesAtraccion/(:num)', 'Atracciones::especificacionesAtraccion/$1');
$routes->post('/Administrador/insAtraccion', 'Atracciones::insertarAtraccion');
$routes->post('/Administrador/agregarAtraccion', 'Atracciones::agregarAtraccion');
$routes->get('/Administrador/delAtraccion/(:num)','Atracciones::eliminarAtraccion/$1');
$routes->get('/Administrador/editAtraccion/(:num)', 'Atracciones::editarAtraccion/$1');
$routes->post('/Administrador/editAtraccion/(:num)', 'Atracciones::editarAtraccion/$1');
$routes->post('/Administrador/updateAtraccion', 'Atracciones::updateAtraccion');

// Reservaciones
$routes->get('/Administrador/reservacionesTabla', 'Reservacion::reservacionesTabla');
$routes->get('/Administrador/reservacionEspecificaciones/(:num)', 'Reservacion::especificacionesReservacion/$1');
$routes->post('/Administrador/insReservacion', 'Reservacion::insertarReservacion');
$routes->post('/Administrador/agregarReservacion', 'Reservacion::agregarReservacion');
$routes->get('/Administrador/delReservacion/(:num)','Reservacion::eliminarReservacion/$1');
$routes->get('/Administrador/editReservacion/(:num)', 'Reservacion::editarReservacion/$1');
$routes->post('/Administrador/editReservacion/(:num)', 'Reservacion::editarReservacion/$1');
$routes->post('/Administrador/updateReservacion', 'Reservacion::updateReservacion');

// Usuarios
$routes->get('/Administrador/usuariosTabla', 'Usuarios::usuariosTabla');
$routes->get('/Administrador/especificacionesUsuario/(:num)', 'Usuarios::especificacionesUsuario/$1');
$routes->post('/Administrador/insAn', 'Usuarios::insertarUsuario');
$routes->post('/Administrador/agregarUsr', 'Usuarios::agregarUsuario');
$routes->get('/Administrador/delUsr/(:num)','Usuarios::eliminarUsuario/$1');
$routes->get('/Administrador/editUsr/(:num)', 'Usuarios::editarUsuario/$1');
$routes->post('/Administrador/editUsr/(:num)', 'Usuarios::editarUsuario/$1');
$routes->post('/Administrador/updateUsr', 'Usuarios::updateUsuario');

// Empleados
$routes->get('/Administrador/empleadosTabla', 'Empleados::empleadosTabla');
$routes->get('/Administrador/empleadoEspecificaciones/(:num)', 'Empleados::especificacionesEmpleado/$1');
$routes->post('/Administrador/insEm', 'Empleados::insertarEmpleado');
$routes->post('/Administrador/agregarEm', 'Empleados::agregarEmpleado');
$routes->get('/Administrador/delEm/(:num)','Empleados::eliminarEmpleado/$1');
$routes->get('/Administrador/editEm/(:num)', 'Empleados::editarEmpleado/$1');
$routes->post('/Administrador/editEm/(:num)', 'Empleados::editarEmpleado/$1');
$routes->post('/Administrador/updateEm', 'Empleados::updateEmpleado');

//Vista general del cliente
$routes->get('/Cliente/vistaGeneral', 'ClienteController::vistaGeneral');

//Atracciones vista del cliente
$routes->get('/Cliente/atraccionesTabla', 'ClienteController::atraccionesTabla');

//Atracciones vista del cliente
$routes->get('/Cliente/areasTabla', 'ClienteController::areasTabla');

//Animales vista del cliente
$routes->get('/Cliente/animalesTabla', 'ClienteController::animalesTabla');
$routes->get('/Cliente/especificacionesAnimal/(:num)', 'ClienteController::especificacionesAnimal/$1');

//Reservaciones vista del cliente
$routes->get('/Cliente/reservacionesTabla', 'ClienteController::reservacionesTabla');
