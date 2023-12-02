<?php

namespace App\Controllers;

use App\Controllers\BaseController;
$session = \Config\Services::session();

class ClienteController extends BaseController
{

// Si el cliente inicia sesión exitosamente, ésta es la vista que se retorna y se muestra como inicio al cliente
// No se puede acceder mediante URL si la sesión es inexistente
    public function vistaGeneral()
    {
        $session = session();
        if($session->get('logged_in')!=TRUE){
            $session->destroy();
            return redirect('/');
        }
        return 
        view ('common/menuCliente').
        view ('Cliente/vistaGeneral');
    }
    public function atraccionesTabla()
    {
        $session = session();
        if($session->get('logged_in')!=TRUE){
            $session->destroy();
            return redirect('/');
        }
        return 
        view ('common/menuCliente').
        view ('clienteAtracciones/atracciones');
    }

    public function animalesTabla()
    {

        $session = session();
        if($session->get('logged_in')!=TRUE){
            $session->destroy();
            return redirect('/');
        }
        $animalModel = model('AnimalModel');
        $areasModel = model('AreasModel');
        $especiesModel = model('EspeciesModel');
        $data['animales'] = $animalModel->findAll();
        $data['areas'] = $areasModel->findAll();
        $data['especies'] = $especiesModel->findAll();

        return 
        view ('common/menuCliente').
        view ('clienteAnimales/animales', $data);
    }

    public function especificacionesAnimal($idAnimal)
    {
        $session = session();
        if($session->get('logged_in')!=TRUE){
            $session->destroy();
            return redirect('/');
        }

        $animalModel = model('AnimalModel');
        $data['animal'] = $animalModel->find($idAnimal);
        return
            view('common/menuCliente') .
            view('clienteAnimales/especificaciones', $data);
    }

    public function reservacionesTabla()
    {
        $session = session();
        if($session->get('logged_in')!=TRUE){
            $session->destroy();
            return redirect('/');
        }
        return 
        view ('common/menuCliente').
        view ('clienteReservaciones/reservaciones');
    }

}

