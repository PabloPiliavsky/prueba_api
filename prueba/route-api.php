<?php

require_once './libs/Router.php';
require_once './APP/controller/jugadores.api.controller.php';

$router = new Router();
$router -> addRoute('jugadores/ordenados','GET','jugadoresApiController','ordenarJugadores');
$router -> addRoute('jugadores/paginas','GET','jugadoresApiController','paginar');
$router -> addRoute('jugadores/filtrados','GET','jugadoresApiController','filtrar');
$router -> addRoute('jugadores','GET','jugadoresApiController','obtenerJugadores');
$router -> addRoute('jugadores/:ID','GET','jugadoresApiController','obtenerJugadorById');
$router -> addRoute('jugadores/:ID','DELETE','jugadoresApiController','eliminarJugador');
$router -> addRoute('jugadores','POST','jugadoresApiController','agregarJugador');
$router -> addRoute('jugadores/:ID','PUT','jugadoresApiController','actualizarJugador');
//$router -> addRoute('jugadores/paginas','GET','jugadoresApiController','paginar');
$router -> route($_GET["resource"], $_SERVER['REQUEST_METHOD']);