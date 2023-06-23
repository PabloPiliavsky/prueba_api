<?php

require_once '/APP/model/jugadores.model.php';
require_once '/APP/view/jugadores.api.view.php';

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





}