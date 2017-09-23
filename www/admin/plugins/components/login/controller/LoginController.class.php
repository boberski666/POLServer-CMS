<?php

class LoginController {
    
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

		if( !AdminUtils::isUserLogged() ){
			$user = new AdminUserModel();
			
			list($exists, $userData) = $user->isUserCanLogin($_POST['username'], md5($_POST['password']));

			if($exists) {
				$s->setAttribute('logged', md5($userData['username'].'::'.$userData['rank']));
				$s->setAttribute('username', $userData['username']);
				$s->setAttribute('rank', $userData['rank']);
			} else {
				$s->setAttribute('msg', 'Wrong username or password!');
			}
			
			header('Location: /admin/');
		} else {
			header('Location: /admin/');
		}
		
    }

}