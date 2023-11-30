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
$routes->get('/Administrador/animalTabla', 'AdminController::animalTabla');
$routes->get('/Administrador/especificacionesAnimal/(:num)', 'AdminController::especificacionesAnimal/$1');
$routes->post('/Administrador/insAn', 'AdminController::insertarAnimal');
$routes->post('/Administrador/agregarAn', 'AdminController::agregarAnimal');
$routes->get('/Administrador/delAn/(:num)','AdminController::eliminarAnimal/$1');
$routes->get('/Administrador/editAn/(:num)', 'AdminController::editarAnimal/$1');
$routes->post('/Administrador/editAn/(:num)', 'AdminController::editarAnimal/$1');
$routes->post('/Administrador/updateAn', 'AdminController::updateAnimal');
$routes->get('/Administrador/buscarAn', 'AdminController::buscarAnimal');

// Áreas
$routes->get('/Administrador/areasTabla', 'AdminController::areasTabla');
$routes->get('/Administrador/especificacionesArea/(:num)', 'AdminController::especificacionesArea/$1');
$routes->post('/Administrador/insArea', 'AdminController::insertarArea');
$routes->post('/Administrador/agregarArea', 'AdminController::agregarArea');
$routes->get('/Administrador/delArea/(:num)','AdminController::eliminarArea/$1');
$routes->get('/Administrador/editArea/(:num)', 'AdminController::editarArea/$1');
$routes->post('/Administrador/editArea/(:num)', 'AdminController::editarArea/$1');
$routes->post('/Administrador/updateArea', 'AdminController::updateArea');

//Atracciones
$routes->get('/Administrador/atraccionesTabla', 'AdminController::atraccionesTabla');
$routes->get('/Administrador/especificacionesAtraccion/(:num)', 'AdminController::especificacionesAtraccion/$1');
$routes->post('/Administrador/insAtraccion', 'AdminController::insertarAtraccion');
$routes->post('/Administrador/agregarAtraccion', 'AdminController::agregarAtraccion');
$routes->get('/Administrador/delAtraccion/(:num)','AdminController::eliminarAtraccion/$1');
$routes->get('/Administrador/editAtraccion/(:num)', 'AdminController::editarAtraccion/$1');
$routes->post('/Administrador/editAtraccion/(:num)', 'AdminController::editarAtraccion/$1');
$routes->post('/Administrador/updateAtraccion', 'AdminController::updateAtraccion');

// Reservaciones
$routes->get('/Administrador/reservacionesTabla', 'AdminController::reservacionesTabla');
$routes->get('/Administrador/reservacionEspecificaciones/(:num)', 'AdminController::especificacionesReservacion/$1');
$routes->post('/Administrador/insReservacion', 'AdminController::insertarReservacion');
$routes->post('/Administrador/agregarReservacion', 'AdminController::agregarReservacion');
$routes->get('/Administrador/delReservacion/(:num)','AdminController::eliminarReservacion/$1');
$routes->get('/Administrador/editReservacion/(:num)', 'AdminController::editarReservacion/$1');
$routes->post('/Administrador/editReservacion/(:num)', 'AdminController::editarReservacion/$1');
$routes->post('/Administrador/updateReservacion', 'AdminController::updateReservacion');

// Usuarios
$routes->get('/Administrador/usuariosTabla', 'AdminController::usuariosTabla');
$routes->get('/Administrador/especificacionesUsuario/(:num)', 'AdminController::especificacionesUsuario/$1');
$routes->post('/Administrador/insAn', 'AdminController::insertarUsuario');
$routes->post('/Administrador/agregarUsr', 'AdminController::agregarUsuario');
$routes->get('/Administrador/delUsr/(:num)','AdminController::eliminarUsuario/$1');
$routes->get('/Administrador/editUsr/(:num)', 'AdminController::editarUsuario/$1');
$routes->post('/Administrador/editUsr/(:num)', 'AdminController::editarUsuario/$1');
$routes->post('/Administrador/updateUsr', 'AdminController::updateUsuario');

// Empleados
$routes->get('/Administrador/empleadosTabla', 'AdminController::empleadosTabla');
$routes->get('/Administrador/empleadoEspecificaciones/(:num)', 'AdminController::especificacionesEmpleado/$1');
$routes->post('/Administrador/insEm', 'AdminController::insertarEmpleado');
$routes->post('/Administrador/agregarEm', 'AdminController::agregarEmpleado');
$routes->get('/Administrador/delEm/(:num)','AdminController::eliminarEmpleado/$1');
$routes->get('/Administrador/editEm/(:num)', 'AdminController::editarEmpleado/$1');
$routes->post('/Administrador/editEm/(:num)', 'AdminController::editarEmpleado/$1');
$routes->post('/Administrador/updateEm', 'AdminController::updateEmpleado');

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
