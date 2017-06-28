<?php

class Controller {

    protected $display = null;
    protected $params = null;

    public function __construct(Display $display, $params = null) {
        $this->display = $display;
        $this->params = $params;
    }

    public function init() {
        
    }

    public function doAction($param) {
        if (method_exists($this, $param)) {
			ActionMapping::$actionDebug[] = $param.'Action';
            $this->$param();
		} else if (method_exists($this, 'switcher')) {
			ActionMapping::$actionDebug[] = 'switcher';
            $this->switcher($param);
        } else {
        	ActionMapping::$actionDebug[] = 'defaultAction';
            $this->defaultAction();
        }
    }

    public function defaultAction() {
        
    }

}