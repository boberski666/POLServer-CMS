<?php

class ControllerMapping {

    const DEFAULT_CONTROLLER = 'DefaultController';
    public static $controllerDebug = array();

    public static function find($ctn = null, $subdomain = "") {
        $controller = '';

        $name = ucwords(preg_replace_callback('/[^a-z0-9.]/', function($m) { return strtoupper($m[1]); }, $subdomain), '.') . ucwords(preg_replace_callback('/[^a-z0-9.]/', function($m) { return  strtoupper($m[1]); }, $ctn), '.') . 'Controller';
        $name = str_replace('.', '', $name);
        ControllerMapping::$controllerDebug[] = $name;

        try {
            if (class_exists($name))
                $controller = $name;
            else {
            	$controller = ucwords(preg_replace_callback('/[^a-z0-9.]/', function($m) { return  strtoupper($m[1]); }, $subdomain), '.') . self::DEFAULT_CONTROLLER;
            	$controller = str_replace('.', '', $controller);
				ControllerMapping::$controllerDebug[] = $controller;
            
            	if (!class_exists($controller)) {
            		$controller = self::DEFAULT_CONTROLLER;
            		ControllerMapping::$controllerDebug[] = $controller;
            	}
            }
        } catch (Exception $e) {
            
        }

        return $controller;
    }

}
