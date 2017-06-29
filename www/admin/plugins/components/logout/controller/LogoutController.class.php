<?php

class LogoutController extends Controller {

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