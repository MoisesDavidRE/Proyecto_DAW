<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Inicio de sesión
$routes->get('/', 'SesionController::index');

// Vista general
$routes->get('/Administrador/vistaGeneral', 'AdminController::vistaGeneral');

// Animales
$routes->get('/Administrador/animalTabla', 'AdminController::animalTabla');
$routes->get('/Administrador/especificacionesAnimal/(:num)', 'AdminController::especificacionesAnimal/$1');
$routes->post('/Administrador/ins', 'AdminController::insertarAnimal');
$routes->get('/Administrador/delAn/(:num)','AdminController::eliminarAnimal/$1');
$routes->get('/Administrador/edit/(:num)', 'AdminController::editarAnimal/$1');

// Áreas
$routes->get('/Administrador/areasTabla', 'AdminController::areasTabla');
$routes->get('/Administrador/especificacionesArea', 'AdminController::especificacionesArea');

//Atracciones
$routes->get('/Administrador/atraccionesTabla', 'AdminController::atraccionesTabla');
$routes->get('/Administrador/especificacionesAtraccion', 'AdminController::especificacionesAtraccion');

// Reservaciones
$routes->get('/Administrador/reservacionesTabla', 'AdminController::reservacionesTabla');
$routes->get('/Administrador/reservacionEspecificaciones', 'AdminController::reservacionEspecificaciones');

// Usuarios
$routes->get('/Administrador/usuariosTabla', 'AdminController::usuariosTabla');
$routes->get('/Administrador/usuarioEspecificaciones', 'AdminController::usuarioEspecificaciones');

// Empleados
$routes->get('/Administrador/empleadosTabla', 'AdminController::empleadosTabla');
$routes->get('/Administrador/empleadoEspecificaciones', 'AdminController::empleadoEspecificaciones');

//Vista general del cliente
$routes->get('/Cliente/vistaGeneral', 'ClienteController::vistaGeneral');

//Atracciones vista del cliente
$routes->get('/Cliente/atracciones', 'ClienteController::atracciones');

//Animales vista del cliente
$routes->get('/Cliente/animales', 'ClienteController::animales');

//Reservaciones vista del cliente
$routes->get('/Cliente/reservaciones', 'ClienteController::reservaciones');

//Contacto 
$routes->get('/Cliente/contacto', 'ClienteController::contacto');