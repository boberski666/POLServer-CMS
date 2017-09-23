<?php

class DefaultController extends Controller {

    public function defaultAction() {
		$this->display->setComponentTpl("admin/plugins/components/default/tpl/default.tpl");
    }

}