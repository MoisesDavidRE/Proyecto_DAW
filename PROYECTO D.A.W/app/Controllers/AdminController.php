<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AdminController extends BaseController
{

    // Vista general
    public function vistaGeneral()
    {
        return
            view('common/menu') .
            view('Administrador/vistaGeneral');
    }

    // Funciones para "Animal"
    public function animalTabla()
    {
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

    public function especificacionesAnimal($idAnimal)
    {
        $animalModel = model('AnimalModel');
        $data['animal'] = $animalModel->find($idAnimal);
        return
            view('common/menu') .
            view('administrarAnimales/especificacionesAnimal', $data);
    }

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

    public function eliminarAnimal($id)
    {
        $animalModel = model('AnimalModel');
        $animalModel->delete($id);
        return redirect('Administrador/animalTabla');
    }

    public function editarAnimal($idAnimal)
    {
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

    // Funciones para "Área"
    public function areasTabla()
    {
        $areasModel = model('AreasModel');
        $empleados = model('EmpleadoModel');
        $data ['empleados'] = $empleados->findAll();
        $data['areas'] = $areasModel->findAll();

        return
            view('common/menu') .
            view('administrarAreas/areasTabla', $data);
    }

    public function especificacionesArea($id)
    {
        $area = model('AreasModel');
        $data['area'] = $area->find($id);
        return
            view('common/menu') .
            view('administrarAreas/especificacionesArea', $data);
    }


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

    public function eliminarArea($id)
    {
        $area = model('AreasModel');
        $area->delete($id);
        return redirect('Administrador/areasTabla');
    }

    public function editarArea($id)
    {
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
    public function reservacionesTabla()
    {
        $reservacion = model('ReservacionModel');
        $usuarios = model('Usuarios');
        $atraccion_animal = model('AtraccionAnimal');
        $data ['usuarios'] = $usuarios->findAll();
        $data['atraccionesAnimal'] = $atraccion_animal->findAll();
        $data['reservaciones'] = $reservacion->findAll();

        return
            view('common/menu') .
            view('administrarReservaciones/reservacionesTabla', $data);
    }

    public function especificacionesReservacion($id)
    {
        $reservacion = model('ReservacionModel');
        $data['reservacion'] = $reservacion->find($id);
        return
            view('common/menu') .
            view('administrarReservaciones/reservacionEspecificaciones', $data);
    }

    public function agregarReservacion()
    {
        $atraccionAn = model ('AtraccionAnimal');
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

    public function eliminarReservacion($id)
    {
        $reservacion = model('ReservacionModel');
        $reservacion->delete($id);
        return redirect('Administrador/reservacionesTabla');
    }

    public function editarReservacion($id)
    {
        $reservacion = model('ReservacionModel');
        $atraccionAn = model ('AtraccionAnimal');
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
public function usuariosTabla()
{
    $usuarios = model('Usuarios');
    $data ['usuarios'] = $usuarios->findAll();
    return
        view('common/menu') .
        view('administrarUsuarios/usuariosTabla', $data);
}

public function especificacionesUsuario($id)
{
    $usuario = model('Usuarios');
    $data['usuario'] = $usuario->find($id);
    return
        view('common/menu') .
        view('administrarUsuarios/usuarioEspecificaciones', $data);
}

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
        'correoElectronico' => 'required',
        'fechaNacimiento' => 'required'
    ];

    if (!$this->validate($rules)) {
        return
            view('common/header') .
            view('common/menu') .
            view('administrarUsuarios/usuariosTabla', ['validation' => $validation]);
    } else {
        if ($this->insertarUsuario()) {
            return redirect('Administrador/usuariosTabla');
        }
    }

}


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

public function eliminarUsuario($id)
{
    $usuario = model('Usuarios');
    $usuario->delete($id);
    return redirect('Administrador/usuariosTabla');
}

public function editarUsuario($id)
{
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
        'correoElectronico' => 'required',
        'fechaNacimiento' => 'required'
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
public function empleadosTabla()
{
    $empleados = model('EmpleadoModel');
    $data ['empleados'] = $empleados->findAll();
    return
        view('common/menu') .
        view('empleados/mostrar', $data);
}

public function especificacionesEmpleado($id)
{
    $empleado = model('EmpleadoModel');
    $data['empleado'] = $empleado->find($id);
    return
        view('common/menu') .
        view('empleados/especificacionesEmpleado', $data);
}

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

public function eliminarEmpleado($id)
{
    $empleado = model('EmpleadoModel');
    $empleado->delete($id);
    return redirect('Administrador/empleadosTabla');
}

public function editarEmpleado($id)
{
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
public function atraccionesTabla()
{
    $atracciones = model('AtraccionesModel');
    $data ['atracciones'] = $atracciones->findAll();
    return
        view('common/menu') .
        view('administrarAtracciones/atraccionesTabla', $data);
}

public function especificacionesAtraccion($id)
{
    $atraccion = model('AtraccionesModel');
    $data['atraccion'] = $atraccion->find($id);
    return
        view('common/menu') .
        view('administrarAtracciones/especificacionesAtraccion', $data);
}

public function agregarAtraccion()
{

    $validation = \Config\Services::validation();

    $rules = [
        'animal' => 'required',
        'idArea' => 'required',
        'nombre' => 'required',
        'tipo' => 'required',
        'descripcion' => 'required',
        'horarios' => 'required',
        'costo'=>'required'
    ];
                                
    if (!$this->validate($rules)) {
        return
            view('common/header') .
            view('common/menu') .
            view('administrarAtracciones/atraccionesTabla', ['validation' => $validation]);
    } else {
        if ($this->insertarAtraccion()) {
            return redirect('Administrador/atraccionesTabla');
        }
    }

}

public function insertarAtraccion()
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

public function eliminarAtraccion($id)
{
    $empleado = model('EmpleadoModel');
    $empleado->delete($id);
    return redirect('Administrador/empleadosTabla');
}

public function editarAtraccion($id)
{
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

public function updateAtraccion()
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

    public function reservacionEspecificaciones()
    {
        return
            view('common/menu') .
            view('administrarReservaciones/reservacionEspecificaciones');
    }
}