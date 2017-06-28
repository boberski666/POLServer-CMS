<?php

class Session {

    private static $instance = null;

    private function __construct() {
        ini_set('session.gc_maxlifetime', 43200);
        session_name(md5(str_replace('.', '', SITE_NAME)));
        session_start();
    }

    private function __clone() {
        
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    public function setAttribute($name, $value) {
        $_SESSION[$name] = $value;
    }

    public function unsetAttribute($name) {
        unset($_SESSION[$name]);
    }

    public function getAttribute($name) {
        return $_SESSION[$name];
    }

    public function is_set($name) {
        return isset($_SESSION[$name]);
    }

    public function destroy($all = false) {
        if (self::$instance != null || $all) {
            session_unset();
            session_destroy();
        }
    }

}
