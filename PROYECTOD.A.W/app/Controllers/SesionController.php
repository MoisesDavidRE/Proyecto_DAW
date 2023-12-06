<?php

namespace App\Controllers;

use App\Controllers\BaseController;
$session = \Config\Services::session();

class SesionController extends BaseController
{
    public function index()
    {
        $validation = \Config\Services::validation();
        if (strtolower($this->request->getMethod()) === 'get') {
            return view('common/header') .
                view('InicioSesion/iniciarSesion');
        }

        $rules = [
            'correo' => 'required',
            'contrasenia' => 'required'
        ];

        if (!$this->validate($rules)) {
            return view('common/header') .
                view('InicioSesion/iniciarSesion');
        } else {
            //si pasa las reglas
            $email = $_POST['correo'];
            $password = $_POST['contrasenia'];
            $usuarios = model('Usuarios');
            $data['usuario'] = $usuarios->where('correoElectronico', $email)
                ->where('contrasenia', $password)
                ->findAll();
            if (count($data['usuario']) > 0) {
                $session = session();
                $newdata = [
                    'idUsuario' => $data['usuario'][0]->numeroControl,
                    'Nombre' => $data['usuario'][0]->nombre,
                    'ApellidoPaterno' => $data['usuario'][0]->apellido_Paterno,
                    'ApellidoMaterno' => $data['usuario'][0]->apellido_Materno,
                    'Correo_Elec' => $data['usuario'][0]->correoElectronico,
                    'logged_in' => true,
                    'Perfil' => $data['usuario'][0]->perfilUsuario
                ];
                $session->set($newdata);
                if($session->get('Perfil')=='ADMINISTRADOR'){
                return redirect('Administrador/vistaGeneral');
                } 
                else if($session->get('Perfil')=='CLIENTE'){
                    return redirect ('Cliente/vistaGeneral');
                }
            } else {
                return redirect('/');
            }
        }
    }
    public function cerrarSesion(){
        $session = \Config\Services::session();
        $session->destroy();
        return redirect('/');
    }

        // Método que muestra la tabla de usuarios en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
public function registrar()
{
    $validation = \Config\Services::validation();

    if ((strtolower($this->request->getMethod()) === 'get')) {
        return
            view('common/header') .
            view('InicioSesion/registrar');
    }

    $rules = [
        'nombre' => [
            'label' => "Nombre",
            'rules' => 'required',
            'errors' => [
                'required' => 'El {field} es requerido'
                //Aquí puedes agregar el mensaje de una regla definida anteriormente
            ]
        ],
        'apellido_Paterno' => [
            'label' => "Apellido paterno",
            'rules' => 'required',
            'errors' => [
                'required' => 'El {field} es requerido'
                //Aquí puedes agregar el mensaje de una regla definida anteriormente
            ]
        ],
        'apellido_Materno' => [
            'label' => "Apellido materno",
            'rules' => 'required',
            'errors' => [
                'required' => 'El {field} es requerido'
                //Aquí puedes agregar el mensaje de una regla definida anteriormente
            ]
        ],
        'nombreUsuario' => [
            'label' => "Nombre de usuario",
            'rules' => 'required',
            'errors' => [
                'required' => 'El {field} es requerido'
                //Aquí puedes agregar el mensaje de una regla definida anteriormente
            ]
        ],
        'contrasenia' => [
            'label' => "Contraseña",
            'rules' => 'required',
            'errors' => [
                'required' => 'La {field} es requerida'
                //Aquí puedes agregar el mensaje de una regla definida anteriormente
            ]
        ],
        'correoElectronico' => [
            'label' => "Correo electrónico",
            'rules' => 'required',
            'errors' => [
                'required' => 'El {field} es requerido'
                //Aquí puedes agregar el mensaje de una regla definida anteriormente
            ]
        ],
    ];

    if (!$this->validate($rules)) {
        return
            view('common/header') .
            view('InicioSesion/registrar', ['validation' => $validation]);
    } else {
        if ($this->insertarUsuario()) {
            $nombre = $_POST['nombre'] . " " . $_POST['apellido_Paterno'] . " " . $_POST['apellido_Materno'];
            $mensaje = " fué agregado exitosamente, regresa al login para poder acceder con tu cuenta!";
            return
                view('common/header') .
                view('InicioSesion/registrar', ['mensaje' => $mensaje, 'nombre' => $nombre]);
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
        "imagenUsuario" => $_POST['ilustracion'],
        "nombreUsuario" => $_POST["nombreUsuario"],
        "contrasenia" => $_POST['contrasenia'],
        "perfilUsuario" => $_POST["perfilUsuario"],
        "correoElectronico" => $_POST["correoElectronico"],
        "comentarioPreferencias" => $_POST["comentarioPreferencias"]
    ];
    $usuario->insert($data, false);
    return true;
}

}

