<?php

class RegistroCambio{
    private $id;
    private $persona;
    private $campoModificado;

    private $valorAnterior;
    private $nuevoValor;
    private $fechaModificacion;



    public function __construct(){

    
    }
    //metodos para encapsular los atributos
    public function getId(){
        return $this->id;
    }
    public function setId(int $id){
        $this->id = $id;
    }

    public function getPersona(){
        return $this->persona;
    }
    public function setPersona(Persona $persona){
        $this->persona = $persona;
    }
    public function getCampoModificado(){
        return $this->campoModificado;
    }
    public function setCampoModificado(string $campoModificado){
        $this->campoModificado = $campoModificado;
    }
    public function getValorAnterior(){
        return $this->valorAnterior;
    }
    public function setValorAnterior(string $valorAnterior){
        $this->valorAnterior= $valorAnterior;
    }
    public function getNuevoValor(){
        return $this->nuevoValor;
    }
    public function setNuevoValor(string $nuevoValor){
        $this->nuevoValor= $nuevoValor;
    }
    public function getFechaModificacion(){
        return $this->fechaModificacion; 
    }
    public function setFechaModificacion(string $fechaModificacion){
        $this->fechaModificacion= $fechaModificacion;
    }

}

?>