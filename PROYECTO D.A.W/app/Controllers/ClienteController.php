<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class ClienteController extends BaseController
{
    public function vistaGeneral()
    {
        return 
        view ('common/menuCliente').
        view ('Cliente/vistaGeneral');
    }
    public function atracciones()
    {
        return 
        view ('common/menuCliente').
        view ('clienteAtracciones/atracciones');
    }

    public function animales()
    {
        return 
        view ('common/menuCliente').
        view ('clienteAnimales/animales');
    }

    public function reservaciones()
    {
        return 
        view ('common/menuCliente').
        view ('clienteReservaciones/reservaciones');
    }

    public function contacto()
    {
        return 
        view ('common/menuCliente').
        view ('clienteContacto/contacto');
    }
}

