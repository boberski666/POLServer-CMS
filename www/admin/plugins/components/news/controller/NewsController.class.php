<?php

class NewsController extends Controller {

	public function defaultAction() {
		$this->display->setComponentTpl("admin/plugins/components/news/tpl/default.tpl");
	}

}