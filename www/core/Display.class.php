<?php

class Display {

    protected $parameters = array();
    private static $instance = null;

    private function __construct() {
        
    }

    private function __clone() {
        
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function getParameter($name) {
        if (array_key_exists($name, $this->parameters)) {
            return $this->parameters[$name];
        } else {
            return null;
        }
    }

    public function addParameter($name, $value) {
        $this->parameters[$name] = $value;
    }

    public function toArray() {
        return $this->parameters;
    }

    public function setComponentTpl($tpl = 'plugins/components/nosubdomain/default/tpl/default.tpl') {
        $this->parameters['ComponentTpl'] = $tpl;
    }

}
