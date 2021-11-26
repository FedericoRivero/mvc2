<?php

ini_set('display_errors', 1);
ini_set('display_startup', 1);
error_reporting(E_ALL);

require_once '../vendor/autoload.php';
session_start();

if (file_exists("../.env")) {
	$dotenv = new Dotenv\Dotenv(__DIR__ .'/..');
	$dotenv->load();
}

use Aura\Router\RouterContainer;
use Illuminate\Database\Capsule\Manager as Capsule;

$capsule = new Capsule;

$capsule->addConnection([
		'driver'    => getenv('DB_DRIVER'),
		'host'      => getenv('DB_HOST'),
		'database'  => getenv('DB_NAME'),
		'username'  => getenv('DB_USER'),
		'password'  => getenv('DB_PASS'),
		'charset'   => 'utf8',
		'collation' => 'utf8_unicode_ci',
		'prefix'    => '',
	]);
$capsule->setAsGlobal();
$capsule->bootEloquent();

$contenedorDeRutas = new RouterContainer();

$request = Laminas\Diactoros\ServerRequestFactory::fromGlobals(
	$_SERVER,
	$_GET,
	$_POST,
	$_COOKIE,
	$_FILES
);

$mapa = $contenedorDeRutas->getMap();

$mapa->get(
	'home',
	'/mvc2/',
	['controller'=>'App\controllers\HomeController','action'=>'getHome']
);
$mapa->get(
	'ayuda',
	'/mvc2/ayuda',
	['controller'=>'App\controllers\HomeController','action'=>'getAyuda']
);
$mapa->get(
	'usuario',
	'/mvc2/usuario',
	['controller'=>'App\controllers\UsuarioController','action'=>'getUsuario']
);
$mapa->get(
	'productos',
	'/mvc2/productos',
	['controller'=>'App\controllers\ProductosController','action'=>'getProductos']
);
$mapa->get(
	'lista',
	'/mvc2/lista',
	['controller'=>'App\controllers\ListaController','action'=>'getLista']
);

$mapa->get(
	'Alumnos',
	'/mvc2/alumnos',
	['controller'=>'App\controllers\HomeController','action'=>'getAlumnos']
);

//------Mach whit route-------------
$matcher = $contenedorDeRutas->getMatcher();

$route = $matcher->match($request);
//------Mach whit route-------------

if (!$route) {
	echo 'no encuentro esa ruta';
} else {

	$capturadorDeDatos = $route->handler;

	$nombreControlador = $capturadorDeDatos['controller'];
	$nombreDeFuncion   = $capturadorDeDatos['action'];
	$Autentificacion   = $capturadorDeDatos['auth']??false;

	$log = $_SESSION['login'][2]??null;

	if ($Autentificacion && !$log) {
		$controlador     = new App\controllers\loginController;
		$nombreDeFuncion = 'getLogin';
		$response        = $controlador->$nombreDeFuncion($request);
	} else {

		$controlador = new $nombreControlador;
		$response    = $controlador->$nombreDeFuncion($request);

	}

	echo $response->getBody();

}
