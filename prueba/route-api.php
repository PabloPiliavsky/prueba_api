<?php

require_once './libs/Router.php';
require_once './API/controller/jugadores.api.controller.php';

$router = new Router();
 
$router -> addRoute("jugadores","GET","jugadoresApiController","obtenerJugadores");

$router -> route($_GET["resorce"], $_SERVER['REQUEST_METHOD']);

