<?php

class PageController extends Controller {

	public function defaultAction() {
		$s = Session::getInstance();

		if( !AdminUtils::isUserLogged() ){
			$this->display->setComponentTpl("tpl/admin/login.tpl");
			if($s->is_set('msg')) {
				$this->display->addParameter("_message_", $s->getAttribute('msg'));
				$s->unsetAttribute('msg');
			}
		} else {
			$this->display->setComponentTpl("admin/plugins/components/page/tpl/default.tpl");
			
			$m = new ComponentsModel();
			$this->display->addParameter("_menu_",  $m->loadByType(1));
		}
	}

}