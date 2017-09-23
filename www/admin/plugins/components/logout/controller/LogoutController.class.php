<?php

class LogoutController extends Controller {
    
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
    
    public function defaultAction() {
		$s = Session::getInstance();

		if( AdminUtils::isUserLogged() ){
			$s->unsetAttribute('logged');
			$s->unsetAttribute('username');
			$s->unsetAttribute('rank');
			
			$s->setAttribute('msg', 'Signed out!');

			header('Location: /admin/');
		} else {
			header('Location: /admin/');
		}
    }

}