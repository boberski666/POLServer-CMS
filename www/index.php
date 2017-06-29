<?php header('Access-Control-Allow-Origin: *'); ?>
<?php
	error_reporting(E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED ^ E_STRICT);

	require('core/Config.class.php');
	Config::load();
	
	require_once('core/AutoLoader.class.php');
	AutoLoader::getInstance();

	Session::getInstance();
	require_once('core/RB.class.php');
	R::setup( 'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME, DB_USER, DB_PASSWORD );
	
	R::ext('xdispense', function( $type ){ 
        return R::getRedBean()->dispense( $type ); 
    });
	
	require_once('core/Installer.class.php');
	Installer::getInstance();
	
	$view = new View();
	$route = new Route();
	
	$raw=new Raw($route);
	$raw->check();
	
	$unicornEngine=new UnicornEngine($view, $route);
	$unicornEngine->run();