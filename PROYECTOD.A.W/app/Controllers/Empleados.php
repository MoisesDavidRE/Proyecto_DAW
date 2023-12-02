<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

$session = \Config\Services::session();
$pager = \Config\Services::pager();

class Empleados extends BaseController
{
       // Método que muestra la tabla de empleados en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
public function empleadosTabla()
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $empleados = model('EmpleadoModel');
    $data['empleados'] = $empleados->findAll();
    return
        view('common/menu') .
        view('empleados/mostrar', $data);
}

// Método para visualizar las especificaciones del empleado, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
public function especificacionesEmpleado($id)
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $empleado = model('EmpleadoModel');
    $data['empleado'] = $empleado->find($id);
    return
        view('common/menu') .
        view('empleados/especificacionesEmpleado', $data);
}

// Método que valida los campos del formulario para agregar un registro en la tabla
// "Empleado", en caso que las reglas de validación sean aceptadas, se invoca al método insertarEmpleado()
public function agregarEmpleado()
{

    $validation = \Config\Services::validation();

    $rules = [
        'nombre' => 'required',
        'apellido_Paterno' => 'required',
        'apellido_Materno' => 'required',
        'correoElectronico' => 'required',
        'telefono' => 'required',
        'fechaNacimiento' => 'required'
    ];

    if (!$this->validate($rules)) {
        return
            view('common/header') .
            view('common/menu') .
            view('empleados/mostrar', ['validation' => $validation]);
    } else {
        if ($this->insertarEmpleado()) {
            return redirect('Administrador/empleadosTabla');
        }
    }

}

// Método que hace la propia inserción del empleado en la base de datos
// Únicamente se invoca cuando las reglas de validación han sido aceptadas en el
// método agregarEmpleado(), no es invocado de manera directa en los formularios
public function insertarEmpleado()
{
    $empleado = model('EmpleadoModel');
    $data = [
        "nombre" => $_POST["nombre"],
        "apellido_Paterno" => $_POST['apellido_Paterno'],
        "apellido_Materno" => $_POST["apellido_Materno"],
        "correoElectronico" => $_POST["correoElectronico"],
        "telefono" => $_POST["telefono"],
        "fechaNacimiento" => $_POST["fechaNacimiento"],
        "imagenEmpleado" => $_POST["imagenEmpleado"]
    ];
    $empleado->insert($data, false);
    return true;
}

// Función que elimina de la base de datos el registro coincidente con el ID que recibe como parámetro
public function eliminarEmpleado($id)
{
    $empleado = model('EmpleadoModel');
    $empleado->delete($id);
    return redirect('Administrador/empleadosTabla');
}

// Método que ayuda a validar los datos insertados en el formulario para editar un registro en específico
// Dicho registro es específicado mediante el ID que la función recibe como parámetro
// En caso de que las reglas de validación sean aceptadas, se invoca al método updateEmpleado()
public function editarEmpleado($id)
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $empleado = model('EmpleadoModel');
    $data['empleado'] = $empleado->find($id);

    $validation = \Config\Services::validation();

    if ((strtolower($this->request->getMethod()) === 'get')) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('empleados/editarEmpleado', $data);
    }

    $rules = [
        'nombre' => 'required',
        'apellido_Paterno' => 'required',
        'apellido_Materno' => 'required',
        'correoElectronico' => 'required',
        'telefono' => 'required',
        'fechaNacimiento' => 'required'
    ];

    if (!$this->validate($rules)) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('empleados/editarEmpleado', ['validation' => $validation], $data);
    } else {
        if ($this->updateEmpleado()) {
            return redirect('Administrador/empleadosTabla');
        }
    }
}

// Método que hace la actualización del registro en la base de datos, únicamente se invoca
// cuando las reglas de validación en el método editarEmpleado() han sido aceptadas, no se invoca de manera directa
// en los formularios
public function updateEmpleado()
{
    $empleado = model('EmpleadoModel');
    $data = [
        "nombre" => $_POST["nombre"],
        "apellido_Paterno" => $_POST['apellido_Paterno'],
        "apellido_Materno" => $_POST["apellido_Materno"],
        "correoElectronico" => $_POST["correoElectronico"],
        "telefono" => $_POST["telefono"],
        "fechaNacimiento" => $_POST["fechaNacimiento"],
        "imagenEmpleado" => $_POST["imagenEmpleado"]
    ];
    $empleado->update($_POST['idEmpleado'], $data);
    return true;
}
}
