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
        $data['registros'] = count($areasModel->findAll());
        $data['empleados'] = $empleados->findAll();
        $data['areas'] = $areasModel->paginate(10);
        $data['pager'] = $areasModel->pager;

        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAreas/areasTabla', $data);
        }

        $rules = [
            'encargado' => [
                'label' => "Encargado",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
            'nombre' => [
                'label' => "Nombre",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
            'descripcion' => [
                'label' => "Descripción",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'temperatura' => [
                'label' => "Temperatura",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'phPromedio' => [
                'label' => "PH Promedio",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'iluminacion' => [
                'label' => "Iluminación",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'filtracionAgua' => [
                'label' => "Filtración del agua",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'noHabitantesMax' => [
                'label' => "Número máximo de habitantes",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'estado' => [
                'label' => "Estado",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'nivelAcceso' => [
                'label' => "Nivel de acceso",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'horaMantenimiento' => [
                'label' => "Hora de mantenimiento",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAreas/areasTabla', ['validation' => $validation], $data);
        } else {
            $this->_upload();
            if ($this->insertarArea()) {

                $nombre = $_POST['nombre'];
                $mensaje = " fué agregada exitosamente!";
                return view('common/header', $data) .
                    view('common/menu') .
                    view('administrarAreas/areasTabla', ['mensaje' => $mensaje, 'nombre' => $nombre]);
            }
        }
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
        if (isset($_POST["imagen"])) {
            $ilustracion = $_POST["imagen"];
        } else
            $ilustracion = null;
        $data = [
            "encargado" => $_POST["encargado"],
            "nombre" => $_POST['nombre'],
            "descripcion" => $_POST["descripcion"],
            "imagen" => $ilustracion,
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
        
        $areasModel = model('AreasModel');
        $empleados = model('EmpleadoModel');
        $area = $areasModel->find($id);
        if(isset($area->nombre)){
            $nombre = $area->nombre;
            } else { $nombre = null; $mensaje = null; }
        $mensaje = ' fue eliminada';
        $data['registros'] = count($areasModel->findAll());
        $data['empleados'] = $empleados->findAll();
        $data['areas'] = $areasModel->paginate(10);
        $data['pager'] = $areasModel->pager;
        $areasModel->delete($id);
        return 
            view('common/header', $data) .
            view('common/menu') . 
            view('administrarAreas/areasTabla',['mensajeEliminar' => $mensaje, 'nombre' => $nombre]);
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
        $data['areas'] = $areas->paginate(10);
        $data['area'] = $areas->find($id);
        $data['empleados'] = $empleados->findAll();
        $data['registros'] = count($areas->findAll());
        $data['pager'] = $areas->pager;

        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAreas/editarArea', $data);
        }
        $rules = [
            'encargado' => [
                'label' => "Encargado",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
            'nombre' => [
                'label' => "Nombre",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
            'descripcion' => [
                'label' => "Descripción",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'temperatura' => [
                'label' => "Temperatura",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'phPromedio' => [
                'label' => "PH Promedio",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'iluminacion' => [
                'label' => "Iluminación",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'filtracionAgua' => [
                'label' => "Filtración del agua",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'noHabitantesMax' => [
                'label' => "Número máximo de habitantes",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'estado' => [
                'label' => "Estado",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'nivelAcceso' => [
                'label' => "Nivel de acceso",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
            'horaMantenimiento' => [
                'label' => "Hora de mantenimiento",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAreas/editarArea', ['validation' => $validation], $data);
        } else {
            $this->_upload();
            if ($this->updateArea()) {
                $nombre = $_POST['nombre'];
                $mensaje = " ha sido editada exitosamente!";
                return
                    view('common/header', $data) .
                    view('common/menu') .
                    view('administrarAreas/areasTabla', ['mensajeEditar' => $mensaje, 'nombre' => $nombre]);
            }
        }
    }

    private function _upload()
    {
        if ($imageFile = $this->request->getFile('imagen')) {
            if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                $nombre = $imageFile->getRandomName();
                $imageFile->move("C:/Users/Moisés David/Desktop/Proyecto_DAW/PROYECTOD.A.W/public/areas/", $nombre);
                $_POST['imagen'] = $nombre;
                return true;
            }
        }
    }

    // Método que hace la actualización del registro en la base de datos, únicamente se invoca
// cuando las reglas de validación en el método editarArea() han sido aceptadas, no se invoca de manera directa
// en los formularios
    public function updateArea()
    {
        $area = model('AreasModel');
        if (isset($_POST["imagen"])) {
            $ilustracion = $_POST["imagen"];
        } else
            $ilustracion = $_POST['imagenActual'];
        $data = [
            "encargado" => $_POST["encargado"],
            "nombre" => $_POST['nombre'],
            "descripcion" => $_POST["descripcion"],
            "tamanio" => $_POST["tamanio"],
            "imagen" => $ilustracion,
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

    public function buscarArea()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            return redirect('/');
        }

        $areas = model('AreasModel');
        $empleados = model('EmpleadoModel');
        $data['areas'] = $areas->findAll();
        $data['empleados'] = $empleados->findAll();

        if (isset($_GET['Buscador']) && isset($_GET['Valor'])) {
            $buscador = $_GET['Buscador'];
            $valor = $_GET['Valor'];

            if ($buscador == 'Nombre') {
                $data['areas'] = $areas->like('nombre', $valor)->findAll();
                if (isset($data['areas'][0])) {
                    $data['empleados'] = $empleados->where('idEmpleado', ($data['areas'][0]->encargado))->findAll();
                } else {
                    $buscador = 'Todo';
                }
            }

            if ($buscador == 'Tamanio') {
                $data['areas'] = $areas->like('tamanio', $valor)->findAll();
                if (isset($data['areas'][0])) {
                    $data['empleados'] = $empleados->where('idEmpleado', ($data['areas'][0]->encargado))->findAll();
                } else {
                    $buscador = 'Todo';
                }
            }

            if ($buscador == 'Encargado') {
                $data['empleados'] = $empleados->like('nombre', $valor)->like('apellido_Paterno', $valor)->like('apellido_Materno', $valor)->findAll();
                if (isset($data['empleados'][0])) {
                    $data['areas'] = $areas->where('encargado', ($data['empleados'][0]->idEmpleado))->findAll();
                } else {
                    $buscador = 'Todo';
                }
            }
            if ($buscador == 'nivelAcceso') {
                $data['areas'] = $areas->like('nivelAcceso', $valor)->findAll();
                if (isset($data['areas'][0])) {
                    $data['empleados'] = $areas->where('encargado', ($data['empleados'][0]->idEmpleado))->findAll();
                } else {
                    $buscador = 'Todo';
                }
            }
        } else {
            $data['areas'] = $areas->findAll();
        }
        return
            view('common/header') .
            view('common/menu') .
            view('administrarAreas/buscar', $data);
    }

    public function ReporteAreas()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
            $session->destroy();
            return redirect('/');
        }

        $areas = model('AreasModel');

        $empleados = model('EmpleadoModel');
        $data['empleados'] = $empleados->findAll();
        $data['areas'] = $areas->findAll();


        $pdf = new Dompdf();
        $options = $pdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $pdf->setOptions($options);
        $pdf->load_html(
            view('common/menu') .
            view('administrarAreas/reporte', $data)
        );
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('Reporte de áreas', array("Attachment" => 1));
    }

}
