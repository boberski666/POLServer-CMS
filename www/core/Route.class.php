<?php

final class Route {

    protected $route = array();
    protected $controller = null;
    protected $action = null;
    protected $params = array();
    protected $subdomain = null;
    protected $rel = null;

    public function __construct() {
        $this->subdomain = $_SERVER['HTTP_HOST'];
        $this->subdomain = str_replace("." . DOMAIN_SHORT, "", $this->subdomain);
        $this->subdomain = str_replace(DOMAIN_SHORT, "", $this->subdomain);
        $this->subdomain = str_replace("www.", "", $this->subdomain);
        $this->subdomain = str_replace("www", "", $this->subdomain);
        $this->subdomain = preg_replace_callback('/[^a-z0-9.]/', function($m) { return strtoupper($m[1]); }, $this->subdomain);
        
        if(empty($this->subdomain))
        	$this->subdomain = null;

        $this->route = explode('/', trim(isset($_GET['route']) ? $_GET['route'] : '', '/'));
        
        if($this->route[0] == 'rel') {
        	$this->controller = 'default';
	        $this->action = 'default';
	        
	        $this->rel = $this->route[1];
        } else {
	        $this->controller = $this->route[0] ? $this->route[0] : 'default';
	
	        if ($paramsCount = count($this->route))
	            $paramsCount -= $this->route[$paramsCount - 1] == 'debug' ? 1 : 0;
	
	        if ($paramsCount > 1 && !($paramsCount % 2)) {
	            $this->action = isset($this->route[1]) ? $this->route[1] : 'default';
	            $i = 2;
	        } else {
	            $this->action = 'default';
	            $i = 1;
	        }
	
	        if ($this->controller == 'debug' && ALLOW_DEBUG == 1) {
	            if ($this->action == 'false' || $this->action == 'none' || $this->action == 'null' || $this->action == 'off' || $this->action == '0') {
	                unset($_SESSION['cms_debug']);
	            }
	            else {
	                $_SESSION['cms_debug'] = 1;
				}
	
	            $this->controller = 'default';
	            $this->action = 'default';
	        }
        }

        while ($i < count($this->route)) {
            if (isset($this->route[$i]) and isset($this->route[$i + 1])) {
                if ($this->route[$i] == 'debug' && ALLOW_DEBUG == 1) {
                    if ($this->route[$i + 1] == 'false' || $this->route[$i + 1] == 'none' || $this->route[$i + 1] == 'null' || $this->route[$i + 1] == 'off' || $this->route[$i + 1] == '0') {
                        unset($_SESSION['cms_debug']);
                    }
                    else {
                        $_SESSION['cms_debug'] = 1;
            		}
                }
                $this->params[$this->route[$i]] = $this->route[$i + 1];
                
                if($this->route[$i] == 'rel')
                	$this->rel = $this->route[$i + 1];
            } else if (isset($this->route[$i]) and !isset($this->route[$i + 1])) {
                if ($this->route[$i] == 'debug' && ALLOW_DEBUG == 1) {
                    $_SESSION['cms_debug'] = 1;
                }
                else {
                    $this->params[$this->route[$i]] = 'null';
				}
            }
            $i+=2;
        }

        if (isset($_SESSION['cms_debug']) && ALLOW_DEBUG == 1) {
            define('DEBUG', true);
        } else {
            define('DEBUG', false);
        }
    }

    public function getController() {
        return $this->controller;
    }

    public function getAction() {
        return $this->action;
    }

    public function getParams() {
        return $this->params;
    }

    public function getSubdomain() {
        return $this->subdomain;
    }
    
    public function getRel() {
        return $this->rel;
    }

}
