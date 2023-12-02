<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

$session = \Config\Services::session();
$pager = \Config\Services::pager();


class Reservacion extends BaseController
{
       // Método que muestra la tabla de reservaciones en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
public function reservacionesTabla()
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    //Se adjuntan los datos de las tablas relacionadas de la base de datos
    $reservacion = model('ReservacionModel');
    $usuarios = model('Usuarios');
    $atraccion_animal = model('AtraccionAnimal');
    $data['usuarios'] = $usuarios->findAll();
    $data['atraccionesAnimal'] = $atraccion_animal->findAll();
    $data['reservaciones'] = $reservacion->findAll();

    return
        view('common/menu') .
        view('administrarReservaciones/reservacionesTabla', $data);
}

// Método para visualizar las especificaciones de la reservación, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
public function especificacionesReservacion($id)
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $reservacion = model('ReservacionModel');
    $data['reservacion'] = $reservacion->find($id);
    return
        view('common/menu') .
        view('administrarReservaciones/reservacionEspecificaciones', $data);
}

// Método que valida los campos del formulario para agregar un registro en la tabla
// "Reservacion", en caso que las reglas de validación sean aceptadas, se invoca al método insertarReservacion()
public function agregarReservacion()
{
    $atraccionAn = model('AtraccionAnimal');
    $usuario = model('Usuarios');
    $data['atraccionesAn'] = $atraccionAn->findAll();
    $data['usuarios'] = $usuario->findAll();

    $validation = \Config\Services::validation();

    $rules = [
        'atraccion_animal' => 'required',
        'usuario' => 'required',
        'fechaReservada' => 'required',
        'horaInicio' => 'required',
        'horaFin' => 'required',
        'estatus' => 'required',
        'costoTotal' => 'required'
    ];

    if (!$this->validate($rules)) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarReservaciones/reservacionesTabla', ['validation' => $validation], $data);
    } else {
        if ($this->insertarReservacion()) {
            return redirect('Administrador/reservacionesTabla');
        }
    }

}

// Método que hace la propia inserción de la reservación en la base de datos
// Únicamente se invoca cuando las reglas de validación han sido aceptadas en el
// método agregarReservacion(), no es invocado de manera directa en los formularios
public function insertarReservacion()
{
    $reservacion = model('ReservacionModel');
    $data = [
        "atraccion_animal" => $_POST["atraccion_animal"],
        "usuario" => $_POST['usuario'],
        "fechaReservada" => $_POST["fechaReservada"],
        "horaInicio" => $_POST["horaInicio"],
        "horaFin" => $_POST['horaFin'],
        "estatus" => $_POST["estatus"],
        "costoTotal" => $_POST["costoTotal"],
        "comentariosAdicionales" => $_POST["comentariosAdicionales"]
    ];
    $reservacion->insert($data, false);
    return true;
}
// Función que elimina de la base de datos el registro coincidente con el ID que recibe como parámetro
public function eliminarReservacion($id)
{
    $reservacion = model('ReservacionModel');
    $reservacion->delete($id);
    return redirect('Administrador/reservacionesTabla');
}

// Método que ayuda a validar los datos insertados en el formulario para editar un registro en específico
// Dicho registro es específicado mediante el ID que la función recibe como parámetro
// En caso de que las reglas de validación sean aceptadas, se invoca al método updateReservacion()
public function editarReservacion($id)
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $reservacion = model('ReservacionModel');
    $atraccionAn = model('AtraccionAnimal');
    $usuario = model('Usuarios');
    $data['reservacion'] = $reservacion->find($id);
    $data['atraccionesAn'] = $atraccionAn->findAll();
    $data['usuarios'] = $usuario->findAll();

    $validation = \Config\Services::validation();

    if ((strtolower($this->request->getMethod()) === 'get')) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarReservaciones/editarReservacion', $data);
    }

    $rules = [
        'atraccion_animal' => 'required',
        'usuario' => 'required',
        'fechaReservada' => 'required',
        'horaInicio' => 'required',
        'horaFin' => 'required',
        'estatus' => 'required',
        'costoTotal' => 'required'
    ];

    if (!$this->validate($rules)) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarReservaciones/editarReservacion', ['validation' => $validation], $data);
    } else {
        if ($this->updateReservacion()) {
            return redirect('Administrador/reservacionesTabla');
        }
    }
}


// Método que hace la actualización del registro en la base de datos, únicamente se invoca
// cuando las reglas de validación en el método editarReservacion() han sido aceptadas, no se invoca de manera directa
// en los formularios
public function updateReservacion()
{
    $reservacion = model('ReservacionModel');
    $data = [
        "atraccion_animal" => $_POST["atraccion_animal"],
        "usuario" => $_POST['usuario'],
        "fechaReservada" => $_POST["fechaReservada"],
        "horaInicio" => $_POST["horaInicio"],
        "horaFin" => $_POST['horaFin'],
        "estatus" => $_POST["estatus"],
        "costoTotal" => $_POST["costoTotal"],
        "comentariosAdicionales" => $_POST["comentariosAdicionales"]
    ];
    $reservacion->update($_POST['idReservacion'], $data);
    return true;
}
}
