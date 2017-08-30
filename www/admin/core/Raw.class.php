<?php

final class Raw {

    protected $route = null;

    public function __construct(Route $route) {
        $this->route = $route;
    }

    public function check() {
		if($this->route->getController() == 'raw') {
			if (file_exists(ROOT_ADMIN_DIR . "plugins/raw/" . ucfirst($this->route->getAction()) . ".php")) {
				foreach ($this->route->getParams() as $key => $value) {
					$_GET[$key] = $value;
				}
				include(ROOT_ADMIN_DIR . "plugins/raw/" . ucfirst($this->route->getAction()) . ".php");
			
				exit;
			}
		}
        if($this->route->getController() == 'rawsecure') {
            if( AdminUtils::isUserLogged() ){
                if (file_exists(ROOT_ADMIN_DIR . "plugins/secure/" . ucfirst($this->route->getAction()) . ".php")) {
                    foreach ($this->route->getParams() as $key => $value) {
                        $_GET[$key] = $value;
                    }
                    include(ROOT_ADMIN_DIR . "plugins/secure/" . ucfirst($this->route->getAction()) . ".php");
                
                    exit;
                }
            }
		}
    }

}
