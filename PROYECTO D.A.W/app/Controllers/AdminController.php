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
        $areasModel = model('AreasModel');
        $especiesModel = model('EspeciesModel');
        $data['animales'] = $animalModel->findAll();
        $data['areas'] = $areasModel->findAll();
        $data['especies'] = $especiesModel->findAll();
        return
            view('common/menu') .
            view('administrarAnimales/animalTabla', $data);
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
            view('administrarAnimales/especificacionesAnimal', $data);
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


    public function insertarAnimal()
    {

        $animalModel = model('AnimalModel');
        $data = [
            "especie" => $_POST["idEspecie"],
            "nombre" => $_POST['nombre'],
            "descripcion" => $_POST["descripcion"],
            "edad" => $_POST["edad"],
            "sexo" => $_POST['sexo'],
            "idArea" => $_POST["area"],
            "dieta" => $_POST["dieta"],
            "expectativaDeVida" => $_POST["expectativaDeVida"],
            "fechaNacimiento" => $_POST['fechaNacimiento'],
            "historialMedico" => $_POST['historialMedico']
        ];
        $animalModel->insert($data, false);
        return redirect('Administrador/animalTabla');

    }

    public function eliminarAnimal($id)
    {
        $animalModel = model('AnimalModel');
        $animalModel->delete($id);
        return redirect('Administrador/animalTabla');
    }
}