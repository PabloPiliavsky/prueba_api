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

        function eliminarJugadorById($id){
            $sentencia = $this -> db -> prepare ("DELETE FROM jugadores WHERE (id) = :id");
            $sentencia -> execute([':id'=>$id]);
        }

        public function agregarjugador($jugador){
        $sentencia= $this->db->prepare("INSERT INTO jugadores (nombre, apellido, descripcion, posicion, foto, id_pais) 
                                     VALUES (:nombre, :apellido, :descripcion, :posicion, :foto, :id_pais)");
        $sentencia->execute([':nombre' => $jugador->nombre,
                        ':apellido'=> $jugador->apellido, 
                         ':descripcion' => $jugador->descripcion, 
                         ':posicion' => $jugador->posicion,
                         ':foto' => $jugador->foto,
                         ':id_pais'=> $jugador ->id_pais]);
        $id = $this->db->lastInsertId();
        return $id;
        }

        function ordenarJugadores($columna, $orden){ //criterio serviria para tomar el criterio en si y si es asc o desc
            $sentencia = $this -> db -> prepare("SELECT * FROM jugadores ORDER BY $columna $orden");
            $sentencia -> execute([/*':criterio'=>$criterio*/]);
            $jugadores = $sentencia -> fetchAll(PDO::FETCH_OBJ);
            return $jugadores;
        } 

        function actualizarJugador($jugador, $id){
            $sentencia = $this -> db -> prepare("UPDATE jugadores SET nombre=?, apellido=?, descripcion=?, posicion=?, foto=?, id_pais=? WHERE id=?");
            $sentencia -> execute([$jugador->nombre,$jugador->apellido,$jugador->descripcion,$jugador->posicion,$jugador->foto,$jugador->id_pais,$id]); 
        }

        function paginar($desde, $filas){
            $sentencia = $this -> db -> prepare("SELECT * FROM `jugadores` ORDER BY id LIMIT $desde, $filas");//puede parametrizarse el order by y el cantidad de filas por pagina
            $sentencia -> execute();
            $jugadoresPaginados = $sentencia -> fetchAll(PDO::FETCH_OBJ);
            return $jugadoresPaginados;
        }


        function filtrar($columna,$valor){
            $sentencia = $this -> db -> prepare("SELECT * FROM jugadores WHERE $columna='$valor'");
            $sentencia -> execute();
            $jugadoresFiltrados = $sentencia->fetchAll(PDO::FETCH_OBJ);
            return $jugadoresFiltrados;
        }


    }
?>