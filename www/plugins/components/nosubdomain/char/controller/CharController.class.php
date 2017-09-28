<?php

class CharController extends Controller {

    public function defaultAction() {
        $this->display->setComponentTpl("plugins/components/nosubdomain/char/tpl/default.tpl");
		$this->display->addParameter("_id_", $this->params['id']);
    }

    public function allAction() {
        $this->display->setComponentTpl("plugins/components/nosubdomain/char/tpl/all.tpl");
        
        $c = new CharactersModel();        
		$this->display->addParameter("_all_", $c->loadAllCharacters());
    }
    
}