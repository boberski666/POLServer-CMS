<?php

class Installer {

    const FileSufix = '.class.php';
    const ModelSufix = 'Model';

    private static $instance = null;
    protected $classDirs = array('core/', 'plugins/', 'admin/core/', 'admin/plugins/');
	protected $cacheFileDir = 'cache/';

    private function __construct() {
		if(!file_exists(ROOT_DIR . $this->cacheFileDir . 'model.installed'))
			$this->installModels();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    protected function installModels() {
        foreach ($this->classDirs as $path) {
            $this->readDir(ROOT_DIR . $path);
        }
        $this->save();
    }

    protected function readDir($path) {
        $dir = opendir($path);
        if ($dir != false) {
            while (($file = readdir($dir)) !== false) {
                if (is_file($path . $file) && strstr($file, self::ModelSufix.self::FileSufix)) {
					if($file != self::ModelSufix.self::FileSufix) {
						include($path . $file);
						$model = str_replace(self::FileSufix, '', $file);
						$m = new $model();
						$m->install();
					}
                } elseif (is_dir($path . $file) && $file != '.' && $file != '..') {
                    $this->readDir($path . $file . DIRECTORY_SEPARATOR);
                }
            }
            closedir($dir);
        } else {
            throw new Exception('Unable to read dir ' . $path);
        }
    }

    protected function save() {
        file_put_contents(ROOT_DIR . $this->cacheFileDir . 'model.installed', '');
    }

}
