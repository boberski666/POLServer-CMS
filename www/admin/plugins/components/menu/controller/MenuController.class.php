<?php

class MenuController extends Controller {

	public function defaultAction() {
		$this->display->setComponentTpl("admin/plugins/components/menu/tpl/default.tpl");
	}

}