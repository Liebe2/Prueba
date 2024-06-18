<?php
require_once __DIR__ . '/../core/configDB.php';  

    class MainModel{
        //metodo para conectar la base de datos
        protected static function connect(){
            $pdo = new PDO(DBMS,USER,PASSWD);
            return $pdo;

        }

        //metodo para ejecutar una consulta basica
        protected function execQuery($query){
            $result = self::connect()->prepare($query);
            $result->execute();
            return $result;
        }
        
    }

?>