<?php

class MainController {

    protected $display = null;
    protected $route = null;

    public function __construct(Display $display, Route $route) {
        $this->display = $display;
        $this->route = $route;
    }

    public function doAction($param) {
        $this->$param();
    }

    public function doInstall() {
        return false;
    }

    public function chooseAction() {
        $controllerClass = ControllerMapping::find($this->route->getController());
        if (class_exists($controllerClass)) {
            $controller = new $controllerClass($this->display, $this->route->getParams());
            $controller->init();
            $controller->doAction(ActionMapping::map($this->route->getAction()));
        } else {
            throw new Exception('Class not found');
        }

        $this->display->addParameter('debug', DEBUG);

        if (DEBUG) {
			$logs = R::getDatabaseAdapter()
		            ->getDatabase()
		            ->getLogger();
            //$this->display->addParameter('sql_log', $logs->getLogs());
            $this->display->addParameter('sql_log', R::getDatabaseAdapter()->getDatabase()->getPDO()->getLog());
            $this->display->addParameter('controller_log', ControllerMapping::$controllerDebug);
            $this->display->addParameter('action_log', ActionMapping::$actionDebug);
        }
    }

}