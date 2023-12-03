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
        $data['atracciones'] = $atracciones->paginate(10);
        $data['registros'] = count($atracciones->findAll());
        $data['pager'] = $atracciones->pager;
        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAtracciones/atraccionesTabla', $data);
        }

        $rules = [
            'animal' => [
                'label' => "Animal",
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
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
            'horarios' => [
                'label' => "Horarios",
                'rules' => 'required',
                'errors' => [
                    'required' => 'Los {field} son requeridos'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
            'costo' => [
                'label' => "Costo",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} de la atracción es requerido'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAtracciones/atraccionesTabla', ['validation' => $validation], $data);
        } else {
            $nombre = $_POST['nombre'];
            $mensaje = " fué registrada exitosamente!";
            if ($this->insertarAtraccion()) {
                return
                    view('common/header', $data) .
                    view('common/menu') .
                    view('administrarAtracciones/atraccionesTabla',['mensaje'=>$mensaje,'nombre'=>$nombre],$data);
            }
        }
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
        $data['atracciones']=$atraccion->paginate(10);
        $data['pager'] = $atraccion->pager;
        $data['registros'] = count($atraccion->findAll());

        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAtracciones/editarAtraccion', $data);
        }

        $rules = [
            'animal' => [
                'label' => "Animal",
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
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
            'horarios' => [
                'label' => "Horarios",
                'rules' => 'required',
                'errors' => [
                    'required' => 'Los {field} son requeridos'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
            'costo' => [
                'label' => "Costo",
                'rules' => 'required',
                'errors' => [
                    'required' => 'El {field} de la atracción es requerido'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ],
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAtracciones/editarAtraccion', ['validation' => $validation], $data);
        } else {
            if ($this->updateAtraccion()) {
                $nombre = $_POST['nombre'];
                $mensajeEditar = " fué editado exitosamente";
                return
                    view('common/header', $data) .
                    view('common/menu') .
                    view('administrarAtracciones/atraccionesTabla',['mensaje'=>$mensajeEditar,'nombre'=>$nombre],$data);
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

    public function ReporteAtracciones()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
            $session->destroy();
            return redirect('/');
        }

        $atracciones = model('AtraccionesModel');
        $data['atracciones'] = $atracciones->findAll();
        $pdf = new Dompdf();
        $options = $pdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $pdf->setOptions($options);
        $pdf->load_html(
            view('common/menu') .
            view('administrarAtracciones/reporte', $data)
        );
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('Reporte de atracciones', array("Attachment" => 1));
    }

    public function buscarAtraccion()
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
