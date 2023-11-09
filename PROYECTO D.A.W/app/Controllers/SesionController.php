<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class SesionController extends BaseController
{
    public function index()
    {
        return view('InicioSesion/iniciarSesion');
    }
}

