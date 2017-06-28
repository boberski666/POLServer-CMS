<?php

class DefaultController extends Controller {

    public function defaultAction() {
        $this->display->setComponentTpl("plugins/components/nosubdomain/default/tpl/default.tpl");
        $this->display->addParameter("_message_", '<p style = "text-align:center;"><img src = "/images/dragon.png" style = "width: 300px; height: 248px;" /></p>');
    }

}