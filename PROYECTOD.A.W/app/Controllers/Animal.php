<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

$session = \Config\Services::session();
$pager = \Config\Services::pager();

class Animal extends BaseController
{
    // Método que muestra la tabla de animales en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
    public function animalTabla()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
            $session->destroy();
            return redirect('/');
        }

        // Retornar en $data los datos de las tablas relacionadas
        $animalModel = model('AnimalModel');
        $areasModel = model('AreasModel');
        $especiesModel = model('EspeciesModel');
        $data['registros'] = count($animalModel->findAll());
        $data['animales'] = $animalModel->paginate(10);
        $data['areas'] = $areasModel->findAll();
        $data['especies'] = $especiesModel->findAll();
        $data['pager'] = $animalModel->pager;
        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAnimales/animalTabla', $data);
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
            'descripcion' => [
                'label' => "Descripción",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'edad' => [
                'label' => "Edad",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'dieta' => [
                'label' => "Dieta",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'area' => [
                'label' => "Área",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerida'
                ]
            ],
            'especie' => [
                'label' => "Especie",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'sexo' => 'required',
            'fechaNacimiento' => [
                'label' => "Fecha de nacimiento",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'historialMedico' => [
                'label' => "Historial médico",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAnimales/animalTabla', ['validation' => $validation], $data);
        } else {
            $this->_upload();
            if ($this->insertarAnimal()) {

                $nombre = $_POST['nombre'];
                $mensaje = " fué agregado exitosamente!";
                return
                    view('common/header', $data) .
                    view('common/menu') .
                    view('administrarAnimales/animalTabla', ['mensaje' => $mensaje, 'nombre' => $nombre]);
            }
        }
    }

    // Método para visualizar las especificaciones del animal, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
    public function especificacionesAnimal($idAnimal)
    {
        $session = session();
        if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
            $session->destroy();
            return redirect('/');
        }

        $animalModel = model('AnimalModel');
        $data['animal'] = $animalModel->find($idAnimal);
        return
            view('common/menu') .
            view('administrarAnimales/especificacionesAnimal', $data);
    }

    // Método que hace la propia inserción del animal en la base de datos
// Únicamente se invoca cuando las reglas de validación han sido aceptadas en el
// método agregarAnimal(), no es invocado de manera directa en los formularios
    public function insertarAnimal()
    {
        $animalModel = model('AnimalModel');
        $data = [
            "especie" => $_POST["idEspecie"],
            "nombre" => $_POST['nombre'],
            "descripcion" => $_POST["descripcion"],
            "ilustracion" => $_POST["ilustracion"],
            "edad" => $_POST["edad"],
            "sexo" => $_POST['sexo'],
            "area" => $_POST["area"],
            "dieta" => $_POST["dieta"],
            "expectativaDeVida" => $_POST["expectativaDeVida"],
            "fechaNacimiento" => $_POST['fechaNacimiento'],
            "historialMedico" => $_POST['historialMedico']
        ];
        $animalModel->insert($data, false);
        return true;
    }


    // Función que elimina de la base de datos el registro coincidente con el ID que recibe como parámetro
    public function eliminarAnimal($id)
    {
        $animalModel = model('AnimalModel');
        $animalModel->delete($id);
        return redirect('Administrador/animalTabla');
    }


    // Método que ayuda a validar los datos insertados en el formulario para editar un registro en específico
// Dicho registro es específicado mediante el ID que la función recibe como parámetro
// En caso de que las reglas de validación sean aceptadas, se invoca al método updateAnimal()
    public function editarAnimal($idAnimal)
    {
        $session = session();
        if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
            $session->destroy();
            return redirect('/');
        }

        $areas = model('AreasModel');
        $especieModel = model('EspeciesModel');
        $animalModel = model('AnimalModel');
        $data['areas'] = $areas->findAll();
        $data['animal'] = $animalModel->find($idAnimal);
        $data['especies'] = $especieModel->findAll();

        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAnimales/editarAnimal', $data);
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
            'descripcion' => [
                'label' => "Descripción",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'edad' => [
                'label' => "Edad",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'dieta' => [
                'label' => "Dieta",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'area' => [
                'label' => "Área",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerida'
                ]
            ],
            'especie' => [
                'label' => "Especie",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'sexo' => 'required',
            'fechaNacimiento' => [
                'label' => "Fecha de nacimiento",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                ]
            ],
            'historialMedico' => [
                'label' => "Historial médico",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} es requerido'
                ]
            ]
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAnimales/editarAnimal', ['validation' => $validation], $data);
        } else {
            $this->_upload();
            if ($this->updateAnimal()) {
                return redirect('Administrador/animalTabla');
            }
        }
    }

    private function _upload()
    {
        if ($imageFile = $this->request->getFile('ilustracion')) {
            if ($imageFile->isValid() && !$imageFile->hasMoved()) {
                $nombre = $imageFile->getRandomName();
                $imageFile->move("C:/Users/Moisés David/Desktop/Proyecto_DAW/PROYECTOD.A.W/public/img/", $nombre);
                $_POST['ilustracion'] = $nombre;
                return true;
            }
        }
    }

    // Método que hace la actualización del registro en la base de datos, únicamente se invoca
// cuando las reglas de validación en el método editarAnimal() han sido aceptadas, no se invoca de manera directa
// en los formularios
    public function updateAnimal()
    {
        $animal = model('AnimalModel');
        $data = [
            "especie" => $_POST['especie'],
            "nombre" => $_POST['nombre'],
            "ilustracion" => $_POST['ilustracion'],
            "sexo" => $_POST['sexo'],
            'edad' => $_POST['edad'],
            'descripcion' => $_POST['descripcion'],
            'area' => $_POST['area'],
            'dieta' => $_POST['dieta'],
            'expectativaDeVida' => $_POST['expectativaDeVida'],
            'fechaNacimiento' => $_POST['fechaNacimiento'],
            'historialMedico' => $_POST['historialMedico']
        ];
        $animal->update($_POST['idAnimal'], $data);
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
    public function ReporteAnimales()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
            $session->destroy();
            return redirect('/');
        }

        $animalModel = model('AnimalModel');
        $areasModel = model('AreasModel');
        $especiesModel = model('EspeciesModel');
        $data['animales'] = $animalModel->findAll();
        $data['areas'] = $areasModel->findAll();
        $data['especies'] = $especiesModel->findAll();


        $pdf = new Dompdf();
        $options = $pdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $pdf->setOptions($options);
        $pdf->load_html(
            view('common/menu') .
            view('administrarAnimales/reporte', $data)
        );
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('Reporte de animales', array("Attachment" => 0));
    }
}
