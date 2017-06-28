<?php

class LoginController extends Controller {

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