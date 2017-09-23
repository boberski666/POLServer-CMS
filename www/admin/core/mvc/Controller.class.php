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
        $s = Session::getInstance();

		if( !AdminUtils::isUserLogged() ){
			$this->display->setComponentTpl("tpl/admin/login.tpl");
			if($s->is_set('msg')) {
				$this->display->addParameter("_message_", $s->getAttribute('msg'));
				$s->unsetAttribute('msg');
			}
		} else {
            if (method_exists($this, $param)) {
                ActionMapping::$actionDebug[] = $param;
                $this->$param();
            } else if (method_exists($this, 'switcher')) {
                ActionMapping::$actionDebug[] = 'switcher';
                $this->switcher(str_replace('Action', '', $param));
            } else {
                ActionMapping::$actionDebug[] = 'defaultAction';
                $this->defaultAction();
            }
        }
    }

    public function defaultAction() {
        
    }

}