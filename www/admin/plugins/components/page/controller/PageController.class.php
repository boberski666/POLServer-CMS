<?php

class PageController extends Controller {

	public function defaultAction() {
		$this->display->setComponentTpl("admin/plugins/components/page/tpl/default.tpl");
	}

}