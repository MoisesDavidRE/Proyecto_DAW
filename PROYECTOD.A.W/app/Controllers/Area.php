<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

$session = \Config\Services::session();
$pager = \Config\Services::pager();


class Area extends BaseController
{
        // Método que muestra la tabla de áreas en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
public function areasTabla()
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $areasModel = model('AreasModel');
    $empleados = model('EmpleadoModel');
    $data['empleados'] = $empleados->findAll();
    $data['areas'] = $areasModel->findAll();

    return
        view('common/menu') .
        view('administrarAreas/areasTabla', $data);
}

// Método para visualizar las especificaciones del área, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
public function especificacionesArea($id)
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $area = model('AreasModel');
    $data['area'] = $area->find($id);
    return
        view('common/menu') .
        view('administrarAreas/especificacionesArea', $data);
}

// Método que valida los campos del formulario para agregar un registro en la tabla
// "area", en caso que las reglas de validación sean aceptadas, se invoca al método insertarArea()
public function agregarArea()
{
    $areas = model('AreasModel');
    $empleados = model('EmpleadoModel');
    $data['areas'] = $areas->findAll();
    $data['empleados'] = $empleados->findAll();

    $validation = \Config\Services::validation();

    $rules = [
        'encargado' => 'required',
        'nombre' => 'required',
        'descripcion' => 'required',
        'temperatura' => 'required',
        'phPromedio' => 'required',
        'iluminacion' => 'required',
        'filtracionAgua' => 'required',
        'noHabitantesMax' => 'required',
        'estado' => 'required',
        'nivelAcceso' => 'required',
        'horaMantenimiento' => 'required'
    ];

    if (!$this->validate($rules)) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarAreas/areasTabla', ['validation' => $validation], $data);
    } else {
        if ($this->insertarArea()) {
            return redirect('Administrador/areasTabla');
        }
    }

}

// Método que hace la propia inserción del área en la base de datos
// Únicamente se invoca cuando las reglas de validación han sido aceptadas en el
// método agregarArea(), no es invocado de manera directa en los formularios
public function insertarArea()
{
    $area = model('AreasModel');
    $data = [
        "encargado" => $_POST["encargado"],
        "nombre" => $_POST['nombre'],
        "descripcion" => $_POST["descripcion"],
        "tamanio" => $_POST["tamanio"],
        "temperatura" => $_POST['temperatura'],
        "nivelAcceso" => $_POST["nivelAcceso"],
        "estado" => $_POST["estado"],
        "horaMantenimiento" => $_POST["horaMantenimiento"],
        "phPromedio" => $_POST['phPromedio'],
        "iluminacion" => $_POST['iluminacion'],
        "filtracionAgua" => $_POST['filtracionAgua'],
        "noHabitantesMax" => $_POST['noHabitantesMax']
    ];
    $area->insert($data, false);
    return true;
}

// Función que elimina de la base de datos el registro coincidente con el ID que recibe como parámetro
public function eliminarArea($id)
{
    $area = model('AreasModel');
    $area->delete($id);
    return redirect('Administrador/areasTabla');
}

// Método que ayuda a validar los datos insertados en el formulario para editar un registro en específico
// Dicho registro es específicado mediante el ID que la función recibe como parámetro
// En caso de que las reglas de validación sean aceptadas, se invoca al método updateArea()
public function editarArea($id)
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $areas = model('AreasModel');
    $empleados = model('EmpleadoModel');
    $data['area'] = $areas->find($id);
    $data['empleados'] = $empleados->findAll();

    $validation = \Config\Services::validation();

    if ((strtolower($this->request->getMethod()) === 'get')) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarAreas/editarArea', $data);
    }

    $rules = [
        'encargado' => 'required',
        'nombre' => 'required',
        'descripcion' => 'required',
        'temperatura' => 'required',
        'phPromedio' => 'required',
        'iluminacion' => 'required',
        'filtracionAgua' => 'required',
        'noHabitantesMax' => 'required',
        'estado' => 'required',
        'nivelAcceso' => 'required',
        'horaMantenimiento' => 'required'
    ];

    if (!$this->validate($rules)) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarAreas/editarArea', ['validation' => $validation], $data);
    } else {
        if ($this->updateArea()) {
            return redirect('Administrador/areasTabla');
        }
    }
}

// Método que hace la actualización del registro en la base de datos, únicamente se invoca
// cuando las reglas de validación en el método editarArea() han sido aceptadas, no se invoca de manera directa
// en los formularios
public function updateArea()
{
    $area = model('AreasModel');
    $data = [
        "encargado" => $_POST["encargado"],
        "nombre" => $_POST['nombre'],
        "descripcion" => $_POST["descripcion"],
        "tamanio" => $_POST["tamanio"],
        "temperatura" => $_POST['temperatura'],
        "nivelAcceso" => $_POST["nivelAcceso"],
        "estado" => $_POST["estado"],
        "horaMantenimiento" => $_POST["horaMantenimiento"],
        "phPromedio" => $_POST['phPromedio'],
        "iluminacion" => $_POST['iluminacion'],
        "filtracionAgua" => $_POST['filtracionAgua'],
        "noHabitantesMax" => $_POST['noHabitantesMax']
    ];
    $area->update($_POST['idArea'], $data);
    return true;
}
}
