<?php
class AdminUserModel extends Model {
    public function __construct() {
        parent::__construct('users', function() {
        	$inst = R::xdispense( 'users' );
			$inst->username = 'admin';
			$inst->password = '21232f297a57a5a743894a0e4a801fc3';
			$inst->rank = 6;
			$inst->create = date('c');
			$inst->lastLogin = date('c');

			R::store( $inst );
        });
    }
    
     public function isUserCanLogin($username = '', $password = '') {
     	$user = parent::loadSingle( 'username LIKE ? AND password LIKE ?', [ $username, $password ] );
     	if(count($user) == 0) {
     		return array(false, $user);
	    } else {
	    	return array(true, $user);
	    }
	       
    }

}