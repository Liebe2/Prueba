<?php
    require_once __DIR__ . '/../core/mainModel.php';
    require_once __DIR__ . '/../entities/profesion.php';
    class ProfesionDAO extends MainModel {

        private $pdo;

        public function __construct(){
            try{
                $this->pdo = MainModel:: connect();

        }catch(PDOException $e){
           die($e->getMessage());
        }
    }
//metodo para insertar una profesion.
    public function save($data){
       $result = false;
        try {
            $sql = $this->pdo->prepare("INSERT INTO profesiones(nombre) VALUES(:nombre)");
            $sql->bindParam(':nombre',$data['nombre']);
            $sql->execute();
            $result = true;

        } catch (PDOException $e) {
            die($e->getMessage());
        }
        return $result;

    }

    //metodo para actualizar una profesion

    public function  update($data){
        $result = false;
         try {
            $sql = "UPDATE profesiones set nombre = ? WHERE id = ?";
            $this->pdo->prepare($sql)->execute(
                array($data['nombre'],$data['id'])
            );
             $result = true;
 
         } catch (PDOException $e) {
             die($e->getMessage());
         }
         return $result;
 
     }
      // metodo para eliminar una profesion
 public function delete($data){
    $result = false;
    try{
        $sql = $this->pdo->prepare("DELETE FROM  profesiones WHERE id= :id");
        $sql->bindParam(":id", $data['id']);
        $sql->execute();
        $result = true;
    }catch(PDOException $e){
        die($e->getMessage());
    }
    return $result;
}

 // metodo para obtener todos los registros de la tabla profesiones
 public function getAll(){
    try{
        $stmt = $this->pdo->prepare("SELECT * FROM profesiones ORDER BY id DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }catch(PDOException $e){
        die($e->getMessage());
    }
}
 //metodo para verificar si ya esta registrada una profesion
 public function exist($data){
    $result = false;
    try{
        $sql = "SELECT COUNT(*) FROM profesiones WHERE nombre = :nombre ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute(array(":nombre" => $data));
        if ($stmt->fetchColumn()> 0){
            $result = true;
        }
    }catch(PDOException $e){
        die($e->getMessage());
    }
    return $result;

}



}
?>