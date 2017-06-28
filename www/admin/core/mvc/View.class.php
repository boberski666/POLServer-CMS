<?php

require_once(ROOT_ADMIN_DIR . '/../libs/Smarty/Smarty.class.php');

class View extends Smarty {

    public function __construct() {
        parent::__construct();
        $this->setTemplateDir(ROOT_ADMIN_DIR . '/../')
                        ->setCompileDir(ROOT_ADMIN_DIR . '/cache/tpl_compiled')
                        ->setCacheDir(ROOT_ADMIN_DIR . '/cache/tpl_cache')
                        ->setConfigDir(ROOT_ADMIN_DIR . '/cache/tpl_config')
                ->debugging = false;
    }

    public function display($template = null, $cache_id = null, $compile_id = null, $parent = null) {
        parent::display('tpl/' . ADMIN_TEMPLATE . '/index.tpl');
    }

    public function assignDisplay(Display $response) {
        $responseArr = $response->toArray();
        foreach ($responseArr as $key => $value) {
            $this->assign($key, $value);
        }
    }

}
