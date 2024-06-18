<?php

class Persona{
    private $id;
    private $nombre;
    private $apellido;

    private $dui;
   private $estado;
    private $profesion;



    public function __construct(){

    
    }
    //metodos para encapsular los atributos
    public function getId(){
        return $this->id;
    }
    public function setId(int $id){
        $this->id = $id;
    }

    public function getNombre(){
        return $this->nombre;
    }
    public function setNombre(string $nombre){
        $this->nombre = $nombre;
    }
    public function getApellido(){
        return $this->apellido;
    }
    public function setApellido(string $apellido){
        $this->apellido = $apellido;
    }
    public function getDui(){
        return $this->dui;
    }
    public function setDui(string $dui){
        $this->dui= $dui;
    }
    public function getEstado(){
       return $this->estado;
   }
  public function setEstado(string $estado){
       $this->estado= 'A';
   }
    public function getProfesion(){
        return $this->profesion;
    }
    public function setProfesion(Profesion $profesion){
        $this->profesion= $profesion;
    }

}

?>