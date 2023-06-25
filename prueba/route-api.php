<?php

require_once './libs/Router.php';
require_once './APP/controller/jugadores.api.controller.php';

$router = new Router();
 
$router -> addRoute('jugadores','GET','jugadoresApiController','obtenerJugadores');
$router -> addRoute('jugadores/:ID','GET','jugadoresApiController','obtenerJugadorById');

$router -> route($_GET["resource"], $_SERVER['REQUEST_METHOD']);