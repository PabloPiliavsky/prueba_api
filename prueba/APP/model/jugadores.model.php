<?php
    Class jugadoresModel{
        private $db; 

        public function __construct(){
            $this->db = new PDO('mysql:host=localhost:4306;'.'dbname=db_mundial;charset=utf8', 'root', '');
        }

        /*--Obtiene todos los jugadores (listado de ítems)--*/
        function obtenerJugadores(){
            $sentencia = $this -> db -> prepare("SELECT * FROM jugadores");
            $sentencia -> execute();
            $jugadores = $sentencia -> fetchAll(PDO::FETCH_OBJ);
            return $jugadores;
        }

        function obtenerJugadorbyId($id){
            $sentencia = $this -> db -> prepare("SELECT * FROM jugadores WHERE (id)=:id");
            $sentencia -> execute([':id'=>$id]);
            $jugador = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $jugador;
        }


    }
?>