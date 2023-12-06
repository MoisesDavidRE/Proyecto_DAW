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
        $atracciones = model('AtraccionesModel');
        $data['registros'] = count($reservacion->findAll());
        $data['usuarios'] = $usuarios->findAll();
        $data['atracciones'] = $atracciones->findAll();
        $data['reservaciones'] = $reservacion->paginate(10);
        $data['pager'] = $reservacion->pager;

        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarReservaciones/reservacionesTabla', $data);
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
                view('common/menu') .
                view('administrarReservaciones/reservacionesTabla', ['validation' => $validation], $data);
        } else {
            if ($this->insertarReservacion()) {
                $usr = $_POST['usuario'];
                $mensaje = " fué registrada exitosamente!";
                return
                    view('common/header', $data) .
                    view('common/menu') .
                    view('administrarReservaciones/reservacionesTabla', ['mensaje' => $mensaje, 'usr' => $usr]);
            }
        }

    }

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

    // Función que elimina de la base de datos el registro coincidente con el ID que recibe como parámetro
    public function eliminarReservacion($id)
    {

        $reservacionModel = model('ReservacionModel');
        $atracciones = model('AtraccionesModel');
        $usuarios = model('Usuarios');
        $reservacion = $reservacionModel->find($id);
        if(isset($reservacion->usuario)){
            $usr = $reservacion->usuario;
            $mensaje = " fue eliminado";
            } else { $usr = null; $mensaje = null; }
            $mensaje = " fue eliminada";
        $reservacionModel->delete($id);
        $data['reservaciones'] = $reservacionModel->paginate(10);
        $data['atracciones'] = $atracciones->findAll();
        $data['usuarios'] = $usuarios->findAll();
        $data['registros'] = count($reservacionModel->findAll());
        $data['pager'] = $reservacionModel->pager;
        return 
        view('common/header', $data) .
        view('common/menu') .
        view('administrarReservaciones/reservacionesTabla',['mensajeEliminar' => $mensaje, 'usr' => $usr]);
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
        $atracciones = model('AtraccionesModel');
        $usuario = model('Usuarios');
        $data['reservacion'] = $reservacion->find($id);
        $data['reservaciones'] = $reservacion->paginate(10);
        $data['registros'] = count($reservacion->findAll());
        $data['atracciones'] = $atracciones->findAll();
        $data['usuarios'] = $usuario->findAll();
        $data['pager'] = $reservacion->pager;

        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarReservaciones/editarReservacion', $data);
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
                view('common/menu') .
                view('administrarReservaciones/editarReservacion', ['validation' => $validation], $data);
        } else {
            if ($this->updateReservacion()) {
                $usr = $_POST['usuario'];
                $mensaje = " fué editada exitosamente!";
                return 
                    view('common/header', $data) .
                    view('common/menu') . 
                    view('administrarReservaciones/reservacionesTabla', ['mensajeEditar' => $mensaje, 'usr' => $usr]);
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
            "atraccion" => $_POST["atraccion"],
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
    public function ReporteReservaciones()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
            $session->destroy();
            return redirect('/');
        }
        $reservaciones = model('ReservacionModel');
        $data['reservaciones'] = $reservaciones->findAll();
        $pdf = new Dompdf();
        $options = $pdf->getOptions();
        $options->set(array('isRemoteEnabled' => true));
        $pdf->setOptions($options);
        $pdf->load_html(
            view('common/menu') .
            view('administrarReservaciones/reporte', $data)
        );
        $pdf->setPaper('A4', 'landscape');
        $pdf->render();
        $pdf->stream('Reporte de reservaciones', array("Attachment" => 1));
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
            view('common/menu') .
            view('administrarReservaciones/buscar', $data);
    }
}
