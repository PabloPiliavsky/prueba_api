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
        $this -> view ->response($jugadores, 200);
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
                $this -> view -> response("el jugador que se quiere borrar no existe o no fue encontrado",404);
            }

        }
        else{
            return $this->view->response("El ID no fue indicado", 404); 
        }

    }





}