<?php

final class UnicornEngine {

    protected $view = null;
    protected $route = null;
    protected $display = null;
    protected $mainController = null;

    public function __construct(View $view, Route $route) {
        $this->view = $view;
        $this->route = $route;
        $this->display = Display::getInstance();
        $this->mainController = new MainController($this->display, $this->route);
        
        if($this->route->getSubdomain() != 'api')
        	$this->view->debugging = DEBUG;
    }

    public function run() {
        try {
            $this->mainController->doAction('chooseAction');
        } catch (Exception $ex) {
            
        }

        if ($this->view) {
            $this->view->assignDisplay($this->display);
            $this->view->display($this->route->getSubdomain(), $this->route->getRel());
        }
    }

}
