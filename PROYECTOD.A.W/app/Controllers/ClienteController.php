<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

$session = \Config\Services::session();
$pager = \Config\Services::pager();

class ClienteController extends BaseController
{

    // Si el cliente inicia sesión exitosamente, ésta es la vista que se retorna y se muestra como inicio al cliente
// No se puede acceder mediante URL si la sesión es inexistente
    public function vistaGeneral()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            $session->destroy();
            return redirect('/');
        }
        return
            view('common/menuCliente') .
            view('Cliente/vistaGeneral');
    }
    public function atraccionesTabla()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            $session->destroy();
            return redirect('/');
        }

        $atracciones = model('AtraccionesModel');
        $data['atracciones'] = $atracciones->findAll();
        return
            view('common/menuCliente') .
            view('clienteAtracciones/atracciones', $data);
    }

    public function especificacionesAtraccion($id)
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            $session->destroy();
            return redirect('/');
        }

        $atraccion = model('AtraccionesModel');
        $data['atraccion'] = $atraccion->find($id);
        return
            view('common/header') .
            view('common/menuCliente') .
            view('clienteAtracciones/especificacionesAtraccion', $data);
    }

    public function animalesTabla()
    {

        $session = session();
        if ($session->get('logged_in') != TRUE) {
            $session->destroy();
            return redirect('/');
        }
        $animalModel = model('AnimalModel');
        $areasModel = model('AreasModel');
        $data['animales'] = $animalModel->paginate(10);
        $data['areas'] = $areasModel->findAll();
        $data['registros'] = count($animalModel->findAll());
        $data['pager'] = $animalModel->pager;

        return
            view('common/menuCliente') .
            view('clienteAnimales/animales', $data);
    }

    public function buscarAnimal()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            return redirect('/');
        }

        $animales = model('AnimalModel');
        $data['animales'] = $animales->findAll();

        if (isset($_GET['Buscador']) && isset($_GET['Valor'])) {
            $buscador = $_GET['Buscador'];
            $valor = $_GET['Valor'];


            if ($buscador == 'Nombre') {
                $data['animales'] = $animales->like('nombre', $valor)->findAll();
            }

            if ($buscador == 'numeroIdentificador') {
                $data['animales'] = $animales->like('numeroIdentificador', $valor)->findAll();
            }

            if ($buscador == 'Especie') {
                $data['animales'] = $animales->like('especie', $valor)->findAll();
            }
        } else {
            $buscador = null;
            $valor =

                $data['animales'] = $animales->findAll();
        }
        return
            view('common/header') .
            view('common/menuCliente') .
            view('clienteAnimales/buscar', $data);
    }

    public function ReporteAnimales()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            $session->destroy();
            return redirect('/');
        }

        $animalModel = model('AnimalModel');
        $areasModel = model('AreasModel');
        $data['animales'] = $animalModel->findAll();
        $data['areas'] = $areasModel->findAll();


        $pdf = new Dompdf();
        $options = $pdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $pdf->setOptions($options);
        $pdf->load_html(
            view('common/menuCliente') .
            view('clienteAnimales/reporte', $data)
        );
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('Tabla de animales', array("Attachment" => 1));
    }

    public function especificacionesAnimal($idAnimal)
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            $session->destroy();
            return redirect('/');
        }

        $animalModel = model('AnimalModel');
        $data['animal'] = $animalModel->find($idAnimal);
        return
            view('common/menuCliente') .
            view('clienteAnimales/especificaciones', $data);
    }

    public function reservacionesTabla()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            $session->destroy();
            return redirect('/');
        }

        $reservacion = model('ReservacionModel');
        $usuarios = model('Usuarios');
        $atracciones = model('AtraccionesModel');
        $data['registros'] = count($reservacion->findAll());
        $data['usuarios'] = $usuarios->findAll();
        $data['atracciones'] = $atracciones->findAll();
        $data['reservaciones'] = $reservacion->findAll();
        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menuCliente') .
                view('clienteReservaciones/reservaciones', $data);
        }

        $rules = [
            'fechaReservada' => [
                'label' => "Fecha de reservación",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ]
            //costo total, hora inicio y hora fin deben ser especificados automáticamente
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menuCliente') .
                view('clienteReservaciones/reservaciones', ['validation' => $validation], $data);
        } else {
            if ($this->insertarReservacion()) {
                $usr = $_POST['usuario'];
                $mensaje = " fué registrada exitosamente!";
                return
                    view('common/header', $data) .
                    view('common/menuCliente') .
                    view('clienteReservaciones/reservaciones', ['mensaje' => $mensaje, 'usr' => $usr]);
            }
        }
    }

    // Método que hace la propia inserción de la reservación en la base de datos
// Únicamente se invoca cuando las reglas de validación han sido aceptadas en el
// método agregarReservacion(), no es invocado de manera directa en los formularios
    // Método que hace la propia inserción de la reservación en la base de datos
// Únicamente se invoca cuando las reglas de validación han sido aceptadas en el
// método agregarReservacion(), no es invocado de manera directa en los formularios
    public function insertarReservacion()
    {
        $reservacion = model('ReservacionModel');
        $atraccion = model('AtraccionesModel');
        $atraccionSelec = $atraccion->find($_POST['atraccion']);
        $data = [
            "atraccion" => $_POST["atraccion"],
            "usuario" => $_POST['usuario'],
            "fechaReservada" => $_POST["fechaReservada"],
            "horaInicio" => $atraccionSelec->horaInicio,
            "horaFin" => $atraccionSelec->horaFin,
            "estatus" => $_POST["estatus"],
            "costoTotal" => $atraccionSelec->costo,
            "comentariosAdicionales" => $_POST["comentariosAdicionales"]
        ];
        $reservacion->insert($data, false);
        return true;
    }

    // Método para visualizar las especificaciones de la reservación, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
    public function especificacionesReservacion($id)
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            $session->destroy();
            return redirect('/');
        }

        $reservacion = model('ReservacionModel');
        $data['reservacion'] = $reservacion->find($id);
        return
            view('common/menuCliente') .
            view('clienteReservaciones/reservacionEspecificaciones', $data);
    }

    // Función que elimina de la base de datos el registro coincidente con el ID que recibe como parámetro
    public function eliminarReservacion($id)
    {
        $reservacionModel = model('ReservacionModel');
        $atracciones = model('AtraccionesModel');
        $usuarios = model('Usuarios');
        $reservacion = $reservacionModel->find($id);
        if (isset($reservacion->usuario)) {
            $usr = $reservacion->usuario;
            $mensaje = " fue eliminado";
        } else {
            $usr = null;
            $mensaje = null;
        }
        $mensaje = " fue eliminada";
        $reservacionModel->delete($id);
        $data['reservaciones'] = $reservacionModel->findAll();
        $data['atracciones'] = $atracciones->findAll();
        $data['usuarios'] = $usuarios->findAll();
        return
            view('common/header', $data) .
            view('common/menuCliente') .
            view('clienteReservaciones/reservaciones', ['mensajeEliminar' => $mensaje, 'usr' => $usr]);
    }

    public function buscarReservacion()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            return redirect('/');
        }

        $reservacion = model('ReservacionModel');
        $atracciones = model('AtraccionesModel');
        $usuario = model('Usuarios');
        $data['reservaciones'] = $reservacion->findAll();
        $data['atracciones'] = $atracciones->findAll();
        $data['usuarios'] = $usuario->findAll();

        if (isset($_GET['Buscador']) && isset($_GET['Valor'])) {
            $buscador = $_GET['Buscador'];
            $valor = $_GET['Valor'];

            if ($buscador == 'idReservacion') {
                $data['reservaciones'] = $reservacion->like('idReservacion', $valor)->findAll();
            }

            if ($buscador == 'atraccion') {
                $data['atracciones'] = $atracciones->like('nombre', $valor)->findAll();
                if (isset($data['atracciones'][0])) {
                    $data['reservaciones'] = $reservacion->where('atraccion', ($data['atracciones'][0]->idAtraccion))->findAll();
                } else {
                    $buscador = 'Todo';
                }
            }
            if ($buscador == 'usuario') {
                $data['usuarios'] = $usuario->like('nombre', $valor)->like('apellido_Paterno', $valor)->like('apellido_Materno', $valor)->findAll();
                if (isset($data['usuarios'][0])) {
                    $data['reservaciones'] = $reservacion->like('usuario', ($data['usuarios'][0]->numeroControl))->findAll();
                } else {
                    $buscador = 'Todo';
                }
            }
            if ($buscador == 'estatus') {
                $data['reservaciones'] = $reservacion->like('estatus', $valor)->findAll();
            }
        } else {
            $data['reservaciones'] = $reservacion->findAll();
        }
        return
            view('common/header') .
            view('common/menuCliente') .
            view('clienteReservaciones/buscar', $data);
    }

    public function ReporteReservaciones()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            $session->destroy();
            return redirect('/');
        }

        $reservacion = model('ReservacionModel');
        $usuarios = model('Usuarios');
        $atraccion = model('AtraccionesModel');
        $data['usuarios'] = $usuarios->findAll();
        $data['atracciones'] = $atraccion->findAll();
        $data['reservaciones'] = $reservacion->findAll();


        $pdf = new Dompdf();
        $options = $pdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $pdf->setOptions($options);
        $pdf->load_html(
            view('common/menuCliente') .
            view('clienteReservaciones/reporte', $data)
        );
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('Tabla de reservaciones', array("Attachment" => 1));
    }

    // Método que ayuda a validar los datos insertados en el formulario para editar un registro en específico
// Dicho registro es específicado mediante el ID que la función recibe como parámetro
// En caso de que las reglas de validación sean aceptadas, se invoca al método updateReservacion()
    public function editarReservacion($id)
    {
        $session = session();
        if ($session->get('logged_in') != TRUE) {
            $session->destroy();
            return redirect('/');
        }

        $reservacion = model('ReservacionModel');
        $atracciones = model('AtraccionesModel');
        $usuario = model('Usuarios');
        $data['reservaciones'] = $reservacion->findAll();
        $data['reservacion'] = $reservacion->find($id);
        $data['atracciones'] = $atracciones->findAll();
        $data['usuarios'] = $usuario->findAll();

        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menuCliente') .
                view('clienteReservaciones/editarReservacion', $data);
        }

        $rules = [
            'fechaReservada' => [
                'label' => "Fecha de reservación",
                'rules' => 'required',
                'errors' => [
                    'required' => 'La {field} es requerida'
                    //Aquí puedes agregar el mensaje de una regla definida anteriormente
                ]
            ]
            //costo total, hora inicio y hora fin deben ser especificados automáticamente
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menuCliente') .
                view('clienteReservaciones/editarReservacion', ['validation' => $validation], $data);
        } else {
            if ($this->updateReservacion()) {
                $usr = $_POST['usuario'];
                $mensaje = " fué editada exitosamente!";
                return view('common/header', $data) .
                    view('common/menuCliente') . view('clienteReservaciones/reservaciones', ['mensajeEditar' => $mensaje, 'usr' => $usr]);
            }
        }
    }

    // Método que hace la actualización del registro en la base de datos, únicamente se invoca
// cuando las reglas de validación en el método editarReservacion() han sido aceptadas, no se invoca de manera directa
// en los formularios
    public function updateReservacion()
    {
        $atracciones = model('AtraccionesModel');
        $reservacion = model('ReservacionModel');
        $atraccion = $atracciones->find($_POST['atraccion']);
        $data = [
            "atraccion" => $_POST["atraccion"],
            "usuario" => $_POST['usuario'],
            "fechaReservada" => $_POST["fechaReservada"],
            "horaInicio" => $atraccion->horaInicio,
            "horaFin" => $atraccion->horaFin,
            "estatus" => $_POST["estatus"],
            "costoTotal" => $atraccion->costo,
            "comentariosAdicionales" => $_POST["comentariosAdicionales"]
        ];
        $reservacion->update($_POST['idReservacion'], $data);
        return true;
    }


}

