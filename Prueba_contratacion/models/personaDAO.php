<?php

require_once __DIR__ . '/../core/mainModel.php';  
     require_once __DIR__ . '/../entities/persona.php';

    class PersonaDAO extends MainModel {
        private $pdo;

        public function __construct(){
            try{
                $this->pdo = MainModel:: connect();

        }catch(PDOException $e){
           die($e->getMessage());
        }
     }

     public function save(Persona $persona){
        $result = false;
        try{
            $sql = "INSERT INTO personas(nombre,apellido,dui,profesion_id) values(?,?,?,?)"; 
            $this->pdo->prepare($sql)->execute(
                array(
                    $persona->getNombre(),
                    $persona->getApellido(),
                    $persona->getDui(),
                    $persona->getProfesion()->getId()
                )
            );
            $result = true;
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
        return $result;
     }

     public function update(Persona $persona){
        $result = false;
        try{
             // Recuperar los valores actuales del registro
        $sql = "SELECT * FROM personas WHERE id=?";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$persona->getId()]);
        $currentValues = $stmt->fetch(PDO::FETCH_ASSOC);


        if ($currentValues) {

            $sql = "UPDATE personas SET nombre=?,apellido=?,dui=?,profesion_id=? WHERE id=?"; 
           $stmt= $this->pdo->prepare($sql);
            $stmt->execute(
                array(
                    $persona->getNombre(),
                    $persona->getApellido(),
                    $persona->getDui(),
                    $persona->getProfesion()->getId(),
                    $persona->getId()
                )
            );
            // Comparar y guardar cambios en la tabla de auditoría
             $changes = [];
             if ($currentValues['nombre'] != $persona->getNombre()) {
                 $changes[] = ['campo' => 'nombre', 'valor_anterior' => $currentValues['nombre'], 'nuevo_valor' => $persona->getNombre()];
             }
             if ($currentValues['apellido'] != $persona->getApellido()) {
                 $changes[] = ['campo' => 'apellido', 'valor_anterior' => $currentValues['apellido'], 'nuevo_valor' => $persona->getApellido()];
             }
             if ($currentValues['dui'] != $persona->getDui()) {
                 $changes[] = ['campo' => 'dui', 'valor_anterior' => $currentValues['dui'], 'nuevo_valor' => $persona->getDui()];
             }
             if ($currentValues['profesion_id'] != $persona->getProfesion()->getId()) {
                 $changes[] = ['campo' => 'profesion_id', 'valor_anterior' => $currentValues['profesion_id'], 'nuevo_valor' => $persona->getProfesion()->getId()];
             }

             // Insertar cambios en la tabla de auditoría
            if (!empty($changes)) {
                $auditSql = "INSERT INTO registro_cambios(persona_id, campo_modificado, valor_anterior, nuevo_valor, fecha_modificacion) VALUES (?, ?, ?, ?, ?)";
                $auditStmt = $this->pdo->prepare($auditSql);
                $fechaModificacion = date('Y-m-d H:i:s');
                foreach ($changes as $change) {
                    $auditStmt->execute([$persona->getId(), $change['campo'], $change['valor_anterior'], $change['nuevo_valor'], $fechaModificacion]);
                }
            }

        }
            $result = true;
        }
        catch(PDOException $e){
            die($e->getMessage());
        }
        return $result;
     }

     public function delete(Persona $persona){
        $result = false;
        try {
            $sql = "UPDATE personas SET estado='I' WHERE id=?"; 
            $stmt= $this->pdo->prepare($sql);
            $stmt->execute( [$persona->getId()]);
            $result = true;
        } catch (PDOException $e) {
            die($e->getMessage());
        }
    
    }
    public function getAll(){
        try{
            $stmt = $this->pdo->prepare("SELECT a.*,m.nombre as profesion FROM personas as a INNER JOIN profesiones as m ON a.profesion_id=m.id WHERE a.estado = 'A'  ORDER BY a.id DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        catch (PDOException $e){
            die($e->getMessage());
        }
    }

    public function getById(Persona $persona){
        try {
            $stmt = $this->pdo->prepare("SELECT a.*, m.nombre as profesion FROM personas as a INNER JOIN profesiones as m ON a.profesion_id = m.id WHERE a.id = ?");
            $stmt->execute([$persona->getId()]);
            return $stmt->fetchAll(PDO::FETCH_OBJ);
        } catch (PDOException $e) {
            throw new Exception("Error al obtener la persona: " . $e->getMessage());
        }
    }
    
    public function exist(Persona $persona){

       $result = false;

        try{
            $sql = "SELECT COUNT(*) FROM personas WHERE dui=?";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute( [$persona->getDui()]);

            if($stmt->fetchColumn()>0){
                $result = true;
            }
            

        }
        catch(PDOException $e){
            die($e->getMessage());
        }
        return $result;
    }


    }

?>