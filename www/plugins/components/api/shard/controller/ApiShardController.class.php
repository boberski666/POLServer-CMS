<?php

class ApiShardController extends Controller {

    public function defaultAction() {
        $this->display->addParameter("_json_", array('error' => 'default controller'));
    }
    
    public function onlineAction() {
        $chars = array();
        $com = new CharactersOnlineModel();
        $online = $com->loadOnlineCharacters();
        
        foreach ($online as $value) {
            $chars[] = array('name' => $value->char_name,
                             'since' => $value->login_time,
                             'serial' => $value->char_id,
                             'cmd_level' => $value->char_cmdlevel);
        }
        
        $this->display->addParameter("_json_", $chars);
    }
    
}