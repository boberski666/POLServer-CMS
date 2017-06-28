<?php

class ActionMapping {
	public static $actionDebug = array();

    public static function map($action = null) {
        $name = preg_replace_callback('/_([a-z])/', function($m) { return strtoupper($m[1]); }, $action) . 'Action';
        ActionMapping::$actionDebug[] = $name;

        return $name;
    }

}
