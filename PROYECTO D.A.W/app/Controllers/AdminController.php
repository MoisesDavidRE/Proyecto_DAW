<?php

namespace App\Controllers;

use App\Controllers\BaseController;
$session = \Config\Services::session();

class AdminController extends BaseController
{

    // Al iniciar sesión exitosamente esta es la vista que se muestra al usuario
    // Se proteje el acceso mediante URL en caso de que no esté iniciada la sesión o el usuario no sea administrador
    public function vistaGeneral()
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        return
            view('common/menu') .
            view('Administrador/vistaGeneral');
    }

// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
// Funciones para "Animal"

// Método que muestra la tabla de animales en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
    public function animalTabla()
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        // Retornar en $data los datos de las tablas relacionadas
        $animalModel = model('AnimalModel');
        $areasModel = model('AreasModel');
        $especiesModel = model('EspeciesModel');
        $data['animales'] = $animalModel->findAll();
        $data['areas'] = $areasModel->findAll();
        $data['especies'] = $especiesModel->findAll();
        return
            view('common/menu') .
            view('administrarAnimales/animalTabla', $data);
    }

// Método para visualizar las especificaciones del animal, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
    public function especificacionesAnimal($idAnimal)
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $animalModel = model('AnimalModel');
        $data['animal'] = $animalModel->find($idAnimal);
        return
            view('common/menu') .
            view('administrarAnimales/especificacionesAnimal', $data);
    }

// Método que valida los campos del formulario para agregar un registro en la tabla
// "Animal", en caso que las reglas de validación sean aceptadas, se invoca al método insertarAnimal()
    public function agregarAnimal()
    {
        $areas = model('AreasModel');
        $especieModel = model('EspeciesModel');
        $animales = model('AnimalModel');
        $data['animales'] = $animales->findAll();
        $data['areas'] = $areas->findAll();
        $data['especies'] = $especieModel->findAll();


        $validation = \Config\Services::validation();

        $rules = [
            'descripcion' => 'required',
            'edad' => 'required',
            'dieta' => 'required',
            'area' => 'required',
            'idEspecie' => 'required',
            'sexo' => 'required',
            'fechaNacimiento' => 'required',
            'historialMedico' => 'required'
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAnimales/animalTabla', ['validation' => $validation], $data);
        } else {
            if ($this->insertarAnimal()) {
                return redirect('Administrador/animalTabla');
            }
        }

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
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
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
            'descripcion' => 'required',
            'edad' => 'required',
            'dieta' => 'required',
            'area' => 'required',
            'especie' => 'required',
            'sexo' => 'required',
            'fechaNacimiento' => 'required',
            'historialMedico' => 'required'
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAnimales/editarAnimal', ['validation' => $validation], $data);
        } else {
            if ($this->updateAnimal()) {
                return redirect('Administrador/animalTabla');
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
        if($session->get('logged_in')!=TRUE){
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
                    $data['especies'] = $especies->where('idEspecie',($data['animales'][0]->especie))->findAll();       
                }
                else{
                    $buscador = 'Todo';
                }
            }

            if ($buscador == 'numeroIdentificador') {
                $data['animales'] = $animales->like('numeroIdentificador', $valor)
                ->findAll();
                if (isset($data['animales'][0])) {
                    $data['especies'] = $especies->where('idEspecie',($data['animales'][0]->especie))->findAll();  
                }
                else{
                    $buscador = 'Todo';
                }
            }

            if ($buscador == 'Especie') {
                $data['especies'] = $especies->like('idEspecie', $valor)
                ->findAll();
                if (isset($data['especies'][0])) {
                    $data['animales'] = $animales->where('especie',($data['especies'][0]->idEspecie))->findAll();  
                }
                else{
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












// ----------------------------------------------------------------------------------------------------------------------------------------------------------------
// Funciones para "Área"


// Método que muestra la tabla de áreas en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
    public function areasTabla()
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $areasModel = model('AreasModel');
        $empleados = model('EmpleadoModel');
        $data['empleados'] = $empleados->findAll();
        $data['areas'] = $areasModel->findAll();

        return
            view('common/menu') .
            view('administrarAreas/areasTabla', $data);
    }

// Método para visualizar las especificaciones del área, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
    public function especificacionesArea($id)
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
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
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
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
                view('administrarAreas/editarArea', ['validation' => $validation], $data);
        } else {
            if ($this->updateArea()) {
                return redirect('Administrador/areasTabla');
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

    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------
// Funciones para "Reservación"

// Método que muestra la tabla de reservaciones en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
    public function reservacionesTabla()
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        //Se adjuntan los datos de las tablas relacionadas de la base de datos
        $reservacion = model('ReservacionModel');
        $usuarios = model('Usuarios');
        $atraccion_animal = model('AtraccionAnimal');
        $data['usuarios'] = $usuarios->findAll();
        $data['atraccionesAnimal'] = $atraccion_animal->findAll();
        $data['reservaciones'] = $reservacion->findAll();

        return
            view('common/menu') .
            view('administrarReservaciones/reservacionesTabla', $data);
    }

// Método para visualizar las especificaciones de la reservación, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
    public function especificacionesReservacion($id)
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $reservacion = model('ReservacionModel');
        $data['reservacion'] = $reservacion->find($id);
        return
            view('common/menu') .
            view('administrarReservaciones/reservacionEspecificaciones', $data);
    }

// Método que valida los campos del formulario para agregar un registro en la tabla
// "Reservacion", en caso que las reglas de validación sean aceptadas, se invoca al método insertarReservacion()
    public function agregarReservacion()
    {
        $atraccionAn = model('AtraccionAnimal');
        $usuario = model('Usuarios');
        $data['atraccionesAn'] = $atraccionAn->findAll();
        $data['usuarios'] = $usuario->findAll();

        $validation = \Config\Services::validation();

        $rules = [
            'atraccion_animal' => 'required',
            'usuario' => 'required',
            'fechaReservada' => 'required',
            'horaInicio' => 'required',
            'horaFin' => 'required',
            'estatus' => 'required',
            'costoTotal' => 'required'
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarReservaciones/reservacionesTabla', ['validation' => $validation], $data);
        } else {
            if ($this->insertarReservacion()) {
                return redirect('Administrador/reservacionesTabla');
            }
        }

    }

// Método que hace la propia inserción de la reservación en la base de datos
// Únicamente se invoca cuando las reglas de validación han sido aceptadas en el
// método agregarReservacion(), no es invocado de manera directa en los formularios
    public function insertarReservacion()
    {
        $reservacion = model('ReservacionModel');
        $data = [
            "atraccion_animal" => $_POST["atraccion_animal"],
            "usuario" => $_POST['usuario'],
            "fechaReservada" => $_POST["fechaReservada"],
            "horaInicio" => $_POST["horaInicio"],
            "horaFin" => $_POST['horaFin'],
            "estatus" => $_POST["estatus"],
            "costoTotal" => $_POST["costoTotal"],
            "comentariosAdicionales" => $_POST["comentariosAdicionales"]
        ];
        $reservacion->insert($data, false);
        return true;
    }
// Función que elimina de la base de datos el registro coincidente con el ID que recibe como parámetro
    public function eliminarReservacion($id)
    {
        $reservacion = model('ReservacionModel');
        $reservacion->delete($id);
        return redirect('Administrador/reservacionesTabla');
    }

// Método que ayuda a validar los datos insertados en el formulario para editar un registro en específico
// Dicho registro es específicado mediante el ID que la función recibe como parámetro
// En caso de que las reglas de validación sean aceptadas, se invoca al método updateReservacion()
    public function editarReservacion($id)
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $reservacion = model('ReservacionModel');
        $atraccionAn = model('AtraccionAnimal');
        $usuario = model('Usuarios');
        $data['reservacion'] = $reservacion->find($id);
        $data['atraccionesAn'] = $atraccionAn->findAll();
        $data['usuarios'] = $usuario->findAll();

        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarReservaciones/editarReservacion', $data);
        }

        $rules = [
            'atraccion_animal' => 'required',
            'usuario' => 'required',
            'fechaReservada' => 'required',
            'horaInicio' => 'required',
            'horaFin' => 'required',
            'estatus' => 'required',
            'costoTotal' => 'required'
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarReservaciones/editarReservacion', ['validation' => $validation], $data);
        } else {
            if ($this->updateReservacion()) {
                return redirect('Administrador/reservacionesTabla');
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
            "atraccion_animal" => $_POST["atraccion_animal"],
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


    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------
// Funciones para "Usuarios"

// Método que muestra la tabla de usuarios en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
    public function usuariosTabla()
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $usuarios = model('Usuarios');
        $data['usuarios'] = $usuarios->findAll();
        return
            view('common/menu') .
            view('administrarUsuarios/usuariosTabla', $data);
    }

// Método para visualizar las especificaciones del usuario, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
    public function especificacionesUsuario($id)
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $usuario = model('Usuarios');
        $data['usuario'] = $usuario->find($id);
        return
            view('common/menu') .
            view('administrarUsuarios/usuarioEspecificaciones', $data);
    }

// Método que valida los campos del formulario para agregar un registro en la tabla
// "Usuario", en caso que las reglas de validación sean aceptadas, se invoca al método insertarUsuario()
    public function agregarUsuario()
    {

        $validation = \Config\Services::validation();

        $rules = [
            'nombre' => 'required',
            'apellido_Paterno' => 'required',
            'apellido_Materno' => 'required',
            'nombreUsuario' => 'required',
            'contrasenia' => 'required',
            'perfilUsuario' => 'required',
            'correoElectronico' => 'required'
        ];

        $usuarios = model('Usuarios');
        $data['usuarios'] = $usuarios->findAll();

        if (!$this->validate($rules)) {
            return
                view('common/header') .
                view('common/menu') .
                view('administrarUsuarios/usuariosTabla', ['validation' => $validation],$data);
        } else {
            if ($this->insertarUsuario()) {
                return redirect('Administrador/usuariosTabla');
            }
        }

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
            "nombreUsuario" => $_POST["nombreUsuario"],
            "contrasenia" => $_POST['contrasenia'],
            "perfilUsuario" => $_POST["perfilUsuario"],
            "correoElectronico" => $_POST["correoElectronico"],
            "fechaNacimiento" => $_POST["fechaNacimiento"],
            "comentarioPreferencias" => $_POST["comentarioPreferencias"]
        ];
        $usuario->insert($data, false);
        return true;
    }

// Función que elimina de la base de datos el registro coincidente con el ID que recibe como parámetro
    public function eliminarUsuario($id)
    {
        $usuario = model('Usuarios');
        $usuario->delete($id);
        return redirect('Administrador/usuariosTabla');
    }

// Método que ayuda a validar los datos insertados en el formulario para editar un registro en específico
// Dicho registro es específicado mediante el ID que la función recibe como parámetro
// En caso de que las reglas de validación sean aceptadas, se invoca al método updateUsuario()
    public function editarUsuario($id)
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $usuario = model('Usuarios');
        $data['usuario'] = $usuario->find($id);

        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarUsuarios/editarUsuario', $data);
        }

        $rules = [
            'nombre' => 'required',
            'apellido_Paterno' => 'required',
            'apellido_Materno' => 'required',
            'nombreUsuario' => 'required',
            'contrasenia' => 'required',
            'perfilUsuario' => 'required',
            'correoElectronico' => 'required'
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarUsuarios/editarUsuario', ['validation' => $validation], $data);
        } else {
            if ($this->updateUsuario()) {
                return redirect('Administrador/usuariosTabla');
            }
        }
    }

// Método que hace la actualización del registro en la base de datos, únicamente se invoca
// cuando las reglas de validación en el método editarUsuario() han sido aceptadas, no se invoca de manera directa
// en los formularios
    public function updateUsuario()
    {
        $usuario = model('Usuarios');
        $data = [
            "nombre" => $_POST["nombre"],
            "apellido_Paterno" => $_POST['apellido_Paterno'],
            "apellido_Materno" => $_POST["apellido_Materno"],
            "nombreUsuario" => $_POST["nombreUsuario"],
            "contrasenia" => $_POST['contrasenia'],
            "perfilUsuario" => $_POST["perfilUsuario"],
            "correoElectronico" => $_POST["correoElectronico"],
            "fechaNacimiento" => $_POST["fechaNacimiento"],
            "comentarioPreferencias" => $_POST["comentarioPreferencias"]
        ];
        $usuario->update($_POST['numeroControl'], $data);
        return true;
    }

    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------
// Funciones para "Empleados"

// Método que muestra la tabla de empleados en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
    public function empleadosTabla()
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $empleados = model('EmpleadoModel');
        $data['empleados'] = $empleados->findAll();
        return
            view('common/menu') .
            view('empleados/mostrar', $data);
    }

// Método para visualizar las especificaciones del empleado, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
    public function especificacionesEmpleado($id)
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $empleado = model('EmpleadoModel');
        $data['empleado'] = $empleado->find($id);
        return
            view('common/menu') .
            view('empleados/especificacionesEmpleado', $data);
    }

// Método que valida los campos del formulario para agregar un registro en la tabla
// "Empleado", en caso que las reglas de validación sean aceptadas, se invoca al método insertarEmpleado()
    public function agregarEmpleado()
    {

        $validation = \Config\Services::validation();

        $rules = [
            'nombre' => 'required',
            'apellido_Paterno' => 'required',
            'apellido_Materno' => 'required',
            'correoElectronico' => 'required',
            'telefono' => 'required',
            'fechaNacimiento' => 'required'
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header') .
                view('common/menu') .
                view('empleados/mostrar', ['validation' => $validation]);
        } else {
            if ($this->insertarEmpleado()) {
                return redirect('Administrador/empleadosTabla');
            }
        }

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
            "imagenEmpleado" => $_POST["imagenEmpleado"]
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
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
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
            'nombre' => 'required',
            'apellido_Paterno' => 'required',
            'apellido_Materno' => 'required',
            'correoElectronico' => 'required',
            'telefono' => 'required',
            'fechaNacimiento' => 'required'
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('empleados/editarEmpleado', ['validation' => $validation], $data);
        } else {
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
            "imagenEmpleado" => $_POST["imagenEmpleado"]
        ];
        $empleado->update($_POST['idEmpleado'], $data);
        return true;
    }


    // ----------------------------------------------------------------------------------------------------------------------------------------------------------------
// Funciones para "Atracciones"

// Método que muestra la tabla de atracciones en caso que la sesión exista, 
// no se puede acceder por URL si la sesión no existe
    public function atraccionesTabla()
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $animales = model('AnimalModel');
        $areas = model('AreasModel');
        $atracciones = model('AtraccionesModel');
        $data['animales'] = $animales->findAll();
        $data['areas'] = $areas->findAll();
        $data['atracciones'] = $atracciones->findAll();
        return
            view('common/menu') .
            view('administrarAtracciones/atraccionesTabla', $data);
    }

// Método para visualizar las especificaciones de la atracción, verifica la existencia de la sesión
// No es posible acceder mediante URL si la sesión es inexistente
    public function especificacionesAtraccion($id)
    {
        $session = session();
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $atraccion = model('AtraccionesModel');
        $data['atraccion'] = $atraccion->find($id);
        return
            view('common/menu') .
            view('administrarAtracciones/especificacionesAtraccion', $data);
    }

// Método que valida los campos del formulario para agregar un registro en la tabla
// "Atraccion", en caso que las reglas de validación sean aceptadas, se invoca al método insertarAtraccion()
    public function agregarAtraccion()
    {
        $animales = model('AnimalModel');
        $areas = model('AreasModel');
        $atracciones = model('AtraccionesModel');
        $data['animales'] = $animales->findAll();
        $data['areas'] = $areas->findAll();
        $data['atracciones'] = $atracciones->findAll();

        $validation = \Config\Services::validation();

        $rules = [
            'animal' => 'required',
            'idArea' => 'required',
            'nombre' => 'required',
            'tipo' => 'required',
            'descripcion' => 'required',
            'horarios' => 'required',
            'costo' => 'required'
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAtracciones/atraccionesTabla', ['validation' => $validation], $data);
        } else {
            if ($this->insertarAtraccion()) {
                return redirect('Administrador/atraccionesTabla');
            }
        }
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
        if($session->get('logged_in')!=TRUE || $session->get('Perfil')!='ADMINISTRADOR'){
            $session->destroy();
            return redirect('/');
        }

        $animales = model('AnimalModel');
        $areas = model('AreasModel');
        $data['animales'] = $animales->findAll();
        $data['areas'] = $areas->findAll();
        $atraccion = model('AtraccionesModel');
        $data['atraccion'] = $atraccion->find($id);

        $validation = \Config\Services::validation();

        if ((strtolower($this->request->getMethod()) === 'get')) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAtracciones/editarAtraccion', $data);
        }

        $rules = [
            'animal' => 'required',
            'idArea' => 'required',
            'nombre' => 'required',
            'tipo' => 'required',
            'descripcion' => 'required',
            'horarios' => 'required',
            'costo' => 'required'
        ];

        if (!$this->validate($rules)) {
            return
                view('common/header', $data) .
                view('common/menu') .
                view('administrarAtracciones/editarAtraccion', ['validation' => $validation], $data);
        } else {
            if ($this->updateAtraccion()) {
                return redirect('Administrador/atraccionesTabla');
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

}