<?php

class PageController extends Controller {

    public function defaultAction() {
        $this->display->setComponentTpl("plugins/components/nosubdomain/page/tpl/default.tpl");
		$this->display->addParameter("page", "mysql:home.htm");
    }
	
	public function switcher($param) {
        $this->display->setComponentTpl("plugins/components/nosubdomain/page/tpl/default.tpl");
		$this->display->addParameter("page", "mysql:".$param);
    }

}