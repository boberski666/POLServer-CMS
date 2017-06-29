<?php

class Smarty_Resource_Mysql extends Smarty_Resource_Custom
{
    protected $model;
    
    public function __construct()
    {
        $this->model = new PagesModel();
    }
    
    /**
     * Fetch a template and its modification time from database
     *
     * @param string $name template name
     * @param string $source template source
     * @param integer $mtime template modification timestamp (epoch)
     * @return void
     */
    protected function fetch($name, &$source, &$mtime)
    {
		list($exists, $pageData) = $this->model->loadPage($name);

        if ($exists) {
            $source = $pageData['source'];
            $mtime  = $pageData['modified'];
        } else {
            $source = '<center><h1>404 - Not Found</h1></center>';
            $mtime  = date('Y-m-d G:i:s');
        }
    }
}

$this->registerResource('mysql', new Smarty_Resource_Mysql());