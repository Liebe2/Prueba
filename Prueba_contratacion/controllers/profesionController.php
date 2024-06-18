<?php

require_once __DIR__ . '/../models/profesionDAO.php';  
require_once __DIR__ . '/../entities/persona.php';
require_once __DIR__ . '/../entities/profesion.php';

class ProfesionController {

    private $profesionDAO;
    private $respuesta;

    public function __construct() {
        $this->profesionDAO = new ProfesionDAO();
    }

    public function ObtenerProfesionesController() {
        try {
            $resultados = $this->profesionDAO->getAll();
            $this->respuesta = (object) [
                "state" => true,
                "profesiones" => $resultados
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