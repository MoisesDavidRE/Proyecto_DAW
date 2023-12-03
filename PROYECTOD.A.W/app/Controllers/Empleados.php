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
        $data['empleados'] = $empleados->paginate(10);
        $data['registros'] = count($empleados->findAll());
        $data['pager'] = $empleados->pager;
        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/menu') .
                view('empleados/mostrar', $data);
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
            'correoElectronico' => [
                'label' => "Nombre",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
            'telefono' => [
                'label' => "Teléfono",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header') .
                view('common/menu') .
                view('empleados/mostrar', ['validation' => $validation]);
        } else {
            $this->_upload();
            if ($this->insertarEmpleado()) {
                $nombre = $_POST['nombre'] . " " . $_POST['apellido_Paterno'] . " " . $_POST['apellido_Materno'];
                $mensaje = "fue registrado exitosamente";
                return 
                    view('common/header', $data) .
                    view('common/menu') . 
                    view('empleados/mostrar',['mensaje'=>$mensaje,'nombre'=>$nombre]);
            }
        }
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
            "imagenEmpleado" => $_POST["ilustracion"]
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
            'correoElectronico' => [
                'label' => "Nombre",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
            'telefono' => [
                'label' => "Teléfono",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('empleados/editarEmpleado', ['validation' => $validation], $data);
        } else {
            $this->_upload();
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
            "imagenEmpleado" => $_POST["ilustracion"]
        ];
        $empleado->update($_POST['idEmpleado'], $data);
        return true;
    }
    private function _upload()
    {
        if ($imageFile = $this->request->getFile('ilustracion')) {
            if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                $nombre = $imageFile->getRandomName();
                $imageFile->move("C:/Users/Moisés David/Desktop/Proyecto_DAW/PROYECTOD.A.W/public/imgEmpleados/", $nombre);
                $_POST['ilustracion'] = $nombre;
                return true;
            }
        }
    }

    public function ReporteEmpleados()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
            $session->destroy();
            return redirect('/');
        }

        $empleados = model('EmpleadoModel');
        $data['empleados'] = $empleados->findAll();
        $pdf = new Dompdf();
        $options = $pdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $pdf->setOptions($options);
        $pdf->load_html(
            view('common/menu') .
            view('empleados/reporte', $data)
        );
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('Reporte de empleados', array("Attachment" => 1));
    }

    public function buscarAnimal()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            return redirect('/');
        }

        $especies = model('EspeciesModel');
        $animales = model('AnimalModel');
        $data['especies'] = $especies->findAll();
        $data['animales'] = $animales->findAll();

        if (isset($_GET['Buscador']) && isset($_GET['Valor'])) {
            $buscador = $_GET['Buscador'];
            $valor = $_GET['Valor'];


            if ($buscador == 'Nombre') {
                $data['animales'] = $animales->like('nombre', $valor)
                    ->findAll();
                if (isset($data['animales'][0])) {
                    $data['especies'] = $especies->where('idEspecie', ($data['animales'][0]->especie))->findAll();
                } else {
                    $buscador = 'Todo';
                }
            }

            if ($buscador == 'numeroIdentificador') {
                $data['animales'] = $animales->like('numeroIdentificador', $valor)
                    ->findAll();
                if (isset($data['animales'][0])) {
                    $data['especies'] = $especies->where('idEspecie', ($data['animales'][0]->especie))->findAll();
                } else {
                    $buscador = 'Todo';
                }
            }

            if ($buscador == 'Especie') {
                $data['especies'] = $especies->like('idEspecie', $valor)
                    ->findAll();
                if (isset($data['especies'][0])) {
                    $data['animales'] = $animales->where('especie', ($data['especies'][0]->idEspecie))->findAll();
                } else {
                    $buscador = 'Todo';
                }
            }
        } else {
            $buscador =
                $valor =

                $data['animales'] = $animales->findAll();
        }
        return
            view('common/header') .
            view('common/menu') .
            view('administrarAnimales/buscar', $data);
    }
}
