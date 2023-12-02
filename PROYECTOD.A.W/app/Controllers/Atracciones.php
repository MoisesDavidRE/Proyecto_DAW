<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

$session = \Config\Services::session();
$pager = \Config\Services::pager();

class Atracciones extends BaseController
{
   // Método que muestra la tabla de atracciones en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
public function atraccionesTabla()
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $animales = model('AnimalModel');
    $areas = model('AreasModel');
    $atracciones = model('AtraccionesModel');
    $data['animales'] = $animales->findAll();
    $data['areas'] = $areas->findAll();
    $data['atracciones'] = $atracciones->findAll();
    return
        view('common/menu') .
        view('administrarAtracciones/atraccionesTabla', $data);
}

// Método para visualizar las especificaciones de la atracción, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
public function especificacionesAtraccion($id)
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $atraccion = model('AtraccionesModel');
    $data['atraccion'] = $atraccion->find($id);
    return
        view('common/menu') .
        view('administrarAtracciones/especificacionesAtraccion', $data);
}

// Método que valida los campos del formulario para agregar un registro en la tabla
// "Atraccion", en caso que las reglas de validación sean aceptadas, se invoca al método insertarAtraccion()
public function agregarAtraccion()
{
    $animales = model('AnimalModel');
    $areas = model('AreasModel');
    $atracciones = model('AtraccionesModel');
    $data['animales'] = $animales->findAll();
    $data['areas'] = $areas->findAll();
    $data['atracciones'] = $atracciones->findAll();

    $validation = \Config\Services::validation();

    $rules = [
        'animal' => 'required',
        'idArea' => 'required',
        'nombre' => 'required',
        'tipo' => 'required',
        'descripcion' => 'required',
        'horarios' => 'required',
        'costo' => 'required'
    ];

    if (!$this->validate($rules)) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarAtracciones/atraccionesTabla', ['validation' => $validation], $data);
    } else {
        if ($this->insertarAtraccion()) {
            return redirect('Administrador/atraccionesTabla');
        }
    }
}

// Método que hace la propia inserción de la atracción en la base de datos
// Únicamente se invoca cuando las reglas de validación han sido aceptadas en el
// método agregarAtraccion(), no es invocado de manera directa en los formularios
public function insertarAtraccion()
{
    $atraccion = model('AtraccionesModel');
    $data = [
        "animal" => $_POST["animal"],
        "idArea" => $_POST['idArea'],
        "nombre" => $_POST["nombre"],
        "tipo" => $_POST["tipo"],
        "descripcion" => $_POST["descripcion"],
        "horarios" => $_POST["horarios"],
        "costo" => $_POST["costo"],
        "capacidadMax" => $_POST["capacidadMax"],
        "duracionAprox" => $_POST["duracionAprox"],
        "restriccionesDeSalud" => $_POST["restriccionesDeSalud"]
    ];
    $atraccion->insert($data, false);
    return true;
}

// Función que elimina de la base de datos el registro coincidente con el ID que recibe como parámetro
public function eliminarAtraccion($id)
{
    $atraccion = model('AtraccionesModel');
    $atraccion->delete($id);
    return redirect('Administrador/atraccionesTabla');
}

// Método que ayuda a validar los datos insertados en el formulario para editar un registro en específico
// Dicho registro es específicado mediante el ID que la función recibe como parámetro
// En caso de que las reglas de validación sean aceptadas, se invoca al método updateAtraccion()
public function editarAtraccion($id)
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $animales = model('AnimalModel');
    $areas = model('AreasModel');
    $data['animales'] = $animales->findAll();
    $data['areas'] = $areas->findAll();
    $atraccion = model('AtraccionesModel');
    $data['atraccion'] = $atraccion->find($id);

    $validation = \Config\Services::validation();

    if ((strtolower($this->request->getMethod()) === 'get')) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarAtracciones/editarAtraccion', $data);
    }

    $rules = [
        'animal' => 'required',
        'idArea' => 'required',
        'nombre' => 'required',
        'tipo' => 'required',
        'descripcion' => 'required',
        'horarios' => 'required',
        'costo' => 'required'
    ];

    if (!$this->validate($rules)) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarAtracciones/editarAtraccion', ['validation' => $validation], $data);
    } else {
        if ($this->updateAtraccion()) {
            return redirect('Administrador/atraccionesTabla');
        }
    }
}

// Método que hace la actualización del registro en la base de datos, únicamente se invoca
// cuando las reglas de validación en el método editarAtraccion() han sido aceptadas, no se invoca de manera directa
// en los formularios
public function updateAtraccion()
{
    $atraccion = model('AtraccionesModel');
    $data = [
        "animal" => $_POST["animal"],
        "idArea" => $_POST['idArea'],
        "nombre" => $_POST["nombre"],
        "tipo" => $_POST["tipo"],
        "descripcion" => $_POST["descripcion"],
        "horarios" => $_POST["horarios"],
        "costo" => $_POST["costo"],
        "capacidadMax" => $_POST["capacidadMax"],
        "duracionAprox" => $_POST["duracionAprox"],
        "restriccionesDeSalud" => $_POST["restriccionesDeSalud"]
    ];
    $atraccion->update($_POST['idAtraccion'], $data);
    return true;
}
}
