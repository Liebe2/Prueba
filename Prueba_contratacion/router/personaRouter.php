<?php

require_once __DIR__ . '/../controllers/personaController.php';
require_once __DIR__ . '/../controllers/profesionController.php';

$accion = $_POST['accion'] ?? $_GET['accion'] ?? '';

switch ($accion) {
    case 'obtenerprofesion':
        obtenerProfesiones();
        break;
    case 'nuevo':
        nuevaPersona();
        break;
    case 'obtener':
         if (isset($_GET['id'])) {
        obtenerPersonaById();
    } else {
        obtenerPersonas();
       
     }
        break;
    case 'actualizar':
        actualizarPersona();
        break;
    case 'eliminar':
        eliminarPersona();
        break;
       
    default:
        http_response_code(400);
        echo json_encode(array("message" => "Acción no válida"));
        break;
}


function nuevaPersona() {
    $personaController = new PersonaController();

    if (isset($_POST['nombre'], $_POST['apellido'], $_POST['dui'], $_POST['profesion']['id'], $_POST['profesion']['nombre'])) {
        $datos = array(
            "nombre" => $_POST['nombre'],
            "apellido" => $_POST['apellido'],
            "dui" => $_POST['dui'],
            "profesion" => array(
                "id" => $_POST['profesion']['id'],
                "nombre" => $_POST['profesion']['nombre']
            )
        );
         try{
        $respuesta = $personaController->NuevaPersonaController($datos);

        if ($respuesta->state == true) {
            http_response_code(201);
            echo json_encode(array("message" => "Persona registrada con éxito"));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => $respuesta->mensaje));
        }
    } catch (Exception $ex) {
        http_response_code(400);
        echo json_encode(array("message" => $ex->getMessage()));
    }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Datos incompletos"));
    }
}

 
function obtenerPersonaById(){

    $personaController = new PersonaController();

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
            return json_encode ($personaController->ObtenerPersonaByIdController($id));
           
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "ID de persona no proporcionado"));
        }
    } else {
        http_response_code(405); // Método no permitido
        echo json_encode(array("message" => "Método no permitido"));
    }
}

function obtenerPersonas() {
    $personaController = new PersonaController();
    echo json_encode($personaController->ObtenerPersonasController());
}
function obtenerProfesiones() {
    $profesionController = new ProfesionController();
    echo json_encode($profesionController->ObtenerProfesionesController());
}
function actualizarPersona() {
    $personaController = new PersonaController();

 
  

    if (isset($_POST['id'], $_POST['nombre'],$_POST['apellido'], $_POST['dui'], $_POST['profesion']['id'], $_POST['profesion']['nombre'])) {
        $datos = array(
            "id" => $_POST['id'],
            "nombre" => $_POST['nombre'],
            "apellido" =>$_POST['apellido'],
            "dui" => $_POST['dui'],
            "profesion" => array(
                "id" => $_POST['profesion']['id'],
                "nombre" =>$_POST['profesion']['nombre']
            )
        );

        $respuesta = $personaController->ActualizarPersonaController($datos);

        if ($respuesta->state == true) {
            http_response_code(200);
            echo json_encode(array("message" => "Persona actualizada con éxito"));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => $respuesta->mensaje));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Datos incompletos"));
    }
}

function eliminarPersona() {
    $personaController = new PersonaController();

    if (isset($_GET['id'])) {
        $respuesta = $personaController->EliminarPersonaController($_GET['id']);

        if ($respuesta->state == true) {
            http_response_code(200);
            echo json_encode(array("message" => "Persona eliminada con éxito"));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => $respuesta->mensaje));
        }
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "No se proporcionó un ID válido"));
    }
}
?>