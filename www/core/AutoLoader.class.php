<?php

class AutoLoader {

    const FileSufix = '.class.php';
    const CacheFile = 'classes.map';

    private static $instance = null;
    protected $classDirs = array('core/', 'plugins/');
    protected $skippedClasses = array('AutoLoader', 'Config');
    protected $cacheFileDir = 'cache/';
    protected $map = array();

    private function __construct() {
        $this->cacheFileDir = ROOT_DIR . $this->cacheFileDir;
        $this->getMap();
        spl_autoload_register(array($this, 'autoLoad'));
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self;
        }
        return self::$instance;
    }

    protected function getMap() {
        if (file_exists($this->cacheFileDir . self::CacheFile)) {
            $this->map = include($this->cacheFileDir . self::CacheFile);
        } else {
            /** Jeśli plik nie istnieje to generujemy nowy */
            $this->generateMap();
        }
    }

    public function autoLoad($name) {
        if (array_key_exists($name, $this->map) && file_exists($this->map[$name])) {
            require_once($this->map[$name]);
        } else {
            $this->generateMap();
            if (array_key_exists($name, $this->map) && file_exists($this->map[$name])) {
                require_once ($this->map[$name]);
            }
        }
    }

    protected function generateMap() {
        foreach ($this->classDirs as $path) {
            $this->readDir(ROOT_DIR . $path);
        }
        $this->saveMap();
    }

    protected function readDir($path) {
        $dir = opendir($path);
        if ($dir != false) {
            while (($file = readdir($dir)) !== false) {
                if (is_file($path . $file) && strstr($file, self::FileSufix)) {
                    $this->map[str_replace(self::FileSufix, '', $file)] = $path . $file;
                } elseif (is_dir($path . $file) && $file != '.' && $file != '..') {
                    $this->readDir($path . $file . DIRECTORY_SEPARATOR);
                }
            }
            closedir($dir);
        } else {
            throw new Exception('Unable to read dir ' . $path);
        }
    }

    protected function saveMap() {
        $str = "<?php\nreturn array(";
        foreach ($this->map as $key => $val):
            if (!in_array($key, $this->skippedClasses)):
                $str .= "'$key'=>'$val',";
            endif;
        endforeach;

        $str .= ');';
        file_put_contents($this->cacheFileDir . self::CacheFile, $str);
    }

}
