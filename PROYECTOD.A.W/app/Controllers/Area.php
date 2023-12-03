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
                    view('administrarAreas/areasTabla',['mensaje' => $mensaje, 'nombre' => $nombre]);
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
        $data = [
            "encargado" => $_POST["encargado"],
            "nombre" => $_POST['nombre'],
            "descripcion" => $_POST["descripcion"],
            "imagen" => $_POST["ilustracion"],
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
                return redirect('Administrador/areasTabla');
            }
        }
    }

    private function _upload()
    {
        if ($imageFile = $this->request->getFile('ilustracion')) {
            if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                $nombre = $imageFile->getRandomName();
                $imageFile->move("C:/Users/Moisés David/Desktop/Proyecto_DAW/PROYECTOD.A.W/public/areas/", $nombre);
                $_POST['ilustracion'] = $nombre;
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
        $data = [
            "encargado" => $_POST["encargado"],
            "nombre" => $_POST['nombre'],
            "descripcion" => $_POST["descripcion"],
            "tamanio" => $_POST["tamanio"],
            "imagen" => $_POST["ilustracion"],
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
