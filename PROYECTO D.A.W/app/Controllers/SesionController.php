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
}

