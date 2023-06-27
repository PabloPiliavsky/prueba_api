<?php

require_once './APP/model/jugadores.model.php';
require_once './APP/view/jugadores.api.view.php';

class jugadoresApiController{
    private $model;
    private $view;
    private $data;


    public function __construct(){
        $this -> model = new jugadoresModel();
        $this -> view = new jugadoresApiView();
        $this-> data = file_get_contents("php://input");
    }

    private function getData() {
        return json_decode($this->data);
    }

    function obtenerJugadores(){
        $jugadores= $this -> model -> obtenerJugadores();
        return $this -> view ->response($jugadores, 200); // creo que el return no es necesario porque aplica una funcion, por lo que en realidad no retorna nada
    }

    function obtenerJugadorById($params){
        if(isset($params[':ID'])){
            $id=$params[':ID'];
            $jugador = $this -> model -> obtenerJugadorById($id);
            if(!empty($jugador)){
                $this -> view -> response($jugador,200);
            }
            else{
                return $this->view->response("El jugador no existe", 404); 
            }
        }
        else{
            return $this->view->response("El ID no fue indicado", 404); 
        }

    }

    function eliminarJugador($params){
        if(isset($params[':ID'])){
            $id = $params[':ID'];
            $jugador = $this -> model -> obtenerJugadorById($id);
            if($jugador){//comprobar que existe el jugador
                $this -> model -> eliminarJugadorById($id);
                $this -> view -> response($jugador,200);
            }
            else{
                return $this -> view -> response("el jugador que se quiere borrar no existe o no fue encontrado",404);
            }

        }
        else{
            return $this->view->response("El ID no fue indicado", 404); 
        }

    }

    function agregarJugador(){
        $jugador= $this -> getData();
        if (empty($jugador->nombre) || empty($jugador->apellido) || empty($jugador->descripcion) || empty($jugador->posicion) || empty($jugador->foto) || empty($jugador->id_pais)){
            return $this -> view -> response("complete los datos",400);
        }
        else{
            $id = $this -> model -> agregarjugador($jugador);
            $dataJugador = $this -> model -> obtenerJugadorbyId($id);
            return $this -> view -> response($dataJugador,200);
        }
    }
    function ordenarJugadores(){
        if(isset($_GET['criterio'])||isset($_GET['orden'])){//hacer if con los posibles atributos y nombrarlos como string en una variable para evitar la inyeccion
            $jugadores= $this -> model -> ordenarJugadores($_GET['criterio'],$_GET['orden']);
            return $this -> view ->response($jugadores, 200);
        }
    }

    function actualizarJugador($params){
        if(isset($params)){
            $id=$params[':ID'];
            $jugador= $this -> model -> obtenerJugadorbyId($id);
            if($jugador){
                $jugadorData= $this -> getData();
                $this -> model -> actualizarJugador($jugadorData,$id);
                $this -> view -> response("jugador $id actualizado", 200);
            }
            else
                $this -> view -> response("jugador $id no encontrado", 404);
        }
        else
            $this -> view -> response("parametro no seteado",404); 
    }

    function paginar(){
        if(isset($_GET['pagina']) && isset($_GET['filas'])){//corroborar que no sea ni negativo ni un caracter no numerico y que la cantidad de filas sea mayor que 0
            $pagina=0;
            $pagina = $pagina + $_GET['filas']*($_GET['pagina']-1);//el 10 es porque todavia no use un param para poner la cantidad de filas
            $jugadoresPaginado = $this -> model -> paginar($pagina,$_GET['filas']);
            $this -> view -> response($jugadoresPaginado,200); 
        }

    }

    function filtrar(){ //aca deberiamos tomar 2 params para que tenga uno que indique la columna a elegir y otro que de el valor para tomar como filtro
        if(isset($_GET['columna']) && isset($_GET['filtro'])){
            $jugadoresFiltrados = $this -> model -> filtrar($_GET['columna'],$_GET['filtro']);
            $this -> view ->response($jugadoresFiltrados,200);
        }


    }
    





}