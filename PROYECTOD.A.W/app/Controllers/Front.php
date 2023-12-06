<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Front extends BaseController
{
    public function index()
    {
        return 
            view('common/header') .
            view('common/menuPublico') .
            view('Publico/general');
    }

    public function animales()
    {

        $animales = model('AnimalModel');
        $data['animales'] = $animales->findAll();
        return view('common/header') .
            view('common/menuPublico') .
            view('Publico/animales', $data);
    }
    public function especificacionesAnimal($id)
    {

        $animales = model('AnimalModel');
        $data['animal'] = $animales->find($id);

        return
            view('common/header') .
            view('common/menuPublico') .
            view('Publico/especificacionesAnimal', $data);
    }

    public function reservaciones(){

        return 
            view('common/menuPublico').
            view('Publico/reservaciones');
    }

    public function atracciones(){

        $atracciones = model('AtraccionesModel');
        $data['atracciones'] = $atracciones->findAll();
        return 
            view('common/menuPublico').
            view('Publico/atracciones',$data);
    }

        // Método para visualizar las especificaciones de la atracción, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
public function especificacionesAtraccion($id)
{
    $atraccion = model('AtraccionesModel');
    $data['atraccion'] = $atraccion->find($id);
    return
        view('common/menuPublico') .
        view('Publico/especificacionesAtraccion', $data);
}
}
