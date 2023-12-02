<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use Dompdf\Dompdf;

$session = \Config\Services::session();
$pager = \Config\Services::pager();

class AdminController extends BaseController
{

    // Al iniciar sesión exitosamente esta es la vista que se muestra al usuario
    // Se proteje el acceso mediante URL en caso de que no esté iniciada la sesión o el usuario no sea administrador
    public function vistaGeneral()
    {
        $session = session();
        if ($session->get('logged_in') != TRUE || $session->get('Perfil') != 'ADMINISTRADOR') {
            $session->destroy();
            return redirect('/');
        }

        return
            view('common/menu') .
            view('Administrador/vistaGeneral');
    }

}