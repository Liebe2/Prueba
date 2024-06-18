<?php

class Profesion{
    private $id;
    private $nombre;

    public function __construct(int $id,string $nombre){

        $this->id = $id;
        $this->nombre = $nombre;
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

}

?>