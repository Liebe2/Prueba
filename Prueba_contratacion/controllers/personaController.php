<?php

require_once __DIR__ . '/../models/personaDAO.php';  

require_once __DIR__ . '/../entities/persona.php';
require_once __DIR__ . '/../entities/profesion.php';

class PersonaController {

   
    private $personaDAO;
    private $respuesta;

    public function __construct() {
        $this->personaDAO = new PersonaDAO();
     
    }

    
    public function ObtenerPersonasController() {
        try {
            $resultados = $this->personaDAO->getAll();
            $this->respuesta = (object) [
                "state" => true,
                "personas" => $resultados
            ];
        } catch (Exception $ex) {
            $this->respuesta = (object) [
                "state" => false,
                "mensaje" => $ex->getMessage()
            ];
        }

        return $this->respuesta;
    }
    public function ObtenerPersonaByIdController($id) {
        try {
            $persona = new Persona();
            $persona->setId($id);
            $resultados = $this->personaDAO->getById($persona);
            $respuesta = (object) [
                "state" => true,
                "personas" => $resultados
            ];
        } catch (Exception $ex) {
            $respuesta = (object) [
                "state" => false,
                "mensaje" => $ex->getMessage()
            ];
        }
    
        echo json_encode($respuesta);
    

        return $respuesta;
    }
    
    public function NuevaPersonaController($datos) {
        try {
            $persona = new Persona();
            $persona->setNombre($datos['nombre']);
            $persona->setApellido($datos['apellido']);
            $persona->setDui($datos['dui']);
            $profesion = new Profesion($datos['profesion']['id'], $datos['profesion']['nombre']);
            $persona->setProfesion($profesion);
            if ($this->personaDAO->exist($persona)) {
                throw new Exception("Ya existe una persona registrada con este DUI");
            } else {
                $resultados = $this->personaDAO->save($persona);
                $this->respuesta = (object) [
                    "state" => true,
                    "resultado" => $resultados
                ];
            }
        } catch (Exception $ex) {
            $this->respuesta = (object) [
                "state" => false,
                "mensaje" => $ex->getMessage()
            ];
        }

        return $this->respuesta;
    }

    public function ActualizarPersonaController($datos) {
        try {
            $persona = new Persona();
            $persona->setId($datos['id']);
            $persona->setNombre($datos['nombre']);
            $persona->setApellido($datos['apellido']);
            $persona->setDui($datos['dui']);
            $profesion = new Profesion($datos['profesion']['id'], $datos['profesion']['nombre']);
            $persona->setProfesion($profesion);

            $resultados = $this->personaDAO->update($persona);
            $this->respuesta = (object) [
                "state" => true,
                "resultado" => $resultados
            ];
        } catch (Exception $ex) {
            $this->respuesta = (object) [
                "state" => false,
                "mensaje" => $ex->getMessage()
            ];
        }

        return $this->respuesta;
    }

    public function EliminarPersonaController($id) {
        try {
            $persona = new Persona();
            $persona->setId($id);

            $resultados = $this->personaDAO->delete($persona);
            $this->respuesta = (object) [
                "state" => true,
                "resultado" => $resultados
            ];
        } catch (Exception $ex) {
            $this->respuesta = (object) [
                "state" => false,
                "mensaje" => $ex->getMessage()
            ];
        }

        return $this->respuesta;
    }
}
?>