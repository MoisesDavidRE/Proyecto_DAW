<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminController extends BaseController
{

    public function vistaGeneral()
    {
        return
            view('common/menu') .
            view('Administrador/vistaGeneral');
    }

    public function animalTabla()
    {
        $animalModel = model('AnimalModel');
        $data ['animales']= $animalModel->findAll();
        return
            view('common/menu') .
            view('administrarAnimales/animalTabla',$data);
    }
    public function areasTabla()
    {
        return
            view('common/menu') .
            view('administrarAreas/areasTabla');
    }
    public function reservacionesTabla()
    {
        return
            view('common/menu') .
            view('administrarReservaciones/reservacionesTabla');
    }
    public function usuariosTabla()
    {
        return
            view('common/menu') .
            view('administrarUsuarios/usuariosTabla');
    }
    public function atraccionesTabla()
    {
        return
            view('common/menu') .
            view('administrarAtracciones/atraccionesTabla');
    }
    public function empleadosTabla()
    {
        return
            view('common/menu') .
            view('empleados/mostrar');
    }

    public function especificacionesAnimal($idAnimal)
    {
        $animalModel = model('AnimalModel');
        $data['animal'] = $animalModel->find($idAnimal);
        return
            view('common/menu') .
            view('administrarAnimales/especificacionesAnimal',$data);
    }
    public function especificacionesArea()
    {
        return
            view('common/menu') .
            view('administrarAreas/especificacionesArea');
    }
    public function especificacionesAtraccion()
    {
        return
            view('common/menu') .
            view('administrarAtracciones/especificacionesAtraccion');
    }
    public function reservacionEspecificaciones()
    {
        return
            view('common/menu') .
            view('administrarReservaciones/reservacionEspecificaciones');
    }

    public function usuarioEspecificaciones()
    {
        return
            view('common/menu') .
            view('administrarUsuarios/usuarioEspecificaciones');
    }
    public function empleadoEspecificaciones()
    {
        return
            view('common/menu') .
            view('empleados/especificacionesEmpleado');
    }
}