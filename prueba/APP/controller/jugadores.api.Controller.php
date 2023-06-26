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
    function ordenarJugadores($criterio,$orden){
        if(isset($criterio) && isset($orden)){
            $jugadores= $this -> model -> ordenarJugadores($criterio,$orden);
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
    





}