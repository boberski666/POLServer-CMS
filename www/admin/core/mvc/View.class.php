<?php

require_once(ROOT_ADMIN_DIR . '/../libs/Smarty/Smarty.class.php');

class View extends SmartyBC {

    public function __construct() {
        parent::__construct();
        $this->setTemplateDir(ROOT_ADMIN_DIR . '/../')
                        ->setCompileDir(ROOT_ADMIN_DIR . '/cache/tpl_compiled')
                        ->setCacheDir(ROOT_ADMIN_DIR . '/cache/tpl_cache')
                        ->setConfigDir(ROOT_ADMIN_DIR . '/cache/tpl_config')
                ->debugging = false;
                
        $this->load (ROOT_ADMIN_DIR . 'plugins/modules/');
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
    
	public function load($path) {
        $dir = opendir($path);
        if ($dir != false) {
            while (($file = readdir($dir)) !== false) {
                if (is_file($path . $file)) {
                    include ($path . $file);
                } elseif (is_dir($path . $file) && $file != '.' && $file != '..') {
                    $this->load($path . $file . DIRECTORY_SEPARATOR);
                }
            }
            closedir($dir);
        } else {
            throw new Exception('Unable to read dir ' . $path);
        }
    }

}
