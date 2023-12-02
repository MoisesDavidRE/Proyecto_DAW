<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

$session = \Config\Services::session();
$pager = \Config\Services::pager();


class Usuarios extends BaseController
{
    
    // Método que muestra la tabla de usuarios en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
public function usuariosTabla()
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $usuarios = model('Usuarios');
    $data['usuarios'] = $usuarios->findAll();
    return
        view('common/menu') .
        view('administrarUsuarios/usuariosTabla', $data);
}

// Método para visualizar las especificaciones del usuario, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
public function especificacionesUsuario($id)
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $usuario = model('Usuarios');
    $data['usuario'] = $usuario->find($id);
    return
        view('common/menu') .
        view('administrarUsuarios/usuarioEspecificaciones', $data);
}

// Método que valida los campos del formulario para agregar un registro en la tabla
// "Usuario", en caso que las reglas de validación sean aceptadas, se invoca al método insertarUsuario()
public function agregarUsuario()
{

    $validation = \Config\Services::validation();

    $rules = [
        'nombre' => 'required',
        'apellido_Paterno' => 'required',
        'apellido_Materno' => 'required',
        'nombreUsuario' => 'required',
        'contrasenia' => 'required',
        'perfilUsuario' => 'required',
        'correoElectronico' => 'required'
    ];

    $usuarios = model('Usuarios');
    $data['usuarios'] = $usuarios->findAll();

    if (!$this->validate($rules)) {
        return
            view('common/header') .
            view('common/menu') .
            view('administrarUsuarios/usuariosTabla', ['validation' => $validation], $data);
    } else {
        if ($this->insertarUsuario()) {
            return redirect('Administrador/usuariosTabla');
        }
    }

}

// Método que hace la propia inserción del usuario en la base de datos
// Únicamente se invoca cuando las reglas de validación han sido aceptadas en el
// método agregarUsuario(), no es invocado de manera directa en los formularios
public function insertarUsuario()
{
    $usuario = model('Usuarios');
    $data = [
        "nombre" => $_POST["nombre"],
        "apellido_Paterno" => $_POST['apellido_Paterno'],
        "apellido_Materno" => $_POST["apellido_Materno"],
        "nombreUsuario" => $_POST["nombreUsuario"],
        "contrasenia" => $_POST['contrasenia'],
        "perfilUsuario" => $_POST["perfilUsuario"],
        "correoElectronico" => $_POST["correoElectronico"],
        "fechaNacimiento" => $_POST["fechaNacimiento"],
        "comentarioPreferencias" => $_POST["comentarioPreferencias"]
    ];
    $usuario->insert($data, false);
    return true;
}

// Función que elimina de la base de datos el registro coincidente con el ID que recibe como parámetro
public function eliminarUsuario($id)
{
    $usuario = model('Usuarios');
    $usuario->delete($id);
    return redirect('Administrador/usuariosTabla');
}

// Método que ayuda a validar los datos insertados en el formulario para editar un registro en específico
// Dicho registro es específicado mediante el ID que la función recibe como parámetro
// En caso de que las reglas de validación sean aceptadas, se invoca al método updateUsuario()
public function editarUsuario($id)
{
    $session = session();
    if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
        $session->destroy();
        return redirect('/');
    }

    $usuario = model('Usuarios');
    $data['usuario'] = $usuario->find($id);

    $validation = \Config\Services::validation();

    if ((strtolower($this->request->getMethod()) === 'get')) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarUsuarios/editarUsuario', $data);
    }

    $rules = [
        'nombre' => 'required',
        'apellido_Paterno' => 'required',
        'apellido_Materno' => 'required',
        'nombreUsuario' => 'required',
        'contrasenia' => 'required',
        'perfilUsuario' => 'required',
        'correoElectronico' => 'required'
    ];

    if (!$this->validate($rules)) {
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarUsuarios/editarUsuario', ['validation' => $validation], $data);
    } else {
        if ($this->updateUsuario()) {
            return redirect('Administrador/usuariosTabla');
        }
    }
}

// Método que hace la actualización del registro en la base de datos, únicamente se invoca
// cuando las reglas de validación en el método editarUsuario() han sido aceptadas, no se invoca de manera directa
// en los formularios
public function updateUsuario()
{
    $usuario = model('Usuarios');
    $data = [
        "nombre" => $_POST["nombre"],
        "apellido_Paterno" => $_POST['apellido_Paterno'],
        "apellido_Materno" => $_POST["apellido_Materno"],
        "nombreUsuario" => $_POST["nombreUsuario"],
        "contrasenia" => $_POST['contrasenia'],
        "perfilUsuario" => $_POST["perfilUsuario"],
        "correoElectronico" => $_POST["correoElectronico"],
        "fechaNacimiento" => $_POST["fechaNacimiento"],
        "comentarioPreferencias" => $_POST["comentarioPreferencias"]
    ];
    $usuario->update($_POST['numeroControl'], $data);
    return true;
}
}
