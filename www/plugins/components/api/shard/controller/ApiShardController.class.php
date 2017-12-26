<?php
require_once('libs/PolPackUnpack.php');

class ApiShardController extends Controller {

    public function defaultAction() {
        $this->display->addParameter("_json_", array('error' => 'default controller'));
    }
    
    public function onlinedbAction() {
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
    
    public function onlineAction() {
        $chars = array();
        if (($fsocked = @fsockopen(POL_HOST, POL_AUX_PORT, $errno, $errstr, 2)) === FALSE) {
            $chars[] = array();
        } else {
            fputs($fsocked, packPolArray(array(
                POL_AUX_PASSWORD,
                "online"
            )) . "\n");
            
            $ret  = fgets($fsocked, 4096);
            $online = unPackPolArray($ret);
            
            fclose($fsocked);
            
            foreach ($online as $value) {
                $pieces = explode("|", $value);
                $chars[] = array('name' => $pieces[1],
                                'since' => $pieces[2],
                                'serial' => $pieces[0],
                                'cmd_level' => $pieces[3]);
            }
        }

        $this->display->addParameter("_json_", $chars);
    }
    
    public function newsAction() {
        $json = array();
        
        $news = new NewsModel();
        
        foreach ($news->loadAllNewsASC() as $value) {
            $sub = array();
            
            foreach ($value['elements'] as $subvalue) {
                $sub[] = array('Type' => $subvalue->type,
                                'Scope' => $subvalue->scope,
                                'ChangeText' => $subvalue->change_text,
                                'Author' => $subvalue->author);
            }
            
            $json[] = array('Published' => $value->published,
                                'Author' => $value->author,
                                'Title' => $value->title,
                                'NewsElements' => $sub);
        }
        
        $this->display->addParameter("_json_", $json);
        $this->display->addParameter("_raw_", true);
    }
}