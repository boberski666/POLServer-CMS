<?php

require_once(ROOT_DIR . 'libs/Smarty/SmartyBC.class.php');

class View extends SmartyBC {

    public function __construct() {
        parent::__construct();
        $this->setTemplateDir(ROOT_DIR)
                        ->setCompileDir(ROOT_DIR . 'cache/tpl_compiled')
                        ->setCacheDir(ROOT_DIR . 'cache/tpl_cache')
                        ->setConfigDir(ROOT_DIR . 'cache/tpl_config')
                ->debugging = false;
    }

    public function display($template = null, $rel = null, $cache_id = null, $compile_id = null, $parent = null) {
        if($template == null) {
        	if($rel == null) {
	        	if (file_exists(ROOT_DIR . 'tpl/' . TEMPLATE . '/index.tpl'))
	            	parent::display('tpl/' . TEMPLATE . '/index.tpl');
	            else {
	            	if (file_exists(ROOT_DIR . 'tpl/' . TEMPLATE . '/404/index.tpl'))
		            	parent::display('tpl/' . TEMPLATE . '/404/index.tpl');
		            else 
		            	parent::display('tpl/404/index.tpl');
	            }
        	} else {
	        	if (file_exists(ROOT_DIR . 'tpl/' . TEMPLATE . '/' . $rel . '/index.tpl'))
	            	parent::display('tpl/' . TEMPLATE . '/' . $rel . '/index.tpl');
	            else {
	            	if (file_exists(ROOT_DIR . 'tpl/' . TEMPLATE . '/' . $rel . '/404/index.tpl'))
		            	parent::display('tpl/' . TEMPLATE .  '/' . $rel . '/404/index.tpl');
		            else 
		            	parent::display('tpl/404/index.tpl');
	            }		
        	}
        } else {
        	if($rel == null) {
	        	if (file_exists(ROOT_DIR . 'tpl/' . $template . '/index.tpl'))
	            	parent::display('tpl/' . $template . '/index.tpl');
	            else {
	            	if (file_exists(ROOT_DIR . 'tpl/' . $template . '/404/index.tpl'))
		            	parent::display('tpl/' . $template . '/404/index.tpl');
		            else 
		            	parent::display('tpl/404/index.tpl');
	            }
        	} else {
	        	if (file_exists(ROOT_DIR . 'tpl/' . $template . '/' . $rel . '/index.tpl'))
	            	parent::display('tpl/' . $template . '/' . $rel . '/index.tpl');
	            else {
	            	if (file_exists(ROOT_DIR . 'tpl/' . $template . '/' . $rel . '/404/index.tpl'))
		            	parent::display('tpl/' . $template .  '/' . $rel . '/404/index.tpl');
		            else 
		            	parent::display('tpl/404/index.tpl');
	            }		
        	}
        }
    }

    public function assignDisplay(Display $response) {
        $responseArr = $response->toArray();
        foreach ($responseArr as $key => $value) {
            $this->assign($key, $value);
        }
    }

}
