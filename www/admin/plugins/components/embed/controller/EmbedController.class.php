<?php

class EmbedController extends Controller {

    public function defaultAction() {
        $this->display->setComponentTpl("admin/plugins/components/embed/tpl/default.tpl");
    }
	
	public function switcher($param) {
        $this->display->setComponentTpl("admin/plugins/components/embed/tpl/default.tpl");
        if (file_exists(ROOT_ADMIN_DIR . "plugins/embed/" . ucfirst($param) . ".php"))
            $this->display->addParameter("file", ROOT_ADMIN_DIR . "plugins/embed/" . ucfirst($param) . ".php");
    }

}