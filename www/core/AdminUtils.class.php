<?php

class AdminUtils {

    public static function isUserLogged() {
    	$s = Session::getInstance();

        if ($s->getAttribute('logged') == md5($s->getAttribute('username').'::'.$s->getAttribute('rank'))) {
            return true;
        } else {
            return false;
        }
    }

}
