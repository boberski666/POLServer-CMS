<?php

class DefaultController extends Controller {

    public function defaultAction() {
        $this->display->setComponentTpl("plugins/components/nosubdomain/default/tpl/default.tpl");
    }

}