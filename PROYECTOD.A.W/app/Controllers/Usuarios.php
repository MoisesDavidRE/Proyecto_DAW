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
        $data['registros'] = count($usuarios->findAll());
        $data['usuarios'] = $usuarios->paginate(10);
        $data['pager'] = $usuarios->pager;
        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarUsuarios/usuariosTabla', $data);
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
                view('common/menu') .
                view('administrarUsuarios/usuariosTabla', ['validation' => $validation], $data);
        } else {
            $this->_upload();
            if ($this->insertarUsuario()) {
                $nombre = $_POST['nombre'] . " " . $_POST['apellido_Paterno'] . " " . $_POST['apellido_Materno'];
                $mensaje = " fué agregado exitosamente!";
                return
                    view('common/header', $data) .
                    view('common/menu') .
                    view('administrarUsuarios/usuariosTabla', ['mensaje' => $mensaje, 'nombre' => $nombre]);
            }
        }
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

    // Función que elimina de la base de datos el registro coincidente con el ID que recibe como parámetro
    public function eliminarUsuario($id)
    {
        $usuario = model('Usuarios');
        $usr = $usuario->find($id);
        if (isset($usr->nombre)) {
            $nombre = $usr->nombre . " " . $usr->apellido_Paterno . " " . $usr->apellido_Materno;
        }
        $mensaje = " fue eliminado";
        $data['registros'] = count($usuario->findAll());
        $data['usuarios'] = $usuario->paginate(10);
        $data['pager'] = $usuario->pager;
        $usuario->delete($id);
        return
            view('common/header', $data) .
            view('common/menu') .
            view('administrarUsuarios/usuariosTabla',['mensajeEliminar'=>$mensaje,'nombre'=>$nombre]);
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
        $data['registros'] = count($usuario->findAll());
        $data['usuarios'] = $usuario->paginate(10);
        $data['pager'] = $usuario->pager;

        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarUsuarios/editarUsuario', $data);
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
                view('common/header', $data) .
                view('common/menu') .
                view('administrarUsuarios/editarUsuario', ['validation' => $validation], $data);
        } else {
            $this->_upload();
            if ($this->updateUsuario()) {
                $nombre = $_POST['nombre'] . " " . $_POST['apellido_Paterno'] . " " . $_POST['apellido_Materno'];
                $mensaje = " fue editado correctamente";
                return
                    view('common/header', $data) .
                    view('common/menu') .
                    view('administrarUsuarios/usuariosTabla', ['mensajeEditar' => $mensaje, 'nombre' => $nombre]);
            }
        }
    }

    private function _upload()
    {
        if ($imageFile = $this->request->getFile('ilustracion')) {
            if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                $nombre = $imageFile->getRandomName();
                $imageFile->move("C:/Users/Moisés David/Desktop/Proyecto_DAW/PROYECTOD.A.W/public/avatar/", $nombre);
                $_POST['ilustracion'] = $nombre;
                return true;
            }
        }
    }

    // Método que hace la actualización del registro en la base de datos, únicamente se invoca
// cuando las reglas de validación en el método editarUsuario() han sido aceptadas, no se invoca de manera directa
// en los formularios
    public function updateUsuario()
    {
        $usuario = model('Usuarios');
        if (isset($_POST["ilustracion"])) {
            $ilustracion = $_POST['ilustracion'];
        } else
            $ilustracion = $_POST['perfilActual'];
        $data = [
            "nombre" => $_POST["nombre"],
            "apellido_Paterno" => $_POST['apellido_Paterno'],
            "apellido_Materno" => $_POST["apellido_Materno"],
            "nombreUsuario" => $_POST["nombreUsuario"],
            "imagenUsuario" => $ilustracion,
            "contrasenia" => $_POST['contrasenia'],
            "perfilUsuario" => $_POST["perfilUsuario"],
            "correoElectronico" => $_POST["correoElectronico"],
            "comentarioPreferencias" => $_POST["comentarioPreferencias"]
        ];
        $usuario->update($_POST['numeroControl'], $data);
        return true;
    }


    public function ReporteUsuarios()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
            $session->destroy();
            return redirect('/');
        }

        $usuario = model('Usuarios');
        $data['usuarios'] = $usuario->findAll();

        $pdf = new Dompdf();
        $options = $pdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $pdf->setOptions($options);
        $pdf->load_html(
            view('common/menu') .
            view('administrarUsuarios/reporte', $data)
        );
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('Reporte de usuarios', array("Attachment" => 1));
    }

    public function buscarUsuario()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            return redirect('/');
        }

        $usuarios = model('Usuarios');
        $data['usuarios'] = $usuarios->findAll();

        if (isset($_GET['Buscador']) && isset($_GET['Valor'])) {
            $buscador = $_GET['Buscador'];
            $valor = $_GET['Valor'];

            if ($buscador == 'Nombre') {
                $data['usuarios'] = $usuarios->like('nombre', $valor)->findAll();
            }

            if ($buscador == 'apellido_Paterno') {
                $data['usuarios'] = $usuarios->like('apellido_Paterno', $valor)->findAll();
            }

            if ($buscador == 'apellido_Materno') {
                $data['usuarios'] = $usuarios->like('apellido_Materno', $valor)->findAll();
            }

            if ($buscador == 'numeroControl') {
                $data['usuarios'] = $usuarios->like('numeroControl', $valor)->findAll();
            }

            if ($buscador == 'nombreUsuario') {
                $data['usuarios'] = $usuarios->like('nombreUsuario', $valor)->findAll();
            }
            if ($buscador == 'perfil') {
                $data['usuarios'] = $usuarios->like('perfil', strtoupper($valor))->findAll();
            }
            if ($buscador == 'correoElectronico') {
                $data['usuarios'] = $usuarios->like('correoElectronico', $valor)->findAll();
            }
        } else {
            $buscador = null;
            $valor = null;
            $data['usuarios'] = $usuarios->findAll();
        }
        return
            view('common/header') .
            view('common/menu') .
            view('administrarUsuarios/buscar', $data);
    }
}
